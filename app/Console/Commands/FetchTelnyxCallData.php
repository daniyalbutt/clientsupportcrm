<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TelnyxCallLog;
use Illuminate\Support\Facades\Log;

class FetchTelnyxCallData extends Command
{
    protected $signature = 'fetch:telnyx-data'; // Command name for cron job
    protected $description = 'Fetch new TelnyxCall Logs from API and store in database';

    public function handle()
    {
        $allData = [];
        $pageLimit = 50;
        $pageSize = 100;
        $apiKey = env('TELNYX_API_KEY'); // Use config instead of env()

        if (!$apiKey) {
            Log::error('Telnyx API Key is missing.');
            return;
        }

        $requiredKeys = ["started_at", "answered_at", "finished_at", "direction", "caller_number", "dest_number", "call_sec", "cld", "cli", "country_code"];

        for ($pageNumber = 1; $pageNumber <= $pageLimit; $pageNumber++) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.telnyx.com/v2/detail_records?filter[record_type]=sip-trunking&page[number]=$pageNumber&page[size]=$pageSize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json',
                    'Authorization: Bearer ' . $apiKey
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode !== 200 || !$response) {
                Log::error("Failed to fetch data from Telnyx. HTTP Code: $httpCode");
                break;
            }

            $decodedResponse = json_decode($response, true);
            if (!isset($decodedResponse['data']) || empty($decodedResponse['data'])) {
                break; // Stop if no more data
            }

            foreach ($decodedResponse['data'] as $record) {
                $filteredRecord = array_intersect_key($record, array_flip($requiredKeys));

                // Ensure required fields have default values
                $filteredRecord = array_merge([
                    'caller_number' => 'N/A',
                    'direction' => 'N/A',
                    'cld' => 'N/A',
                    'cli' => 'N/A'
                ], $filteredRecord);

                // Check for duplicates before inserting
                $existingRecord = TelnyxCallLog::where('started_at', $filteredRecord['started_at'])
                    ->where('caller_number', $filteredRecord['caller_number'])
                    ->exists();

                if (!$existingRecord) {
                    $allData[] = [
                        'started_at' => $filteredRecord['started_at'] ?? null,
                        'answered_at' => $filteredRecord['answered_at'] ?? null,
                        'finished_at' => $filteredRecord['finished_at'] ?? null,
                        'direction' => $filteredRecord['direction'],
                        'caller_number' => $filteredRecord['caller_number'],
                        'dest_number' => $filteredRecord['dest_number'] ?? null,
                        'call_sec' => $filteredRecord['call_sec'] ?? null,
                        'cld' => $filteredRecord['cld'],
                        'cli' => $filteredRecord['cli'],
                        'country_code' => $filteredRecord['country_code'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        if (!empty($allData)) {
            TelnyxCallLog::insert($allData); // Bulk insert for better performance
            Log::info('Telnyx call logs fetched successfully', ['new_records' => count($allData)]);
        } else {
            Log::info('No new Telnyx call logs found.');
        }
    }
}
