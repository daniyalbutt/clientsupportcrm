<?php

namespace App\Console\Commands;

use App\Models\RingCentralCallLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FetchRingCentralLogs extends Command
{
    protected $signature = 'fetch:rc-data'; // Command name for cron job
    protected $description = 'Fetch new RingCentral Logs from API and store in database';

    public function handle()
    {
        // Retrieve the required credentials from the environment
        $clientId = env('RC_CLIENT_ID');
        $clientSecret = env('RC_CLIENT_SECRET');
        $jwtToken = env('RC_JWT_TOKEN');
        $server = "https://platform.ringcentral.com";

        if (!$clientSecret) {
            Log::error('RingCentral API Key is missing.');
            return;
        }

        // Base64 encode Client ID and Secret
        $authHeader = base64_encode("$clientId:$clientSecret");

        // Set the URL for the OAuth token request
        $url = "$server/restapi/oauth/token";

        // Prepare the POST data for the OAuth token request
        $data = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwtToken
        ];

        // Use Laravel HTTP Client to make the request for the token
        $response = Http::withHeaders([
            'Authorization' => "Basic $authHeader",
            'Content-Type' => 'application/x-www-form-urlencoded',
        ])->post($url, $data);

        // Check if the request was successful
        if (!$response->successful()) {
            Log::error('Failed to fetch access token from RingCentral.', ['response' => $response->body()]);
            return;
        }

        // Decode the JSON response
        $result = $response->json();

        if (!isset($result['access_token'])) {
            Log::error('Failed to retrieve access token from RingCentral.', ['response' => $response->body()]);
            return;
        }

        $accessToken = $result['access_token'];

        // Define the URL for retrieving the call logs
        $server_access = "https://platform.ringcentral.com";
        $dateFrom = "2024-03-01T00:00:00Z";
        $dateTo   = "2024-03-31T23:59:59Z";
        $url_access = "$server_access/restapi/v1.0/account/~/call-log?dateFrom=$dateFrom&dateTo=$dateTo";

        // Use Laravel HTTP Client to make the request for call logs
        $response_access = Http::withHeaders([
            'Authorization' => "Bearer $accessToken",
            'Content-Type' => 'application/json',
        ])->get($url_access);

        // Check if the request was successful
        if (!$response_access->successful()) {
            Log::error('Failed to fetch call logs from RingCentral.', ['response' => $response_access->body()]);
            return;
        }

        // Decode the JSON response for call logs
        $callLogs = $response_access->json();

        // Check if call logs exist
        if (!isset($callLogs['records']) || empty($callLogs['records'])) {
            Log::info('No call log records returned from RingCentral.', ['response' => $response_access->body()]);
            return;
        }

        $allData = [];

        // Iterate over the call logs and prepare data for insertion
        foreach ($callLogs['records'] as $record) {
            // Check for duplicates before inserting
            $existingRecord = RingCentralCallLog::where('started_at', $record['started_at'])
                ->where('caller_number', $record['from']['phoneNumber'] ?? 'Unknown')
                ->exists();

            if (!$existingRecord) {
                $allData[] = [
                    'started_at' => date("Y-m-d H:i:s", strtotime($record['startTime'])),
                    'answered_at' => null,
                    'finished_at' => $record['result'] ?? null,
                    'direction' => $record['direction'],
                    'caller_number' => $record['from']['phoneNumber'] ?? 'Unknown',
                    'dest_number' => $record['to']['phoneNumber'] ?? 'Unknown',
                    'call_sec' => $record['duration'],
                    'cld' => $record['to']['phoneNumber'] ?? 'Unknown',
                    'cli' => $record['from']['phoneNumber'] ?? 'Unknown',
                    'country_code' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // If new records are found, insert them into the database
        if (!empty($allData)) {
            RingCentralCallLog::insert($allData); // Bulk insert for better performance
            Log::info('RingCentral logs fetched successfully', ['new_records' => count($allData)]);
        } else {
            Log::info('No new RingCentral logs found.');
        }
    }
}
