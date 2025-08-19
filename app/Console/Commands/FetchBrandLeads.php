<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchBrandLeads extends Command
{
    protected $signature = 'fetch:brand-leads'; // Command name for cron job
    protected $description = 'Fetch new brand leads from API and store in database';

    public function handle()
    {
        $latestRecord = DB::table('brand_leads')->orderBy('id', 'DESC')->first();
        $latestId = $latestRecord ? $latestRecord->id : 0;

        $apiUrl = 'https://securepay.designtechpro.com/brand-leads-api';
        $apiToken = env('BRAND_API_TOKEN');

        $response = Http::withHeaders([
            'X-API-TOKEN' => $apiToken,
            'Accept' => 'application/json',
        ])->get($apiUrl, ['latest_id' => $latestId]);

        if ($response->failed()) {
            Log::error('Failed to fetch brand leads', ['error' => $response->body()]);
            return;
        }

        $data = $response->json();
        if (!$data['success']) {
            Log::error('API request failed', ['response' => $data]);
            return;
        }

        foreach ($data['data'] as $record) {
            DB::table('brand_leads')->insert([
                'id' => $record['id'], 
                'brand_name' => $record['brand_name'],
                'name' => $record['name'],
                'email' => $record['email'],
                'phone' => $record['phone'],
                'service' => $record['service'],
                'message' => $record['message'],
                'url' => $record['url'],
                'ip_address' => $record['ip_address'],
                'city' => $record['city'],
                'country' => $record['country'],
                'internet_connection' => $record['internet_connection'],
                'zipcode' => $record['zipcode'],
                'region' => $record['region'],
                'created_at' => $record['created_at'],
                'updated_at' => $record['updated_at'],
            ]);
        }

        Log::info('Brand leads fetched successfully', ['new_records' => count($data['data'])]);
    }
}
