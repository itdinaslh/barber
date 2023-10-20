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
        <div class="col-md-12">
            <div id="chart">

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
        chart: {
            height: 350,
            type: 'bar',
        },
        dataLabels: {
            enabled: false
        },
        series: [],
        title: {
            text: 'Total Transaksi perbulan',
        },
        theme: {
            monochrome: {
                enabled: true,
                color: '#255aee',
                shadeTo: 'light',
                shadeIntensity: 0.65
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: "horizontal",
                shadeIntensity: 0.5,
                gradientToColors: undefined, // optional, if not defined - uses the shades of same color in series
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 100],
                colorStops: []
            }
        },

        noData: {
            text: 'Loading...'
        }
        }

        var chart = new ApexCharts(
        document.querySelector("#chart"),
        options
        );

chart.render();
        chart.render();
        $.getJSON('/dashboard_chart', function(response) {
        chart.updateSeries([{
          name: 'Sales',
          data: response
        }])
    });
    </script>
@endpush
