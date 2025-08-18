@extends('layouts.front-app')
@section('content')
<div class="container-full">
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h3 class="page-title">Show Response</h3>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Home</li>
                            <li class="breadcrumb-item" aria-current="page">Invoice #{{ $data->id }}</li>
                            <li class="breadcrumb-item active" aria-current="page">Show Response</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <a href="javascript:;" class="btn btn-primary">{{ $data->client->name }}</a>
        </div>
    </div>
</div>
<div class="content">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header">
                    <h4 class="box-title">Response <strong>Details</strong></h4>
                </div>
                <div class="box-body">
                    @php
                        $return_data = json_decode($data->return_response, true);
                        $payment_data = json_decode($data->payment_data, true);
                        $authorize_data = json_decode($data->authorize_response, true);
                        function displayData($data, $level = 0) {
                            $output = '';
                            foreach($data as $key => $value) {
                                $indent = str_repeat('&nbsp;', $level * 4);
                                $output .= '<div class="mb-2">';
                                $output .= $indent . '<strong class="text-capitalize">' . str_replace('_', ' ', $key) . ':</strong> ';
                                
                                if(is_array($value)) {
                                    $output .= '<div class="ms-4">' . displayData($value, $level + 1) . '</div>';
                                } else {
                                    $output .= '<span>' . ($value ?? 'N/A') . '</span>';
                                }
                                
                                $output .= '</div>';
                            }
                            return $output;
                        }
                    $paymentArray = json_decode(json_encode($return_data), true);
                    $paymentDataArray = json_decode(json_encode($payment_data), true);
                    $authorizeDataArray = json_decode(json_encode($authorize_data), true);
                    @endphp
                    {!! displayData($paymentDataArray) !!}
                    @if($data->status == 2)
                    @if($return_data != null)
                        <hr>
                        {!! displayData($paymentArray) !!}
                    @endif
                    @if($authorize_data != null)
                        <hr>
                        {!! displayData($authorizeDataArray) !!}
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush