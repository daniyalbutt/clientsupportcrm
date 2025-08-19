<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Auth;

class VerifyController extends Controller
{
    public function index(){
        return view('manager.verify');
    }
}