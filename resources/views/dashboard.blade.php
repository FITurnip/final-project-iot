@php
    $persentasePakan = 30;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Simple Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  
    <link href="{{ asset("assets/css/dashboard.css") }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg fixed-top">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                            <x-bottle-visualization :rotated="true" :waterLevel="$persentasePakan" />
                            <p class="card-text">Banyak Pakan: {{ 100 - $persentasePakan }}%</p>
                            <p class="card-text">Cukup untuk 3 hari</p>
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
                            <x-temperature-display />
                            <p class="card-text">Kontrol Suhu</p>
                            <div class="row">
                                <div class="col-3">
                                    <button class="btn btn-primary btn-block" id="naik-suhu"><i class="fas fa-arrow-up"></i></button>
                                </div>
                                <div class="col-6">
                                    <input type="text" name="temp" id="temp" class="form-control text-center" value="30">
                                </div>
                                <div class="col-3">
                                    <button class="btn btn-primary btn-block" id="turun-suhu"><i class="fas fa-arrow-down"></i></button>
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

    <script>
    $(document).ready(function(){
        var suhu = 25; // Suhu awal
        
        $("#naik-suhu").click(function(){
        suhu++; // Naikkan suhu
        $("#current-suhu").text(suhu + "°C"); // Update tampilan suhu
        });
        
        $("#turun-suhu").click(function(){
        suhu--; // Turunkan suhu
        $("#current-suhu").text(suhu + "°C"); // Update tampilan suhu
        });
    });
    </script>

    <script>
    function createChart(title, labels, data, canvasId) {
      var ctx = document.getElementById(canvasId).getContext('2d');
      var chart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: title,
            data: data,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    }

    document.addEventListener('DOMContentLoaded', (event) => {
      createChart('Water Temperature (°C)', ['January', 'February', 'March', 'April', 'May', 'June', 'July'], [4, 5, 8, 12, 16, 20, 22], 'waterTempChart');
      createChart('Food Amount (kg)', ['January', 'February', 'March', 'April', 'May', 'June', 'July'], [10, 12, 15, 18, 20, 22, 25], 'foodAmountChart');
    });
  </script>

</body>
</html>
