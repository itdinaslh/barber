@extends('shared.master')

@section('title', 'Dashboard')
@section('classcontent', 'content')

@section('PageHeader', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Hari ini</span>
                    <span class="info-box-number">{{ $today }}</span>
                    <span class="info-box-number">Rp. {{ number_format($todaytotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Minggu ini</span>
                    <span class="info-box-number">{{ $week }}</span>
                    <span class="info-box-number">Rp. {{ number_format($weektotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Bulan ini</span>
                    <span class="info-box-number">{{ $month }}</span>
                    <span class="info-box-number">Rp. {{ number_format($monthtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
