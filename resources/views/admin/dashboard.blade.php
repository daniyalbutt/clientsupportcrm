@extends('layouts.app-admin')
@section('title', 'Dashboard')
@push('styles')
<style>
    #BarChart2{
        height: 294px !important;
    }
</style>
@endpush
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Dashboard</h1>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <!-- CARD ICON-->
        <div class="row">
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('category.index') }}">
                        <div class="card-body text-center"><i class="i-Library"></i>
                            <p class="text-muted mt-2 mb-2">Category</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$category_count}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('brand.index') }}">
                        <div class="card-body text-center"><i class="i-Medal-2"></i>
                            <p class="text-muted mt-2 mb-2">Brand</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$brand_count}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('currency.index') }}">
                        <div class="card-body text-center"><i class="i-Cash-register-2"></i>
                            <p class="text-muted mt-2 mb-2">Currency</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$currency_count}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('admin.project.index') }}">
                        <div class="card-body text-center"><i class="i-Suitcase"></i>
                            <p class="text-muted mt-2 mb-2">Projects</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$project_count}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('admin.user.production') }}">
                        <div class="card-body text-center"><i class="i-Add-UserStar"></i>
                            <p class="text-muted mt-2 mb-2">Production</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$production_count}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('admin.user.sales') }}">
                        <div class="card-body text-center"><i class="i-Administrator"></i>
                            <p class="text-muted mt-2 mb-2">Sale Agent</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$member_count}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('admin.client.index') }}">
                        <div class="card-body text-center"><i class="i-Checked-User"></i>
                            <p class="text-muted mt-2 mb-2">Leads</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$leads_count}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('admin.invoice') }}?status=2">
                        <div class="card-body text-center"><i class="i-Credit-Card"></i>
                            <p class="text-muted mt-2 mb-2">Paid Invoices</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$paid_invoice}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('admin.invoice') }}?status=1">
                        <div class="card-body text-center"><i class="i-Credit-Card-3"></i>
                            <p class="text-muted mt-2 mb-2">UnPaid Invoices</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$un_paid_invoice}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="javascript:;">
                        <div class="card-body text-center"><i class="i-Arrow-Up-in-Circle"></i>
                            <p class="text-muted mt-2 mb-2">Pending Tickets (QA)</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$tickets_open}}</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-sm-6">
                <div class="card card-icon mb-4">
                    <a href="{{ route('admin.tickets') }}">
                        <div class="card-body text-center"><i class="i-Thread"></i>
                            <p class="text-muted mt-2 mb-2">Total Reports (QA)</p>
                            <p class="text-primary text-24 line-height-1 m-0">{{$tickets_total}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-12">
        @php
        $sum = 0;
        @endphp

        @foreach($data as $key => $value)

        @php
        $sum = $sum + $value->amount;
        @endphp

        @endforeach
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card card-chart-bottom o-hidden mb-4">
                    <div class="card-body">
                        <div class="text-muted">{{ $invoice_month }}, {{ $invoice_year }} Sales</div>
                        <p class="mb-4 text-primary text-24">${{ $sum }}</p>
                    </div>
                    <div id="echartBar" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    var data = {!! json_encode($data->toArray()) !!};
    var data_array = [];
    var data_day = [];
    for(var i = 0; i < data.length; i++){
        data_array.push(data[i].amount);
        data_day.push(data[i].invoice_date);
    }

    $(document).ready(function() {
        // Chart in Dashboard version 1
        var echartElemBar = document.getElementById('echartBar');

        if (echartElemBar) {
            var echartBar = echarts.init(echartElemBar);
            echartBar.setOption({
                legend: {
                    borderRadius: 0,
                    orient: 'horizontal',
                    x: 'right'
                },
                grid: {
                    left: '8px',
                    right: '8px',
                    bottom: '0',
                    containLabel: true
                },
                tooltip: {
                    show: true,
                    backgroundColor: 'rgba(0, 0, 0, .8)'
                },
                xAxis: [{
                    type: 'category',
                    data: data_day,
                    axisTick: {
                        alignWithLabel: true
                    },
                    splitLine: {
                        show: false
                    },
                    axisLine: {
                        show: true
                    }
                }],
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        formatter: '${value}'
                    },
                    axisLine: {
                        show: false
                    },
                    splitLine: {
                        show: true,
                        interval: 'auto'
                    }
                }],
                series: [{
                    name: '',
                    data: data_array,
                    label: {
                        show: false,
                        color: '#0168c1'
                    },
                    type: 'bar',
                    barGap: 0,
                    color: '#bcbbdd',
                    smooth: true,
                    itemStyle: {
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowOffsetY: -2,
                            shadowColor: 'rgba(0, 0, 0, 0.3)'
                        }
                    }
                }]
            });
            $(window).on('resize', function() {
                setTimeout(function() {
                    echartBar.resize();
                }, 500);
            });
        }
    });
</script>
@endpush