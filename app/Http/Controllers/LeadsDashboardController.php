<?php

namespace App\Http\Controllers;

use App\Models\BrandLeads;
use App\Models\DesignnesChatDump;
use App\Models\LeadsData;
use App\Models\Brand;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\DBInvoice;
use App\Models\MarketingNotchChatDump;
use App\Models\TelnyxCallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Http\Requests\StoreLeadRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class LeadsDashboardController extends Controller
{
    public function generateLeadNo()
    {
        return str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function dashboard()
    {
        return view('leads.dashboard');
    }

    // Store lead
    public function store(Request $request)
    {
        $lead = new LeadsData();
        $lead->lead_no = "Lead# " . $this->generateLeadNo();
        $lead->name = $request->transaction_id ?? null;
        $lead->name = $request->name ?? null;
        $lead->email = $request->email ?? null;
        $lead->phone = $request->phone ?? null;
        $lead->source = $request->source ?? null;
        $lead->brand_id = $request->brand_id ?? null;
        $lead->status = $request->lead_status ?? 'Active';

        $lead->save();

        return response()->json(['success' => 'Lead created successfully']);
    }

}
