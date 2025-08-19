@extends('layouts.app-client')
@section('title', 'Dashboard')
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Dashboard</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <!-- CARD ICON-->
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-Speach-Bubble-3"></i>
                        <p class="text-muted mt-2 mb-2">Unread Message</p>
                        <p class="text-primary text-24 line-height-1 m-0">0</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center"><i class="i-File-Horizontal-Text"></i>
                        <p class="text-muted mt-2 mb-2">Pending Brief</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{ Auth()->user()->getBriefPendingCount() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <div class="card card-icon mb-4">
                    <div class="card-body text-center announcment-body">
                        <div class="announcment-img">
                            <img src="{{ asset('icons/announcment.png') }}" alt="">
                        </div>
                        <h5 class="d-none">Announcment</h5>
                        <p class="mb-0 d-none">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- notification-->
</div>
@endsection
@push('scripts')

@endpush