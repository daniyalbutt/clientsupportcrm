@extends('layouts.app-sale')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .ul-widget2__username {
        font-size: 0.8rem;
    }

    button.write-message {
        margin-bottom: 30px;
    }

    .ul-widget3-body p {
        margin-bottom: 4px;
    }

    .loader {
        text-align: center;
        display: none;
    }

    .loader img {
        width: 30px;
    }
</style>
<style>
    ul .issue-list{
        list-style-type: disclosure-closed;
        font-size: 14px;
    }
    .issue-ul{
        padding: 12px;
    }
    .card::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 80%;
        height: 80%;
        @if (!empty(json_decode($issue->issue, true)['qa_varified']))
        background: url('{{ json_decode($issue->issue, true)['qa_varified'] == 'QA Verified' ? '/uploads/brands/qa-verified.png' : '' }}') no-repeat center;
        @endif
        background-size: contain;
        opacity: 0.1; /* Adjust transparency */
        transform: translate(-50%, -50%);
        pointer-events: none; /* Prevent interaction */
    }
    .row div h3{
        text-decoration: underline;
    }
</style>
@endpush
@section('content')

<div class="breadcrumb">
    <h1></h1>
    <ul>
        <li><a href="#">Tickets</a></li>
        <li>View Issue Reporting Ticket</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row mb-4">
    <div class="col-md-12">
        <section class=" h-custom" style="background-color: #8fc4b7;">
            <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card rounded-3" style="background-color: #f0e1c4;">
                    <div class="logo d-flex justify-content-center pt-4">
                        <img src="{{ asset($issue->brands->logo) }}" style="border-top-left-radius: .3rem; border-top-right-radius: .3rem;width: 20%;" alt="BRAND LOGO">
                    </div>
                <div class="card-body p-4 p-md-5">
                    <div class="client-card d-flex justify-content-center">
                        <h3 style="font-weight: bolder;font-size: 18px;" class="btn btn-secondary text-center mb-4 pb-2 pb-md-0 mb-md-5 px-md-2">{{ $issue->client->name }} {{ $issue->client->last_name }}</h3>
                    </div>
                    <div class="px-md-2">
                        <div class="row">
                            @if (!empty(json_decode($issue->issue, true)['deliverable']))
                                <div class="col-md-4 text-left">
                                    <h3>Product/Deliverables Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['deliverable'] as $deliverable)
                                            <li class="issue-list">{{ $deliverable }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty(json_decode($issue->issue, true)['agent_related']))
                                <div class="col-md-4 text-left">
                                    <h3>Agent-Related Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['agent_related'] as $agent_related)
                                            <li class="issue-list">{{ $agent_related }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty(json_decode($issue->issue, true)['production_related']))
                                <div class="col-md-4 text-left">
                                    <h3>Deliverables and Production Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['production_related'] as $production_related)
                                            <li class="issue-list">{{ $production_related }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty(json_decode($issue->issue, true)['communication']))
                                <div class="col-md-4 text-left">
                                    <h3>Communication Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['communication'] as $communication)
                                            <li class="issue-list">{{ $communication }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty(json_decode($issue->issue, true)['customer_legal']))
                                <div class="col-md-4 text-left">
                                    <h3>Customer Refund or Legal Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['customer_legal'] as $customer_legal)
                                            <li class="issue-list">{{ $customer_legal }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty(json_decode($issue->issue, true)['service_delivery']))
                                <div class="col-md-4 text-left">
                                    <h3>Service Delivery Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['service_delivery'] as $service_delivery)
                                            <li class="issue-list">{{ $service_delivery }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty(json_decode($issue->issue, true)['operational']))
                                <div class="col-md-4 text-left">
                                    <h3>Operational Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['operational'] as $operational)
                                            <li class="issue-list">{{ $operational }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty(json_decode($issue->issue, true)['special_case']))
                                <div class="col-md-4 text-left">
                                    <h3>Special Case Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['special_case'] as $special_case)
                                            <li class="issue-list">{{ $special_case }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (!empty(json_decode($issue->issue, true)['financial']))
                                <div class="col-md-4 text-left">
                                    <h3>Financial Issues</h3>
                                    <ul class="issue-ul">
                                        @foreach (json_decode($issue->issue, true)['financial'] as $financial)
                                            <li class="issue-list">{{ $financial }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="col-md-4 text-left">
                                <h3>Security Level</h3>
                                @if($issue->level == 'Low')
                                    <ul class="issue-ul">
                                        <li class="issue-list">
                                            <span class="alert alert-secondary" role="alert">{{ $issue->level }}</span>
                                        </li>
                                    </ul>
                                @elseif($issue->level == 'High')
                                    <ul class="issue-ul">
                                        <li class="issue-list">
                                        <span class="alert alert-warning" role="alert">{{ $issue->level }}</span>
                                        </li>
                                    </ul>                                    
                                @elseif($issue->level == 'Critical')
                                    <ul class="issue-ul">
                                        <li class="issue-list">
                                            <span class="alert alert-danger" role="alert">{{ $issue->level }}</span>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <div class="col-md-4 text-left">
                                <h3>Status</h3>
                                @if($issue->status == 'Open')
                                    <ul class="issue-ul">
                                        <li class="issue-list">
                                            <span class="alert alert-danger" role="alert">{{ $issue->status }}</span>
                                        </li>
                                    </ul>
                                @elseif($issue->status == 'In Progress')
                                    <ul class="issue-ul">
                                        <li class="issue-list">
                                        <span class="alert alert-warning" role="alert">{{ $issue->status }}</span>
                                        </li>
                                    </ul>
                                @elseif($issue->status == 'Closed')
                                    <ul class="issue-ul">
                                        <li class="issue-list">
                                            <span class="alert alert-success" role="alert">{{ $issue->status }}</span>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <div class="col-md-4 text-left">
                                <h3>Attachment</h3>
                                @if($issue->file_path == null)
                                    <span class="btn btn-secondary">No Attachment</span>
                                @else
                                <a href="{{ $issue->generatePresignedUrl() }}" target="_blank" title="{{$issue->ticket_no}}.{{$issue->get_extension()}}">
                                    @if(($issue->get_extension() == 'jpg') || ($issue->get_extension() == 'png' ) || ($issue->get_extension() == 'webp' ) || ($issue->get_extension() == 'svg' ) || (($issue->get_extension() == 'jpeg')))
                                        <span class="btn btn-secondary">View Attachment</span>
                                    @else
                                        <p>{{ $issue->get_extension() }}</p>
                                    @endif
                                </a>
                                @endif
                            </div>
                            <div class="col-md-12 text-left pt-4">
                                <h3>Brief</h3>
                                <p>{{ $issue->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </section> 
    </div>
</div>
@endsection
