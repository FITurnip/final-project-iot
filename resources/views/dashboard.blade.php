@php
    $persentasePakan = 30;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Monitoring</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.js" type="text/javascript"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
            </ul>
        </div>
    </nav>

    <div id="sidebar">
        <ul class="list-unstyled">
            <li><a href="#" class="sidebar-link">Dashboard</a></li>
            @for ($i = 1; $i <= 5; $i++)
                <li><a href="#" class="sidebar-link">Menu {{ $i }}</a></li>
            @endfor
        </ul>
    </div>

    <div id="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="my-4">Budidaya Ikan Berbasis IoT</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 text-center">
                    <div class="card mb-4">
                        <div class="card-header">
                            Deposit Pakan
                        </div>
                        <div class="card-body">
                            <p class="card-text">Banyak Pakan: {{ 100 - $persentasePakan }}%</p>
                            <p class="card-text">Cukup untuk 3 hari</p>
                            <x-bottle-visualization :rotated="true" :waterLevel="$persentasePakan" />
                            <div class="row justify-content-center">
                                <div class="col-4">
                                    <button class="btn btn-primary btn-block" id="feed-btn">Berikan Pakan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="card mb-4">
                        <div class="card-header">
                            Suhu Air
                        </div>
                        <div class="card-body">
                            <p class="card-text">Suhu Air Kolam Saat ini</p>
                            <x-temperature-display temperature="30" />
                            <div id="kontrol-suhu">
                                <p class="card-text" id="label-kontrol-suhu">Kontrol Suhu</p>
                                <div class="row">
                                    <div class="col-3">
                                        <button class="btn btn-primary btn-block" id="naik-suhu"><i
                                                class="fas fa-arrow-up" ></i></button>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" name="temperature_input" id="temperature_input" class="form-control text-center"
                                            value="30">
                                    </div>
                                    <div class="col-3">
                                        <button class="btn btn-primary btn-block" id="turun-suhu"><i
                                                class="fas fa-arrow-down"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="card mb-4">
                        <div class="card-header">
                            Grafik Pakan
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <select name="food_filter" id="food_filter" class="form-control col-3">
                                        <option value="">Per 6 Jam</option>
                                        <option value="">Per Hari</option>
                                        <option value="" selected>Per Bulan</option>
                                    </select>
                                    <canvas id="foodAmountChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <div class="card mb-4">
                        <div class="card-header">
                            Grafik Suhu Air
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <select name="water_filter" id="water_filter" class="form-control col-3">
                                        <option value="">Per Jam</option>
                                        <option value="">Per Hari</option>
                                        <option value="" selected>Per Bulan</option>
                                    </select>
                                    <canvas id="waterTempChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/mqtthandler.js') }}"></script>
    <script src="{{ asset('assets/js/temperaturecontrol.js') }}"></script>
    <script src="{{ asset('assets/js/feedcontrol.js') }}"></script>
</body>

</html>
