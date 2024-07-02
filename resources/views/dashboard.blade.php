<!-- resources/views/dashboard.blade.php -->
<!-- Aplikasi ini dikembangkan oleh Edi Suherlan -->
<!-- Email: edisuherlan@gmail.com -->
<!-- GitHub: https://github.com/edisuherlan -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Uang Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ 'Rp ' . number_format($transaksis->where('email', Auth::user()->email)->sum('uang_masuk'), 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Uang Keluar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ 'Rp ' . number_format($transaksis->where('email', Auth::user()->email)->sum('uang_keluar'), 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Saldo Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Saldo</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ 'Rp ' . number_format($transaksis->where('email', Auth::user()->email)->sum('uang_masuk') - $transaksis->where('email', Auth::user()->email)->sum('uang_keluar'), 2, ',', '.') }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Progres</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                        
                                        @php
                                            $totalUangMasuk = $transaksis->where('email', Auth::user()->email)->sum('uang_masuk');
                                            $totalUangKeluar = $transaksis->where('email', Auth::user()->email)->sum('uang_keluar');
                                      
                                        
                                        // Pastikan $totalUangMasuk tidak nol sebelum melakukan pembagian
                                            if ($totalUangMasuk != 0) {
                                                $persentase = ($totalUangMasuk - $totalUangKeluar) / $totalUangMasuk * 100;
                                            } else {
                                                $persentase = 0; // Atau tindakan alternatif yang sesuai dengan logika aplikasi Anda
                                            }

                                        @endphp

                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ number_format($persentase, 2) }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $persentase }}%" aria-valuenow="{{ $persentase }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transaksis->where('email', Auth::user()->email)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi Uang Masuk Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Transaksi Uang Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transaksis->where('email', Auth::user()->email)->where('uang_masuk', '>', 0)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi Uang Keluar Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Transaksi Uang Keluar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transaksis->where('email', Auth::user()->email)->where('uang_keluar', '>', 0)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-check-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selisih Transaksi Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Selisih Transaksi</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $transaksis->where('email', Auth::user()->email)->where('uang_masuk', '>', 0)->count() - $transaksis->where('email', Auth::user()->email)->where('uang_keluar', '>', 0)->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Grafik Bar -->
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Uang Masuk dan Keluar 6 Bulan Terakhir</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Data untuk grafik bar
            var data = {
                labels: {!! json_encode($transaksis->where('email', Auth::user()->email)->where('tanggal', '>', \Carbon\Carbon::now()->subMonths(6))->sortBy('tanggal')->pluck('tanggal')->toArray()) !!},
                datasets: [
                    {
                        label: 'Uang Masuk',
                        backgroundColor: '#4e73df',
                        borderColor: '#4e73df',
                        data: {!! json_encode($transaksis->where('email', Auth::user()->email)->where('tanggal', '>', \Carbon\Carbon::now()->subMonths(6))->sortBy('tanggal')->pluck('uang_masuk')->toArray()) !!},
                        datalabels: {
                            labels: {!! json_encode($transaksis->where('email', Auth::user()->email)->where('tanggal', '>', \Carbon\Carbon::now()->subMonths(6))->sortBy('tanggal')->pluck('deskripsi')->toArray()) !!}
                        }
                    },
                    {
                        label: 'Uang Keluar',
                        backgroundColor: '#1cc88a',
                        borderColor: '#1cc88a',
                        data: {!! json_encode($transaksis->where('email', Auth::user()->email)->where('tanggal', '>', \Carbon\Carbon::now()->subMonths(6))->sortBy('tanggal')->pluck('uang_keluar')->toArray()) !!},
                        datalabels: {
                            labels: {!! json_encode($transaksis->where('email', Auth::user()->email)->where('tanggal', '>', \Carbon\Carbon::now()->subMonths(6))->sortBy('tanggal')->pluck('deskripsi')->toArray()) !!}
                        }
                    }
                ],
            };

            // Konfigurasi grafik bar
            var config = {
                type: 'bar',
                data: data,
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            },
                            maxBarThickness: 25,
                        }],
                        yAxes: [{
                            ticks: {
                                min: 0,
                                max: {{ max($transaksis->where('email', Auth::user()->email)->pluck('uang_masuk')->max(), $transaksis->where('email', Auth::user()->email)->pluck('uang_keluar')->max()) + 100000 }},
                                maxTicksLimit: 5,
                                padding: 10,
                                callback: function(value, index, values) {
                                    return 'Rp ' + value.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                                }
                            },
                            gridLines: {
                                color: 'rgb(234, 236, 244)',
                                zeroLineColor: 'rgb(234, 236, 244)',
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: true
                    },
                    tooltips: {
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        backgroundColor: 'rgb(255,255,255)',
                        bodyFontColor: '#858796',
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': Rp ' + tooltipItem.yLabel.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + ' - ' + tooltipItem.xLabel;
                            }
                        }
                    },
                    plugins: {
                        datalabels: {
                            display: true,
                            color: 'black',
                            align: 'end',
                            anchor: 'end',
                            offset: -10,
                            formatter: function(value, ctx) {
                                return ctx.dataset.data[ctx.dataIndex];
                            }
                        }
                    }
                }
            };

            // Inisialisasi grafik bar
            var ctx = document.getElementById('barChart');
            var myBarChart = new Chart(ctx, config);
        });
    </script>

@endsection

@push('scripts')
<script src="{{ asset('js/chart.min.js') }}"></script>
@endpush


