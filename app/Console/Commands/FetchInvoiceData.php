<?php

namespace App\Console\Commands;

use App\Models\DBInvoice;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchInvoiceData extends Command
{
    protected $signature = 'fetch:invoice-data';

    protected $description = 'Fetch new invoice data from API and store in database';

    public function handle()
    {
        $latestRecord = DBInvoice::latest()->first();
        $latestId = $latestRecord ? $latestRecord->id : 0;

        $apiUrl = 'https://projectwall.net/api/invoice-bank';
        $apiToken = env('BRAND_API_TOKEN');

        $response = Http::withHeaders([
            'X-API-TOKEN' => $apiToken,
            'Accept' => 'application/json',
        ])->withoutVerifying()->get($apiUrl, ['latest_id' => $latestId]);

        if ($response->failed()) {
            Log::error('Failed to fetch Invoice Data', ['error' => $response->body()]);
            return;
        }

        $data = $response->json();
        if (!$data['success']) {
            Log::error('API request failed', ['response' => $data]);
            return;
        }

        // Log the data coming from the API
        // Log::info('Data fetched from API', ['data' => $data]);

        $insertedRecords = 0;

        foreach ($data['data'] as $record) {
            // Ensure required fields exist before inserting
            if (!isset($record['id'], $record['invoice_number'])) {
                Log::warning('Skipping invalid record', ['record' => $record]);
                continue;
            }

            // Check if the invoice already exists to avoid duplicates
            $existingInvoice = DBInvoice::where('id', $record['id'])->first();
            if ($existingInvoice) {
                Log::info('Skipping duplicate invoice', ['id' => $record['id']]);
                continue;
            }

            // Log the record data before insertion
            // Log::info('Inserting record', ['record' => $record]);

            // Insert data into the database
            $db_invoice = new DBInvoice();
            $db_invoice->id = $record['id'];
            $db_invoice->name = $record['name'] ?? null;
            $db_invoice->email = $record['email'] ?? null;
            $db_invoice->contact = $record['contact'] ?? null;
            $db_invoice->brand = $record['brand'] ?? null;
            $db_invoice->service = $record['service'] ?? null;
            $db_invoice->package = $record['package'] ?? null;
            $db_invoice->currency = $record['currency'] ?? null;
            $db_invoice->client_id = $record['client_id'] ?? null;
            $db_invoice->invoice_number = $record['invoice_number'];
            $db_invoice->invoice_date = $record['invoice_date'] ?? null;
            $db_invoice->sales_agent_id = $record['sales_agent_id'] ?? null;
            $db_invoice->discription = $record['discription'] ?? null;
            $db_invoice->amount = $record['amount'] ?? 0;
            $db_invoice->payment_status = $record['payment_status'] ?? 'pending';
            $db_invoice->payment_type = $record['payment_type'] ?? null;
            $db_invoice->custom_package = $record['custom_package'] ?? null;
            $db_invoice->transaction_id = $record['transaction_id'] ?? null;
            $db_invoice->createform = $record['createform'] ?? null;
            $db_invoice->merchant_id = $record['merchant_id'] ?? null;
            $db_invoice->created_at = $record['created_at'] ?? now();
            $db_invoice->updated_at = $record['updated_at'] ?? now();
            $db_invoice->save();
            $insertedRecords++;
        }

        Log::info('Invoice Data fetched successfully', ['new_records' => $insertedRecords]);
    }
}
