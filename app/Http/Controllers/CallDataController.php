<?php

namespace App\Http\Controllers;

use App\Models\TelnyxCallLog;

class CallDataController extends Controller
{
    public function fetchCallData()
    {
        $allData = [];
        $pageLimit = 50;
        $pageSize = 100;
        $requiredKeys = ["started_at", "answered_at", "finished_at", "direction", "caller_number", "dest_number", "call_sec", "cld", "cli", "country_code"];

        for ($pageNumber = 1; $pageNumber <= $pageLimit; $pageNumber++) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.telnyx.com/v2/detail_records?filter[record_type]=sip-trunking&page[number]=$pageNumber&page[size]=$pageSize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 1,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Authorization: Bearer ' . env('TELNYX_API_KEY')
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $decodedResponse = json_decode($response, true);

            if (isset($decodedResponse['data']) && is_array($decodedResponse['data'])) {
                foreach ($decodedResponse['data'] as $record) {
                    $filteredRecord = array_intersect_key($record, array_flip($requiredKeys));
                    $allData[] = $filteredRecord;

                    $filteredRecord['caller_number'] = $filteredRecord['caller_number'] ?? 'N/A';
                    $filteredRecord['direction'] = $filteredRecord['direction'] ?? 'N/A';
                    $filteredRecord['cld'] = $filteredRecord['cld'] ?? 'N/A';
                    $filteredRecord['cli'] = $filteredRecord['cli'] ?? 'N/A';

                    // Check if the record already exists in the database
                    $existingRecord = TelnyxCallLog::where('started_at', $filteredRecord['started_at'])
                        ->where('caller_number', $filteredRecord['caller_number'])
                        ->first();

                    if (!$existingRecord) {
                        // Insert the filtered data into the database
                        TelnyxCallLog::create([
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
                        ]);
                    }
                }
            } else {
                break;
            }
        }

        return view('call-data.index', ['callData' => $allData]);
    }

    public function fetchRCCallData()
    {


        $accessToken = '1QleVuAIzmdbHYAYphX6Zn5fjFaDQDVDHfxHUMMn5FfJ'; // Replace with your actual access token
        $url = 'https://platform.ringcentral.com/restapi/v1.0/account/26EaOjr50Gqbd96kHcnN61/call-log?view=Simple&withRecording=false&page=1&perPage=100';

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer ' . $accessToken
        ]);

        // Execute cURL request and get the response
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        // Process the response
        dd($response);


        return view('call-data.ring-central', ['callData' => $response]);
    }
}
// INBOUND (CLIENT CALL)
// OUTBOUND (SALE CALL)