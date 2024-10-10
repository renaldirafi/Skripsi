@extends('layout.mainlayout')
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Bootstrap Layout</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap');
            @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

            /* Custom CSS */
            body {
                font-family: Zilla Slab, sans-serif;
            }

            /* Header */
            header {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 1000;
            }

            /* Main Content */
            .content {
                margin-top: 80px;
                /* Adjust based on header height */
            }

            @media (max-width: 767px) {
                .main-content {
                    margin-top: 20px;
                }
            }

            .main-contentt {
                margin-left: 150px;
                margin-top: 50px;
            }

            .custom-select {
                border-color: #000000;
                border-radius: 10px;
            }

            body::-webkit-scrollbar {
                width: 8px;
                /* Contoh: Mengatur lebar scrollbar di browser WebKit (seperti Chrome, Safari) */
            }

            body::-webkit-scrollbar-track {
                background-color: #f1f1f1;
                /* Warna latar belakang scrollbar */
            }

            body::-webkit-scrollbar-thumb {
                background-color: #888;
                /* Warna handle scrollbar */
                border-radius: 4px;
                /* Membuat sudut handle scrollbar lebih melengkung */
            }

            /* Hide the scrollbar buttons (optional) */
            body::-webkit-scrollbar-button {
                display: none;
            }

            .data{
                margin-bottom:10px;
                margin-left:10px;
            }

            /* CSS untuk scrollbar di sidebar */
            .sidebar::-webkit-scrollbar {
                width: 8px;
                /* Lebar scrollbar */
            }

            .sidebar::-webkit-scrollbar-track {
                background-color: #f1f1f1;
                /* Warna latar belakang scrollbar */
            }

            .sidebar::-webkit-scrollbar-thumb {
                background-color: #888;
                /* Warna handle scrollbar */
                border-radius: 4px;
                /* Membuat sudut handle scrollbar lebih melengkung */
            }

            .leaflet-routing-alt {
                font-size: 10px; /* Ubah ukuran font sesuai kebutuhan */
                padding: 10px; /* Menyesuaikan padding */
                max-height: 300px; /* Menentukan tinggi maksimum */
                overflow-y: auto;
                display:none; /* Menambahkan scrollbar jika konten melebihi tinggi maksimum */
            }

            .leaflet-routing-container {
                width: 200px; /* Atur lebar kontainer sesuai kebutuhan */
                font-size: 12px; 
                display:none;/* Ubah ukuran font sesuai kebutuhan */
            }

            .table-custom {
                border-collapse: separate;
                border-spacing: 0;
                width: 100%;
                background-color: #f8f9fa;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                overflow: hidden;
            }

            .table-custom th, .table-custom td {
                padding: 12px 15px;
                border-bottom: 1px solid #dee2e6;
            }

            .table-custom thead {
                background-color: #007bff;
                color: #ffffff;
            }

            .table-custom tbody tr:hover {
                background-color: #e9ecef;
            }

            .table-custom tbody tr:last-child td {
                border-bottom: none;
            }

            .table-custom td {
                color: #495057;
                vertical-align: middle;
            }

            .table-custom .text-center {
                text-align: center;
            }

            .btn-back {
                background-color: transparent;
                border: none;
                color: #007bff; /* Warna teks tombol, sesuaikan dengan desain */
                font-size: 14px;
                padding: 5px 10px;
                text-align: left;
                display: flex;
                align-items: center;
                transition: color 0.3s, text-decoration 0.3s;
            }

            .btn-back i {
                margin-right: 8px; /* Jarak antara ikon dan teks */
            }

            .btn-back:hover {
                color: #0056b3; /* Warna saat hover */
                text-decoration: underline; /* Garis bawah saat hover */
            }

            .fade-out {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: white;
                z-index: 9999; /* Pastikan ini di atas elemen lain */
                transition: opacity 0.5s ease-out;
                opacity: 1;
            }

            .fade-out.hidden {
                opacity: 0;
                pointer-events: none; /* Mencegah interaksi dengan elemen saat tersembunyi */
            }
        </style>
    </head>
    <body>
        <div id="fadeOut" class="fade-out"></div>

        <!-- Main Content -->
        <div class="container-fluid content">
            <div class="row">

             <!-- Main Content Area -->
                <div class="col-md-9 main-content">
                    <div class="bg-light p-3 main-contentt" style="width:1200px;">
                        <!-- Card Instansi -->
                        <div class="row">
                            <div class="col-md-4 mb-5">
                                <button onclick="window.history.go(-1)" class="btn btn-back" style="color:#0D6EFD;">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </button>
                            </div>
                        </div>

                        <!-- Card Instansi -->
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-center">
                                <div id="schoolCarousel" class="carousel slide" data-bs-ride="carousel" style="width: 550px;">
                                    <div class="carousel-inner">
                                        @foreach ($gambar as $key => $img)
                                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                <img src="/img/Sekolah/{{ $img->nama_file }}" class="img-fluid d-block mx-auto rounded-start rounded-end"
                                                    alt="Gambar Sekolah" style="width: 550px; height:350px; object-fit: cover;">
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($gambar->count() > 1)
                                        <button class="carousel-control-prev" type="button" data-bs-target="#schoolCarousel" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#schoolCarousel" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-6" style="margin-left">
                                <div class="row data">
                                    <div class="col-md-4">Nama Sekolah</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $sekolah['nama_sekolah'] }}</div>
                                </div>
                                <div class="row data">
                                    <div class="col-md-4">Lokasi</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $sekolah['jalan_sekolah'] }}</div>
                                </div>
                                <div class="row data">
                                    <div class="col-md-4">Desa</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $sekolah['kelurahan'] }}</div>
                                </div>
                                <div class="row data">
                                    <div class="col-md-4">Kecamatan</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $sekolah['kecamatan'] }}</div>
                                </div>
                                <div class="row data">
                                    <div class="col-md-4">Website Sekolah</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7"><a href="{{ $sekolah['link_sekolah'] }}">{{ $sekolah['link_sekolah'] }}</a></div>
                                </div>
                                <div class="row data">
                                    <div class="col-md-4">Total Peserta Didik Aktif</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">{{ $sekolah['total_siswa'] }}</div>
                                </div>
                                <div class="row data">
                                    <div class="col-md-4">Fasilitas</div>
                                    <div class="col-md-1">:</div>
                                    <div class="col-md-7">
                                        <ol style="padding-left: 15px; margin: 0;">
                                            @foreach($fasilitas as $item)
                                                <li>{{ $item->nama_fasilitas }}</li>
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-center">
                                    <div id="map" style="width: 400px; height: 200px; "></div>
                                </div>
                                <div class="mt-3" style="width: 400px; margin-left: 85px;">
                                    <div class="tabel-kategori">
                                        <table class="table table-bordered table-custom">
                                            <thead>
                                                <tr>
                                                    <th>Kategori</th>
                                                    <th class="text-center">Total Siswa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kategorisekolah as $katsek)
                                                <tr>
                                                    <td>{{ $katsek['nama_kategori'] }}</td>
                                                    <td class="text-center">{{ $katsek['total_siswa'] }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS (Optional) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fadeOutElement = document.getElementById('fadeOut');

                // Tunggu 0.5 detik sebelum menambahkan kelas 'hidden'
                setTimeout(function() {
                    fadeOutElement.classList.add('hidden');
                }, 500); // 500 ms = 0.5 detik
            }); 

            var routingControl; 
            var destinationLat = {{ $sekolah['latitude'] }};
            var destinationLng = {{ $sekolah['longitude'] }};

            // Initialize the map
            var map = L.map('map').setView([{{ $sekolah['latitude'] }}, {{ $sekolah['longitude'] }}],
                20); // Set the initial latitude, longitude, and zoom level
            

            var markerIcon = L.icon({
                iconUrl:  '{{ asset('img/school.png') }}', // URL to your custom circle image
                iconSize: [40,40], // Size of the icon
                iconAnchor: [16, 16], // Anchor point of the icon, should be half of iconSize
                popupAnchor: [0, -16] // Popup anchor point relative to icon size
            });

            // Add the tile layer to the map
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add a marker to the map
            var marker = L.marker([{{ $sekolah['latitude'] }}, {{ $sekolah['longitude'] }}],{icon: markerIcon}).addTo(
                map); // Add the marker with the initial latitude and longitude

            var markerIcon2 = L.icon({
                iconUrl: '{{asset('img/user.png')}}', // URL to your custom circle image
                iconSize: [40,40], // Size of the icon
                iconAnchor: [16, 16], // Anchor point of the icon, should be half of iconSize
                popupAnchor: [0, -16] // Popup anchor point relative to icon size
            });
        
            var lokasiMarker = L.marker([-7.791285900692581, 110.37626222436796], {
                icon: markerIcon2
            }).addTo(map);

            let userLatitude, userLongitude;

            function updateLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.watchPosition(function(position) {
                        userLatitude = position.coords.latitude;
                        userLongitude = position.coords.longitude;

                        lokasiMarker.setLatLng([userLatitude, userLongitude]);
                        lokasiMarker.bindPopup("You are here");

                        // Send location data to the server
                        fetch('/coba', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                latitude: userLatitude,
                                longitude: userLongitude
                            })
                        }).then(response => response.json())
                        .then(data => {
                            console.log('Location updated');
                        })
                        .catch(error => console.error('Error:', error));
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }
            // Initial update of location
            updateLocation();

            function calculateRoute() {
                console.log("Calculating route from: ", userLatitude, userLongitude, " to: ", destinationLat, destinationLng);

                if (routingControl) {
                    map.removeControl(routingControl); // Remove the previous route if it exists
                }
        
                routingControl = L.Routing.control({
                    waypoints: [
                        L.latLng(userLatitude, userLongitude),
                        L.latLng(destinationLat, destinationLng)
                    ],
                    lineOptions: {
                        styles: [{ color: 'blue', opacity: 1, weight: 5 }]
                    },
                    createMarker: function(i, waypoint, n) {
                        return null; // Kembalikan null untuk semua waypoint agar tidak ada marker yang dibuat
                    }
                }).addTo(map);

                routingControl.on('routesfound', function(e) {
                    var routeCoordinates = e.routes[0].coordinates;
            
                    if (routeCoordinates && routeCoordinates.length > 0) {
                        var bounds = L.latLngBounds(routeCoordinates);
                        map.flyToBounds(bounds, { padding: [25,25], duration: 1.5 });
                    } else {
                        console.error("Error: No valid coordinates found in route.");
                    }
                });

                routingControl.on('routingerror', function(e) {
                    console.error("Routing error: ", e.error);
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                calculateRoute(destinationLat, destinationLng);
            });
        </script>
    </body>
</html>
