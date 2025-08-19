@php
function coverDateTime($datetime){
    $input = $datetime;
    $timestamp = strtotime($input);

    return date('m/d/Y h:i:s A', $timestamp);
}
@endphp
@foreach($_data as $type => $data)
@if($type != 'unmatched_data')
    <tr>
        <td style="background: #1212;font-weight: bolder;">
            Name: {{ $data['invoice']->name }}
            <br>
            Email: <span style="text-transform: lowercase;">{{ $data['invoice']->email }}</span>
            <br>
            Phone:
            {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['invoice']->contact) ?? 'N/A' }}
            <br>
            <span class="text-danger">Brand: <b>{{ $data['invoice']->brands->name }}</b></span>
        </td>
        <td style="background: #bb7d3da6;font-weight: 450;color: #fff;">
            @if($data['invoice'] !== 'N/A')
                Invoice#: {{ $data['invoice']->invoice_number ?? 'N/A' }}
                <br>
                Amount: ${{ $data['invoice']->amount ?? 'N/A' }}
                <br>
                @if(strlen(preg_replace('/[ \,\.\-\(\)\+\s]/', '', $data['invoice']->contact)) > 14)
                    @php
                        $part1 = substr(preg_replace('/[ \,\.\-\(\)\+\s]/', '', $data['invoice']->contact), 0, strlen(preg_replace('/[ \,\.\-\(\)\+\s]/', '', $data['invoice']->contact)) / 2);
                        $part2 = substr(preg_replace('/[ \,\.\-\(\)\+\s]/', '', $data['invoice']->contact), strlen(preg_replace('/[ \,\.\-\(\)\+\s]/', '', $data['invoice']->contact)) / 2);
                    @endphp
                    Contacts: {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $part1) ?? 'N/A' }} ,
                    {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $part2) ?? 'N/A' }}
                @else
                    Contact:
                    {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['invoice']->contact) ?? 'N/A' }}

                @endif
                <br>
                Created: {{ coverDateTime($data['invoice']->created_at) ?? 'N/A' }}
            @else
                N/A
            @endif
        </td>
        <td style="background: #4fa843b8;font-weight: 450;color: #fff;">
            @if($data['call_log_direction'] !== 'N/A')
                {{ $data['call_log_direction']->direction ?? 'Direction Not Available' }}
                <br>
                CLI:
                {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['call_log_direction']->cli) ?? 'N/A' }}
                <br>
                CLD:
                {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['call_log_direction']->cld) ?? 'N/A' }}
                <br>
                Duration: {{ gmdate("H:i:s", $data['call_log_direction']->call_sec) }}
                <br>
                Started: {{ coverDateTime($data['call_log_direction']->started_at) }}
                <!-- <br>
                                                Answered: {{ $data['call_log_direction']->answered_at }}
                                                <br>
                                                Finished: {{ $data['call_log_direction']->finished_at }} -->
            @else
                N/A
            @endif
        </td>
        <td style="background: #599de1b2;font-weight: 450;color: #fff;">
            @if($data['designnes_chat_dump'] !== 'N/A')
                Visitor Name: {{ $data['designnes_chat_dump']->visitor_name ?? 'N/A' }}
                <br>
                Visitor Phone:
                {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['designnes_chat_dump']->visitor_phone) ?? 'N/A' }}
                <br>
                Agent: {{ $data['designnes_chat_dump']->agent_names }}
                <br>
                Duration: {{ gmdate("H:i:s", intval($data['designnes_chat_dump']->duration)) }}
            @else
                N/A
            @endif
        </td>
        <td style="background: #e68f6db8;font-weight: 450;color: #fff;">
            @if($data['marketing_notch_chat_dump'] !== 'N/A')
                Visitor Name: {{ $data['marketing_notch_chat_dump']->visitor_name ?? 'N/A' }}
                <br>
                Visitor Phone:
                {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['marketing_notch_chat_dump']->visitor_phone) ?? 'N/A' }}
                <br>
                Agent: {{ $data['marketing_notch_chat_dump']->agent_names }}
                <br>
                Duration: {{ gmdate("H:i:s", intval($data['marketing_notch_chat_dump']->duration)) }}
            @else
                N/A
            @endif
        </td>
        <td style="background: #125ea2ab;color: #fff;font-weight: 450;">
            @if($data['web_form'] !== 'N/A')
                Name: {{ $data['web_form']->name ?? 'N/A' }}
                <br>
                Email: <span style="text-transform: lowercase;">{{ $data['web_form']->email ?? 'N/A' }}</span>
                <br>
                Phone:
                {{ preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $data['web_form']->phone) ?? 'N/A' }}
                <br>
                Created: {{ coverDateTime($data['web_form']->created_at) ?? 'N/A' }}
            @else
                N/A
            @endif
        </td>
    </tr>
@endif
@endforeach