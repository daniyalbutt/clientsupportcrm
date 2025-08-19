<?php

namespace App\Http\Controllers;

use App\Models\PWBrand;
use Illuminate\Http\Request;
use App\Models\BrandLeads;
use App\Models\DesignnesChatDump;
use App\Models\LeadsData;
use App\Models\Brand;
use App\Models\DBInvoice;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\MarketingNotchChatDump;
use App\Models\TelnyxCallLog;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DataBankController extends Controller
{
    public function formatNumbers($phone)
    {
        return preg_replace('/[ \,\.\-\(\)\+\s]/', '', $phone);
    }

    public function phone_arrange($phone)
    {
        if (strlen($phone) <= 14) {
            return substr($this->formatNumbers($phone), -6);
        } else {
            // Multiple numbers case
            $phone_num = [];
            $part1 = substr($this->formatNumbers($phone), 0, strlen($this->formatNumbers($phone)) / 2);
            $part2 = substr($this->formatNumbers($phone), strlen($this->formatNumbers($phone)) / 2);

            $last6Part1 = substr($part1, -6);
            $last6Part2 = substr($part2, -6);
            $phone_num['p1'] = $last6Part1;
            $phone_num['p2'] = $last6Part2;
            return $phone_num;
        }
    }

    public function index(Request $request)
    {

        $brands = PWBrand::all();

        $filters = $request->only([
            'search_phone',
            'search_brand',
            'search_email',
            'search_invoice',
            'search_transaction',
            'search_amount',
            'search_date_from',
            'search_date_to',
            'search_status'
        ]);


        // Normalize phone function
        function normalizePhone($phone)
        {
            return preg_replace('/[ \,\.\-\(\)\+\s]/', '', $phone); // Remove non-numeric characters
        }

        function coverDateTime($datetime)
        {
            $input = $datetime;
            $timestamp = strtotime($input);

            return date('d/m/Y h:i:s A', $timestamp);
        }
        // Base query
        $query =  DB::table(DB::raw('(
            SELECT *, "Core Digitals" AS table_name FROM transactions
            WHERE status NOT IN ("declined", "voided")
            UNION ALL
            SELECT *, "NexByte" AS table_name FROM nexbyte_transactions
            WHERE status NOT IN ("declined", "voided")
            UNION ALL
            SELECT *, "American Book Services" AS table_name FROM american_transactions
            WHERE status NOT IN ("declined", "voided")
        ) as combined'))
            ->orderBy('payment_date', 'DESC');

        if (!empty($filters['search_phone'])) {
            $query->where('phone', '=', $filters['search_phone']);
        }

        if (!empty($filters['search_email'])) {
            $query->where('email', '=', $filters['search_email']);
        }

        if (!empty($filters['search_transaction'])) {
            $query->where('transaction_id', '=', $filters['search_transaction']);
        }

        if (!empty($filters['search_amount'])) {
            $query->where('amount', '=', $filters['search_amount']);
        }

        if (!empty($filters['search_date_from'])) {
            $query->where('payment_date', 'LIKE', "%" . $filters['search_date_from'] . "%");
        }

        if (!empty($filters['search_status'])) {
            $query->where('status', '=', $filters['search_status']);
        }

        // Execute query with pagination
        $transactions = $query->paginate(10);

        // Prepare merged data
        $mergedData = [];

        $mergedData = [];

        // Check if search filters are applied
        if (!empty($filters['search_invoice']) || !empty($filters['search_brand'])) {
            // Fetch invoices matching the search criteria
            $invoiceQuery = DB::table('d_b_invoices')
                ->join('p_w_brands', 'd_b_invoices.brand', '=', 'p_w_brands.id')
                ->select('d_b_invoices.*', 'p_w_brands.name as brand_name'); // Select columns from both tables

            if (!empty($filters['search_invoice'])) {
                $invoiceQuery->where('d_b_invoices.invoice_number', $filters['search_invoice']);
            }
            if (!empty($filters['search_brand'])) {
                $invoiceQuery->orWhere('d_b_invoices.brand', $filters['search_brand']);
            }

            $invoices = $invoiceQuery->get();

            foreach ($invoices as $invoice) {
                // Get transactions related to the matched invoices
                $transactions = DB::table(DB::raw('(
                    SELECT *, "CoreDigitals" AS table_name FROM transactions
                    WHERE transaction_id = :transaction_id
                    UNION ALL
                    SELECT *, "Nexbyte" AS table_name FROM nexbyte_transactions
                    WHERE transaction_id = :transaction_id
                    UNION ALL
                    SELECT *, "AmericanBookServices" AS table_name FROM american_transactions
                    WHERE transaction_id = :transaction_id
                ) as combined'))
                ->addBinding($invoice->transaction_id, 'select')  // Bind the transaction_id for both SELECT queries
                ->get();

                foreach ($transactions as $txn) {
                    $normalizedPhone = normalizePhone($txn->phone);
                    $phoneParts = $this->phone_arrange($txn->phone);
                    $p2 = is_array($phoneParts) ? $phoneParts['p2'] : $phoneParts;

                    // Fetch related data
                    $marketingChat = DB::table('marketing_notch_chat_dumps')
                        ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(visitor_phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])
                        ->orWhere('visitor_email', $txn->email)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $designnesChat = DB::table('designnes_chat_dumps')
                        ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(visitor_phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])
                        ->orWhere('visitor_email', $txn->email)
                        ->orderBy('id', 'DESC')
                        ->first();

                    $callLog = DB::table('telnyx_call_logs')
                        ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cli, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?
                                OR RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cld, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2, $p2])
                        ->orderBy('id', 'DESC')
                        ->first();

                    $brandForm = DB::table('brand_leads')
                        ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])
                        ->orWhere('email', $txn->email)
                        ->where('phone', '!=', '-')
                        ->first();

                    $leadsData = DB::table('leads_data')
                        ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])
                        ->orWhere('email', $txn->email)
                        ->orWhere('transaction_id', $txn->transaction_id)
                        ->first();

                    // Store merged data
                    $mergedData[] = [
                        'transaction' => $txn,
                        'invoice' => $invoice,
                        'marketing_chat' => $marketingChat,
                        'designnes_chat' => $designnesChat,
                        'call_log' => $callLog,
                        'brand_form' => $brandForm,
                        'leads_data' => $leadsData
                    ];
                }
            }
        } else {
            // Run original logic when no search filters are applied
            foreach ($transactions as $txn) {
                $normalizedPhone = normalizePhone($txn->phone);
                $phoneParts = $this->phone_arrange($txn->phone);
                $p2 = is_array($phoneParts) ? $phoneParts['p2'] : $phoneParts;

                // Fetch related data
                $marketingChat = DB::table('marketing_notch_chat_dumps')
                    ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(visitor_phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])
                    ->orWhere('visitor_email', $txn->email)
                    ->orderBy('id', 'DESC')
                    ->first();

                $designnesChat = DB::table('designnes_chat_dumps')
                    ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(visitor_phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])
                    ->orWhere('visitor_email', $txn->email)
                    ->orderBy('id', 'DESC')
                    ->first();

                $callLog = DB::table('telnyx_call_logs')
                    ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cli, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?
                                OR RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cld, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2, $p2])
                    ->orderBy('id', 'DESC')
                    ->first();

                $brandForm = DB::table('brand_leads')
                    ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])
                    ->orWhere('email', $txn->email)
                    ->where('phone', '!=', '-')
                    ->first();

                $leadsData = DB::table('leads_data')
                    ->whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])
                    ->orWhere('email', $txn->email)
                    ->orWhere('transaction_id', $txn->transaction_id)
                    ->first();

                $invoice = DB::table('d_b_invoices')
                    ->join('p_w_brands', 'd_b_invoices.brand', '=', 'p_w_brands.id')
                    ->select('d_b_invoices.*', 'p_w_brands.id as brand_id', 'p_w_brands.name as brand_name') // Select columns from both tables
                    ->where('d_b_invoices.transaction_id', $txn->transaction_id) // Filter by transaction_id
                    ->first();
                // dd($invoice);
                // $invoice = DBInvoice::with('brands')->where('transaction_id', $txn->transaction_id)->first();

                // Store merged data
                $mergedData[] = [
                    'transaction' => $txn,
                    'invoice' => $invoice,
                    'marketing_chat' => $marketingChat,
                    'designnes_chat' => $designnesChat,
                    'call_log' => $callLog,
                    'brand_form' => $brandForm,
                    'leads_data' => $leadsData
                ];
            }
        }


        $display = '';

        if ($request->ajax()) {
            foreach ($mergedData as $data) {
                $display .= "<tr>
                    <!-- Transactions Column -->
                    <td style='overflow-wrap: anywhere;background: #1212;font-weight: bolder;'>
                        <p class='copy-text' style='display: none;'>" . $data['transaction']->transaction_id . "</p>
                        <span style='display: flex;justify-content: center;' class='copy-btn-transaction btn btn-sm btn-secondary'><strong>ID:</strong>" . $data['transaction']->transaction_id . " </span>
                        <ul style='padding-left: 15px;list-style: disclosure-open;'>
                            <li class='pt-2'><strong>Amount:</strong> $" . $data['transaction']->amount . "</li>
                            <li><strong>Email:</strong> " . $data['transaction']->email . "</li>
                            <li class='pb-2'><strong>Phone:</strong> " . $data['transaction']->phone . "</li>
                            <li><strong>Company:</strong><span style='color: #d81717;'>". $data['transaction']->table_name ."</span></li>
                            <li><strong>Status:</strong> " . $data['transaction']->status . "</li>
                            <li><strong>Date:</strong> " . coverDateTime($data['transaction']->payment_date) . "</li>
                        </ul>
                        <a href='" . route('data-bank.details', ['contact' => normalizePhone($data['transaction']->phone)]) . "' class='btn btn-sm btn-warning more-detail' style='display: flex;justify-content: center;'>More Details</a>
                    </td>";

                if ($data['invoice']) {
                    $brand_name = isset($data['invoice']->brands->name) ? $data['invoice']->brands->name : 'No Brand Attached';
                    $display .= "<td style='overflow-wrap: anywhere;background: #4fa843b8;font-weight: 450;color: #fff;'>
                    <p class='copy-text-invoice' style='display: none;'>" . $data['invoice']->invoice_number . "</p>
                        <span class='copy-btn-invoice btn btn-sm btn-danger' style='display: flex;justify-content: center;'><strong>Invoice No:</strong> " . $data['invoice']->invoice_number . "</span>
                        <ul style='padding-left: 15px;list-style: disclosure-open;'>
                            <li class='pt-2'><strong>Amount:</strong> $" . $data['invoice']->amount . "</li>
                            <li><strong>Email:</strong> " . $data['invoice']->email . "</li>
                            <li><strong>Phone:</strong> " . $data['invoice']->contact . "</li>
                            <li class='pt-2'><strong>Brand:</strong> <span class='text-dark fw-bold'>" . $brand_name . "</span></li>
                            <li><strong>Created At:</strong> " . coverDateTime($data['invoice']->created_at) . "</li>
                        </ul>
                    </td>";
                } else {
                    $display .= "<td style='overflow-wrap: anywhere;background: white;font-weight: 450;color: #000;'>No Data</td>";
                }

                if ($data['call_log']) {
                    $display .= "<td style='overflow-wrap: anywhere;background: #599de1b2;font-weight: 450;color: #fff;'>
                        <span class='btn btn-sm btn-dark' style='display: flex;justify-content: center;'><strong>Direction:</strong> " . $data['call_log']->direction . "</span>
                        <ul style='padding-left: 15px;list-style: disclosure-open;'>
                            <li class='pt-2'><strong>To:</strong> <span class='text-dark fw-bold'>" . $data['call_log']->cld . "</span></li>
                            <li><strong>From:</strong> <span class='text-dark fw-bold'>" . $data['call_log']->cli . "</span></li>
                            <li><strong>Duration:</strong> " . gmdate('H:i:s', $data['call_log']->call_sec) . "</li>
                            <li class='pt-2'><strong>Started At:</strong> " . coverDateTime($data['call_log']->started_at) . "</li>
                            <li><strong>Finished At:</strong> " . coverDateTime($data['call_log']->finished_at) . "</li>
                        </ul>
                    </td>";
                } else {
                    $display .= "<td style='overflow-wrap: anywhere;background: white;font-weight: 450;color: #000;'>No Data</td>";
                }

                if ($data['brand_form']) {
                    $display .= "<td style='overflow-wrap: anywhere;background: #125ea2ab;color: #fff;font-weight: 450;'>
                        <span class='btn btn-sm btn-success' style='display: flex;justify-content: center;'><strong>Brand:</strong> " . $data['brand_form']->brand_name . "</span>
                        <ul style='padding-left: 15px;list-style: disclosure-open;'>
                            <li class='pt-2'><strong>Name:</strong> " . $data['brand_form']->name . "</li>
                            <li><strong>Email:</strong> " . $data['brand_form']->email . "</li>
                            <li><strong>Phone:</strong> " . $data['brand_form']->phone . "</li>
                            <li class='pt-2'><strong>Created At:</strong> " . coverDateTime($data['brand_form']->created_at) . "</li>
                        </ul>
                    </td>";
                } else {
                    $display .= "<td style='overflow-wrap: anywhere;background: white;font-weight: 450;color: #000;'>No Data</td>";
                }

                if ($data['marketing_chat']) {
                    $display .= "<td style='overflow-wrap: anywhere;background:rgba(230, 132, 5, 0.67);color: #fff;font-weight: 450;'>
                        <span class='btn btn-sm btn-success' style='display: flex;justify-content: center;'><strong>Agent:</strong> " . $data['marketing_chat']->agent_names . "</span>
                        <ul style='padding-left: 15px;list-style: disclosure-open;'>
                            <li class='pt-2'><strong>Visitor:</strong> " . $data['marketing_chat']->visitor_name . "</li>
                            <li><strong>Email:</strong> " . $data['marketing_chat']->visitor_email . "</li>
                            <li><strong>Duration:</strong> " . gmdate('H:i:s', intval($data['marketing_chat']->duration)) . "</li>
                            <li>
                                <strong>Source:</strong>
                                Marketing Notch
                            </li>
                        </ul>
                    </td>";
                } else if ($data['designnes_chat']) {
                    $display .= "<td style='overflow-wrap: anywhere;background:rgba(17, 17, 16, 0.67);color: #fff;font-weight: 450;'>
                        <span class='btn btn-sm btn-success' style='display: flex;justify-content: center;'><strong>Agent:</strong> " . $data['designnes_chat']->agent_names . "</span>
                        <ul style='padding-left: 15px;list-style: disclosure-open;'>
                            <li class='pt-2'><strong>Visitor:</strong> " . $data['designnes_chat']->visitor_name . "</li>
                            <li><strong>Email:</strong> " . $data['designnes_chat']->visitor_email . "</li>
                            <li><strong>Duration:</strong> " . gmdate('H:i:s', intval($data['designnes_chat']->duration)) . "</li>
                            <li>
                                <strong>Source:</strong>
                                Designness
                            </li>
                        </ul>
                    </td>";
                } else {
                    $display .= "<td style='overflow-wrap: anywhere;background: white;font-weight: 450;color: #000;'>No Data</td>";
                }

                $display .= "</tr>";
            }
            return $display;
        }

        return view('data-bank.databank', compact('mergedData', 'brands'));
    }

    public function detailView($contact)
    {

        $phoneParts = $this->phone_arrange($contact);

        $p2 = is_array($phoneParts) ? $phoneParts['p2'] : $phoneParts;

        $transactions = Transaction::whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', '') LIKE ?", ["%$contact%"])->get();

        $invoices = DBInvoice::with('brands')->whereRaw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(contact, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', '') LIKE ?", ["%$contact%"])->get();

        $callLogs = TelnyxCallLog::whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cli, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?
        OR RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(cld, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2, $p2])->get();

        $designnesChats = DesignnesChatDump::whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(visitor_phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])->get();

        $marketingNotchChats = MarketingNotchChatDump::whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(visitor_phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])->get();

        $webForms = BrandLeads::whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])->get();

        $leadData = LeadsData::whereRaw("RIGHT(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', ''), 6) = ?", [$p2])->get();

        return view('data-bank.details', compact('transactions', 'invoices', 'callLogs', 'designnesChats', 'marketingNotchChats', 'webForms', 'leadData'));
    }

    public function merchant_data(Request $request)
    {
        $transactions = Transaction::select(
            DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', '') AS formatted_phone"),
            'name',
            'email',
            DB::raw("MAX(payment_date) as latest_payment_date"),  // Select the latest payment date
            'status',
            DB::raw("GROUP_CONCAT(transaction_id ORDER BY payment_date DESC SEPARATOR ', ') as transaction_ids"),
            DB::raw("SUM(CASE WHEN status = 'settledSuccessfully' THEN amount ELSE 0 END) as total_settled"),
            DB::raw("SUM(CASE WHEN status = 'refundSettledSuccessfully' THEN amount ELSE 0 END) as total_refunded")
        )
            ->groupBy(
                DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', '')"),
                'email',
            )
            ->orderBy('total_settled', 'desc')
            ->get();


        return view('data-bank.merchant', compact('transactions'));
    }

    public function refund_merchant_data(Request $request)
    {
        // Fetch all transactions with 'refundSettledSuccessfully' status
        $refunds = Transaction::select(
            DB::raw("REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, ' ', ''), '-', ''), '(', ''), ')', ''), '.', ''), '+', '') AS formatted_phone"),
            'name',
            'email',
            'payment_date',
            'status',
            'transaction_id',
            'amount' // Include the amount for each refund transaction
        )
            ->where('status', 'refundSettledSuccessfully') // Filter to only include refunds
            ->orderBy('payment_date', 'desc') // Order by the most recent date
            ->get(); // Get the data without grouping or aggregation

        return view('data-bank.refunded-logs', compact('refunds'));
    }



    public function telnyx_call_log(Request $request)
    {
        $telnyx_call_logs = TelnyxCallLog::orderBy('id', 'desc')->get();
        return view('data-bank.telnyx-call-log', compact('telnyx_call_logs'));
    }


    public function ringCentral_call_log(Request $request)
    {
        // $ringCentral_call_logs = RingCentralCallLog::orderBy('id', 'desc')->get();
        // return view('data-bank.ringCentral-call-log', compact('ringCentral_call_logs'));
    }

    public function designnes_chat(Request $request)
    {
        $designnes_chat = DesignnesChatDump::orderBy('id', 'desc')->get();
        return view('data-bank.designnes-chat', compact('designnes_chat'));
    }

    public function marketingNotch_chat(Request $request)
    {
        $marketingNotch_chat = MarketingNotchChatDump::orderBy('id', 'desc')->get();
        return view('data-bank.marketingNotch-chat', compact('marketingNotch_chat'));
    }

    public function webForms(Request $request)
    {
        $webForms = BrandLeads::orderBy('id', 'desc')->get();
        return view('data-bank.web-forms', compact('webForms'));
    }
}
