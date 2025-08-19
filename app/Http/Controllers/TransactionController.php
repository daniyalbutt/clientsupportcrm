<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use DateTime;
use DateTimeZone;

class TransactionController extends Controller
{

    public function index()
    {
        $transactions = Transaction::all();
        return view('transactions.index', compact('transactions'));
    }

    public function fetchAndStoreTransactions()
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName('5zPvH3n5xC3Z');
        $merchantAuthentication->setTransactionKey('656LNL953kBT7hyF');
        // $merchantAuthentication->setName('74uMeZN5KgYc');
        // $merchantAuthentication->setTransactionKey('5aNXe9qLy26C374x');

        // $firstSettlementDate = new DateTime("2025-01-01T06:00:00Z");
        // $lastSettlementDate = new DateTime();
        // $lastSettlementDate->setDate(2025, 01, 31);
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
            foreach ($response->getBatchList() as $batch) {
                $batchId = $batch->getBatchId();
                $this->getTransactionsForBatch($merchantAuthentication, $batchId);
            }
            return response()->json(['message' => 'Transactions stored successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to fetch transactions'], 500);
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
                if (Transaction::where('transaction_id', $transId)->exists()) {
                    continue; // Skip inserting if transaction exists
                }
                $billingInfo = $this->getBillingInfo($merchantAuthentication, $transId);
                Transaction::updateOrCreate(
                    ['transaction_id' => $transId],
                    [
                        'status' => $transaction->getTransactionStatus(),
                        'amount' => $transaction->getSettleAmount(),
                        'payment_date' => $transaction->getSubmitTimeUTC(),
                        'email' => $billingInfo['email'],
                        'phone' => $billingInfo['phone'],
                        'batch_id' => $batchId
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
                'email' => $customer ? $customer->getEmail() : 'N/A',
                'phone' => $billingInfo && $billingInfo->getPhoneNumber() ? $billingInfo->getPhoneNumber() : 'N/A',
            ];
        }

        return ['email' => 'N/A', 'phone' => 'N/A'];
    }
}
