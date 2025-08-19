<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NexbyteTransaction;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Log;

class FetchNexByteTransactions extends Command
{
    protected $signature = 'fetch:nexbyte';
    protected $description = 'Fetch new transactions from API and store in database';

    public function handle()
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(env('NEXBYTE_LOG_KEY'));
        $merchantAuthentication->setTransactionKey(env('NEXBYTE_LOG_SECRET'));

        // $firstSettlementDate = new DateTime("2025-05-01T00:00:00Z");
        // $lastSettlementDate = new DateTime();
        // $lastSettlementDate->setDate(2025, 05, 05);
        // $lastSettlementDate->setTime(23, 59, 59);
        // $lastSettlementDate->setTimezone(new DateTimeZone('UTC'));

        $firstSettlementDate = new DateTime('first day of this month 00:00:00', new DateTimeZone('UTC'));
        $lastSettlementDate = new DateTime('last day of this month 23:59:59', new DateTimeZone('UTC'));

        $request = new AnetAPI\GetSettledBatchListRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setFirstSettlementDate($firstSettlementDate);
        $request->setLastSettlementDate($lastSettlementDate);

        $controller = new AnetController\GetSettledBatchListController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
            $batchList = $response->getBatchList();
            if ($batchList && is_array($batchList)) {
                foreach ($batchList as $batch) {
                    $batchId = $batch->getBatchId();
                    $this->getTransactionsForBatch($merchantAuthentication, $batchId);
                }
                Log::info('New Transactions stored successfully');
            } else {
                Log::warning('No batches found in the response.');
            }
        } else {
            Log::info('Failed to fetch transactions');
        }
    }


    private function getTransactionsForBatch($merchantAuthentication, $batchId)
    {
        $request = new AnetAPI\GetTransactionListRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setBatchId($batchId);

        $controller = new AnetController\GetTransactionListController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
            foreach ($response->getTransactions() as $transaction) {
                $transId = $transaction->getTransId();

                // Check if transaction exists and if name is missing
                $existingTransaction = NexbyteTransaction::where('transaction_id', $transId)->first();

                if ($existingTransaction) {
                    if (empty($existingTransaction->name)) {
                        // ✅ Fetch billing info only if name is missing
                        $billingInfo = $this->getBillingInfo($merchantAuthentication, $transId);

                        if (!empty(trim($billingInfo['name'])) && $billingInfo['name'] !== "N/A") {
                            // ✅ Update only the name field
                            $existingTransaction->update(['name' => $billingInfo['name']]);
                        }
                    }

                    // Update last_4 field if it's empty
                    if (empty($existingTransaction->last_4)) {
                        // Use getLastFourDigits() method to get the actual last 4 digits of the card number
                        $masked_card = $transaction->getAccountNumber(); // Correct way to get last 4 digits
                        preg_match('/\d+/', $masked_card, $matches);
                        $lastFour = $matches[0];

                        if (!empty(trim($lastFour)) && $lastFour !== "N/A") {
                            $existingTransaction->update(['last_4' => $lastFour]);
                        }
                    }
                    continue; // Skip inserting if transaction already exists
                }

                // ✅ Insert new transaction if it doesn't exist
                $billingInfo = $this->getBillingInfo($merchantAuthentication, $transId);
                $masked_card = $transaction->getAccountNumber();
                preg_match('/\d+/', $masked_card, $matches);
                $lastFour = $matches[0]; // Correct way to get last 4 digits

                NexbyteTransaction::updateOrCreate(
                    ['transaction_id' => $transId],
                    [
                        'status' => $transaction->getTransactionStatus(),
                        'amount' => $transaction->getSettleAmount(),
                        'payment_date' => $transaction->getSubmitTimeUTC(),
                        'name' => $billingInfo['name'],
                        'email' => $billingInfo['email'],
                        'phone' => $billingInfo['phone'],
                        'batch_id' => $batchId,
                        'last_4' => $lastFour // Correct field for last 4 digits
                    ]
                );
            }
        }

    }


    private function getBillingInfo($merchantAuthentication, $transId)
    {
        $request = new AnetAPI\GetTransactionDetailsRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setTransId($transId);

        $controller = new AnetController\GetTransactionDetailsController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);

        if ($response != null && $response->getMessages()->getResultCode() == "Ok") {
            $transaction = $response->getTransaction();
            $billingInfo = $transaction->getBillTo();
            $customer = $transaction->getCustomer();

            return [
                'name' => ($billingInfo) ? $billingInfo->getFirstName() . ' ' . $billingInfo->getLastName() : "N/A",
                'email' => $customer ? $customer->getEmail() : 'N/A',
                'phone' => $billingInfo && $billingInfo->getPhoneNumber() ? $billingInfo->getPhoneNumber() : 'N/A',
            ];
        }

        return ['email' => 'N/A', 'phone' => 'N/A'];
    }
}
