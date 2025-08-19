<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketingNotchChatDump extends Model
{
    use HasFactory;
    protected $table = 'marketing_notch_chat_dumps';
    protected $fillable = [
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'visitor_notes',
        'landing_page',
        'referral',
        'agent_names',
        'duration',
        'max_response_time',
        'avg_response_time',
        'first_response_time',
        'visitor_message_count',
        'agent_message_count',
        'total_message_count',
        'is_missed',
        'is_unread',
        'session_ip',
        'session_start_date',
        'session_end_date',
        'chat_date',
    ];
}
