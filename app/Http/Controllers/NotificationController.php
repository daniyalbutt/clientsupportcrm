<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\TaskNotification;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function sendOfferNotification() {
        $userSchema = User::first();
        
        $offerData = [
            'name' => 'BOGO',
            'email' => 'test@gmail.com',
            'task' => 'You received an offer.'
        ];
  
        Notification::send($userSchema, new TaskNotification($offerData));
   
        dd('Task completed!');
    }
}
