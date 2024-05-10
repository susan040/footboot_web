@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Vendor Dashboard</h1>
@stop

@section('css')
@stop

@section('content')
    <div class="row mb-4">
        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-yellow p-2">
                <div class="inner">
                    <h3>{{ $venues }}</h3>
                    <p>Total Venues</p>
                </div>
                <div class="icon">
                    <i class="fas fa-square"></i>
                </div>
                <a href="{{ route('vendor.venues.index') }}" class="small-box-footer">More Info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger p-2">
                <div class="inner">
                    <h3>{{ $customers }}</h3>
                    <p>Total Customers</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-check"></i>
                </div>
                <a href="{{ route('vendor.customers.index') }}" class="small-box-footer">More Info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-blue p-2">
                <div class="inner">
                    <h3>{{ $orders }}</h3>
                    <p>Total Orders</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('vendor.orders.index') }}" class="small-box-footer">More Info <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! $chart1->renderHtml() !!}
        </div>
        <div class="col-md-6">
            {!! $chart2->renderHtml() !!}
        </div>
    </div>
@stop

@section('js')
    {!! $chart1->renderChartJsLibrary() !!}

    {!! $chart1->renderJs() !!}
    {!! $chart2->renderJs() !!}
@stop
