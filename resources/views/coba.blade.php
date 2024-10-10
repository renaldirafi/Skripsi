@extends('layout.mainlayout')
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Bootstrap Layout</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
        <style>
            .popup-content img { 
                width: 120px;
                height:100px; /* Mengatur lebar gambar */
                height: auto; /* Menjaga rasio aspek gambar */
                display: block; /* Memastikan gambar ditampilkan sebagai blok */
                margin-bottom: 10px; /* Spasi bawah gambar */
            }
            
            .popup-content h4, .popup-content p {
                margin: 0; /* Menghapus margin default */
                padding: 0; /* Menghapus padding default */
            }

            .popup-content {
                font-size: 14px; /* Ukuran font untuk teks dalam popup */
            }

            .search-box {
                position: relative;
                width: 300px;
            }

            .search {
                display: flex;
                align-items: center;
            }

            .search input {
                width: 100%;
                padding: 8px;
                padding-left: 30px;
            }

            .search span {
                position: absolute;
                left: 10px;
            }

            .suggestions {
                border: 1px solid #ccc;
                border-top: none;
                position: absolute;
                width: 100%;
                max-height: 150px;
                overflow-y: auto;
                background-color: white;
                z-index: 0;
            }

            .suggestion-item {
                padding: 8px;
                cursor: pointer;
            }

            .suggestion-item:hover {
                background-color: #f0f0f0;
            }

            /* Main Content */
            .content {
                margin-top: 80px;
                /* Adjust based on header height */
            }

            /* Left Sidebar */
            .sidebar {
                position: fixed;
                top: 80px;
                /* Same as header height */
                bottom: 0;
                left: 0;
                z-index: 0;
                overflow-y: auto;
                padding-top: 20px;
            }

            /* Main Content Area */
            .main-content {
                padding: 20px;
            }

            @media (min-width: 768px) {
                .main-content {
                    margin-left: 250px;
                    /* Adjust based on sidebar width */
                }
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

            .pagination .page-item {
                display: inline-block;
                margin-right: 5px;
                /* Jarak antara setiap item halaman */
            }

            .pagination .page-link {
                border: 1px solid #ddd;
                /* Warna border kotak */
                padding: 8px 20px;
                /* Padding di dalam kotak */
                border-radius: 4px;
                /* Membuat sudut kotak lebih melengkung */
                transition: all 0.3s ease;
                /* Efek transisi hover */
                color: #000000;
                /* Warna teks */
                background-color: #fff;
                /* Warna latar belakang */
            }

            .pagination .page-link:hover {
                background-color: #d8d8d8;
                /* Warna latar belakang saat hover */
            }

            .pagination .page-item.active .page-link {
                background-color: #d8d8d8;
                /* Warna latar belakang item aktif */
                color: #000000;
                /* Warna teks item aktif */
                border-color: #d8d8d8;
                /* Warna border item aktif */
            }

            /* Search Form */
            .search-box {
                background-color: #fff;
            }

            .search {
                position: relative;
                color: #aaa;
                font-size: 16px;
            }

            .search {
                display: inline-block;
            }

            .search input {
                width: 342px;
                height: 32px;
                background: #fcfcfc;
                border: 1px solid #aaa;
                border-radius: 5px;
            }

            .search input {
                text-indent: 32px;
            }

            .search .fa-search {
                position: absolute;
                top: 10px;
                left: 10px;
            }

            .search .fa-search {
                left: auto;
                right: 10px;
            }

            .container-filter-sekolah {
                background-color: #fff;
                padding: 10px;
            }

            /* btn hover */
            .btn-hover {
                background-color: #ABCCFE;
                color: black;
                transition: background-color 0.3s ease;
            }

            .btn-hover:hover {
                background-color: #a5cbe6;
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

            /* Sembunyikan tombol scrollbar (opsional) */
            .sidebar::-webkit-scrollbar-button {
                display: none;
            }

            #map {
                width: 100%;
                /* Atur lebar peta menjadi 80% dari lebar kontainer */
                height: 300px;
                /* Atur tinggi peta menjadi 300px */
            }

            #btnCari {
                min-width: 80px; /* Sesuaikan lebar sesuai kebutuhan */
                background-color:#ABCCFE;
                color:black;
                border:none;
            }

            #tampilan1 {
                display: none; /* Sembunyikan keduanya secara default */
                visibility: hidden;
            }

            .leaflet-routing-container {
                width: 200px; /* Atur lebar kontainer sesuai kebutuhan */
                font-size: 12px; /* Ubah ukuran font sesuai kebutuhan */
            }

            /* Mengubah ukuran kontainer alternatif routing */
            .leaflet-routing-alternatives-container {
                width: 300px; /* Ubah sesuai kebutuhan */
                max-width: 100%;
            }

            /* Mengubah ukuran box routing utama */
            .leaflet-routing-alt {
                font-size: 10px; /* Ubah ukuran font sesuai kebutuhan */
                padding: 10px; /* Menyesuaikan padding */
                max-height: 300px; /* Menentukan tinggi maksimum */
                overflow-y: auto; /* Menambahkan scrollbar jika konten melebihi tinggi maksimum */
            }

            /* Mengubah ukuran ikon instruksi */
            .leaflet-routing-instruction-icon {
                font-size: 14px; /* Ubah ukuran ikon sesuai kebutuhan */
            }

            /* Mengubah gaya tabel instruksi */
            .leaflet-routing-alt table {
                width: 100%; /* Menyesuaikan lebar tabel */
            }

            .leaflet-routing-instruction-text,
            .leaflet-routing-instruction-distance {
                font-size: 20px; /* Ubah ukuran font sesuai kebutuhan */
            }

            table {
                display:none;
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
        <div class="container-fluid content" style="z-index:0;">
            <div class="row">
                <!-- Left Sidebar -->
                <div class="col-md-3 sidebar bg-light p-3" id="sidebar" style="visibility: visible; opacity: 1;">
                    <div style="margin-top: 30px">
                        <h5><b>Daftar Sekolah Inklusi</b></h5>
                    </div>
                    <!-- Search Form -->
                    <div class="search-box">
                        <form class="mb-3 mt-4" id="searchForm">
                            <div class="search">
                                <span class="fa fa-search"></span>
                                <input placeholder="Cari Sekolah" id="searchSekolah" name="inputSekolah" autocomplete="off"/>
                            </div>
                        </form>
                        <div class="suggestions" id="suggestions"></div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <a onclick="toggleTampilan()" class="btn btn-hover" id="buttonMove">
                            Tampilkan Sekolah Dengan Peta
                        </a>
                    </div>

                    <div class="container-filter-sekolah mt-3">
                        <div class="text-center mt-3">
                            <h4><b>Filter Sekolah</b></h4>
                        </div>

                        <div class="mt-3">
                            <b>Jenjang</b>
                            <div class="mt-2 text-center">
                                <select id="jenjangSelect" name="jenjang" class="form-select form-select-sm custom-select" aria-label="Small select example">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($jenjangs as $jenjang)
                                        <option value="{{ $jenjang->id_jenjang }}" {{ request('jenjang') == $jenjang->id_jenjang ? 'selected' : '' }}>
                                            {{ $jenjang->nama_jenjang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <b>Kategori</b>
                            <div class="mt-2 text-center">
                                <select id="kategoriSelect" name="kategori" class="form-select form-select-sm custom-select" aria-label="Small select example">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id_kategori }}" {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                                            {{ $kategori->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <b>Kecamatan</b>
                            <div class="mt-2 text-center">
                                <select id="kecamatanSelect" name="kecamatan" class="form-select form-select-sm custom-select" aria-label="Small select example">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($lokasis as $lokasi)
                                        <option value="{{ $lokasi->kodepos }}" {{ request('kecamatan') == $lokasi->kodepos ? 'selected' : '' }}>
                                            {{ $lokasi->kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-end">
                            <a href="/coba" class="btn btn-sm btn-link me-2">Reset</a>
                            <button type="submit" class="btn btn-sm btn-primary" value="btnCari" id="btnCari">
                            <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
    						<span id="btn-text">Cari</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="col-md-9 main-content" id="tampilan1">
                    <div class="bg-light p-3 main-contentt">
                        <!-- Card Instansi -->
                        <div class="row" id="data-container">
                        @if($paginatedSekolahs->isEmpty())
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    Tidak ada Sekolah ditemukan.
                                </div>
                            </div>
                        @else
                            @foreach ($paginatedSekolahs as $item)
                                <div class="col-md-12" >
                                    <div class="card mb-3" style="width: 900px">
                                        <div class="row g-0">
                                            <div class="col-md-5">
                                                <a href="detailinstansi/{{ $item['NPSN'] }}" >
                                                    @if($item->gambar->isNotEmpty())
                                                        <img src="/img/Sekolah/{{ $item->gambar->first()->nama_file }}" 
                                                        style="width: 300px; height:180px; object-fit: cover;"
                                                        class="img-fluid rounded-start" 
                                                        alt="{{ $item['nama_sekolah'] }}"  />
                                                    @else
                                                        <img src="/img/default.jpg" 
                                                        class="img-fluid rounded-start" 
                                                        alt="Default Image" />
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="card-body">
                                                    <a href="detailinstansi/{{ $item['NPSN'] }}" style="text-decoration: none; color: inherit;"><h5 class="card-title">{{ $item['nama_sekolah'] }}</h5></a>
                                                    <p class="card-text">
                                                        {{ $item['jalan_sekolah'] }}, {{ $item->lokasi->kelurahan }}, {{$item->lokasi->kecamatan}}, Kota Yogyakarta
                                                    </p>
                                                    <i class="fas fa-map-marker-alt"></i>  {{ $item -> distance_formatted }}<br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                            @endforeach
                        @endif
                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            {{ $paginatedSekolahs->links('pagination::bootstrap-4') }} <!-- Gunakan tampilan pagination Bootstrap 4 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 main-content" id="tampilan2" style='visibility:hidden'>
    <!-- Map -->
    @if($paginatedSekolahs->isEmpty())
        <div class="alert alert-info" style="width:800px; float:right; text-align: center; margin-top: 20px; margin-right:13px;">
            Sekolah tidak ditemukan.
        </div>
    @endif
    <div id="map" style="margin-left: 300px; margin-top:50px; width:800px; height:500px;"></div>
    
    
</div>
            </div>
        </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
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
        var schoolMarkers = []; // Array untuk menyimpan marker sekolah
        var destinationLat = null;
        var destinationLng = null;
        // Initialize the map
        var map = L.map('map').setView([-7.787941703710649, 110.36711913611116],13); // Set the initial latitude, longitude, and zoom level

        // Add the tile layer to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        // Definisikan ikon untuk marker
        var markerIcon2 = L.icon({
            iconUrl: 'img/school.png', // URL ke ikon sekolah
            iconSize: [45, 45],        // Ukuran ikon
            iconAnchor: [16, 16],      // Titik jangkar ikon
            popupAnchor: [0, -16]      // Titik jangkar popup relatif terhadap ikon
        });

        var markerIcon3 = L.icon({
            iconUrl: 'img/pin.png',    // URL ke ikon pin
            iconSize: [35, 30],        // Ukuran ikon
            iconAnchor: [16, 16],      // Titik jangkar ikon
            popupAnchor: [0, -16]      // Titik jangkar popup relatif terhadap ikon
        });

        // Tambahkan marker ke peta untuk setiap sekolah
        @foreach ($allSekolahs as $sekolah)
            var marker = L.marker([{{ $sekolah->latitude }}, {{ $sekolah->longitude }}], {icon: markerIcon2}).addTo(map)
            .bindPopup(`
                <div class="popup-content">
                    <img src="/img/Sekolah/{{ $sekolah->gambar->first()->nama_file }}" alt="Gambar"
                    style="width: 100%; height:100px; object-fit: cover;"
                    class="img-fluid rounded-start" />
                    <h5>{{ $sekolah->nama_sekolah }}</h5>
                    <p>{{ $sekolah->jalan_sekolah }}, {{$sekolah->lokasi->kelurahan}}, {{$sekolah->lokasi->kecamatan}}, Kota Yogyakarta</p>
                    <p>Jarak: {{ $sekolah->distance_formatted }}</p>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <button onclick="calculateRoute({{ $sekolah->latitude }}, {{ $sekolah->longitude }})"
                            style="background-color: #ABCCFE; color: black; border: none; border-radius: 5px; padding: 4px 8px; font-size: 12px; cursor: pointer; transition: background-color 0.3s;">
                            Rute
                        </button>
                        <a href="detailinstansi/{{ $sekolah['NPSN'] }}" class="btn btn-sm btn-primary" style="background:none;border: none; color:#0D6EFD; text-decoration: none; transition: color 0.3s;">Detail Sekolah →</a>
                    </div>
                    <div style="margin-top: 10px; text-align: right;">
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $sekolah->latitude }},{{ $sekolah->longitude }}" 
               target="_blank"
               style="background:none; color: #0D6EFD; border: none; border-radius: 5px; padding: 4px 8px; font-size: 12px; text-decoration: none; text-align: center; cursor: pointer; transition: background-color 0.3s;">
               Buka dengan Google Maps 
            </a>
        </div>
                </div>
            `);

            // Ubah ikon ketika popup dibuka
            marker.on('popupopen', function() {
                this.setIcon(markerIcon3);
                map.flyTo(this.getLatLng(), 15, {
                    duration: 1.5 // Duration of the flyTo animation in seconds
                });
                setTimeout(() => {
                    map.panBy([0, -50]); // Adjust the pan by 50 pixels upwards
                }, 1500);

            });

            // Kembalikan ikon asli ketika popup ditutup
            marker.on('popupclose', function() {
                this.setIcon(markerIcon2);
            });

            schoolMarkers.push(marker);

        @endforeach // Add the marker with the initial latitude and longitude

        var markerIcon = L.icon({
            iconUrl: 'img/user.png', // URL to your custom circle image
            iconSize: [40,40], // Size of the icon
            iconAnchor: [16, 16], // Anchor point of the icon, should be half of iconSize
            popupAnchor: [0, -16] // Popup anchor point relative to icon size
        });
    
        var lokasiMarker = L.marker([-7.791285900692581, 110.37626222436796], {
            icon: markerIcon
        }).addTo(map);

        let userLatitude, userLongitude;

        function updateLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.watchPosition(function(position) {
                    userLatitude = position.coords.latitude;
                    userLongitude = position.coords.longitude;

                    lokasiMarker.setLatLng([userLatitude, userLongitude]);
                    
                    lokasiMarker.bindPopup("Kamu berada di sini");

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

        // Create a div for the cancel button (Initially hidden)
        var cancelButton = L.control({ position: 'topright' });

        cancelButton.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'cancel-button');
            div.innerHTML = '<button id="cancel-route-btn" onclick="cancelRoute()" style="display: none;">Tutup Rute</button>';
    
            // Style the button
            var button = div.querySelector('#cancel-route-btn');
            button.style.backgroundColor = '#d9534f'; // Red background color
            button.style.color = 'white'; // White text color
            button.style.border = 'none'; // Remove default border
            button.style.borderRadius = '4px'; // Slightly rounded corners
            button.style.padding = '6px 12px'; // Smaller padding
            button.style.fontSize = '12px'; // Smaller font size
            button.style.cursor = 'pointer'; // Pointer cursor on hover
            button.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)'; // Subtle shadow for better appearance
            button.style.transition = 'background-color 0.3s'; // Smooth color transition on hover
            button.onmouseover = function() {
                button.style.backgroundColor = '#c9302c'; // Darker red on hover
            };
            button.onmouseout = function() {
                button.style.backgroundColor = '#d9534f'; // Original red color
            };
    
            // Style the container div
            div.style.backgroundColor = 'white';
            div.style.padding = '8px'; // Adjust padding to match button size
            div.style.borderRadius = '4px'; // Match button border radius
            div.style.border = '2px solid #ccc';
            div.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            return div;
        };

        cancelButton.addTo(map);

        function calculateRoute(destinationLat, destinationLng) {
            console.log("Calculating route from: ", userLatitude, userLongitude, " to: ", destinationLat, destinationLng);
            map.closePopup(); // Close any open popups

            if (routingControl) {
                map.removeControl(routingControl); // Remove the previous route if it exists
            }

            // Store destination coordinates
            window.destinationLat = destinationLat;
            window.destinationLng = destinationLng;

            // Sembunyikan semua marker sementara
            schoolMarkers.forEach(marker => {
                if (marker.getLatLng().lat !== destinationLat || marker.getLatLng().lng !== destinationLng) {
                    map.removeLayer(marker);
                }
            });
    
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
                    map.flyToBounds(bounds, { padding: [25, 25], duration: 1.5 });
                    document.getElementById('cancel-route-btn').style.display = 'block'; // Tampilkan tombol Batal
                } else {
                    console.error("Error: No valid coordinates found in route.");
                }
            });

            routingControl.on('routingerror', function(e) {
                console.error("Routing error: ", e.error);
            });
        }

        function cancelRoute() {
            if (routingControl) {
                map.removeControl(routingControl); // Hapus rute yang sedang aktif
                routingControl = null;
            }

            // Tampilkan kembali semua marker sekolah
            schoolMarkers.forEach(marker => {
                marker.addTo(map);
            });

            if (destinationLat !== null && destinationLng !== null) {
                map.flyTo([destinationLat, destinationLng], 16, {
                    duration: 2.5 // Duration of the flyTo animation in seconds
                });
            }
            document.getElementById('cancel-route-btn').style.display = 'none'; // Sembunyikan tombol Batal
        }

        //SCRIPT TAMPILAN PETA DAN DAFTAR
        function toggleTampilan() {
            var tampilan1 = document.getElementById('tampilan1');
            var tampilan2 = document.getElementById('tampilan2');
            var buttonMove = document.getElementById('buttonMove');

            if (tampilan1.style.display === "none") {
                tampilan1.style.display = "block";
                tampilan2.style.visibility = "hidden";
                tampilan2.style.display = 'none';
                buttonMove.textContent = "Tampilkan Sekolah Dengan Peta";
                localStorage.setItem('currentTampilan', 'tampilan1');
            } else {
                tampilan1.style.display = "none";
                tampilan2.style.visibility = "visible";
                tampilan2.style.display = 'block';
                buttonMove.textContent = "Tampilkan Sekolah Dengan Daftar";
                localStorage.setItem('currentTampilan', 'tampilan2');
            }
        }

        // Saat halaman dimuat, periksa status tampilan dari localStorage
        document.addEventListener('DOMContentLoaded', function() {
            var currentTampilan = localStorage.getItem('currentTampilan') || 'tampilan1'; // Default ke tampilan1 jika tidak ada
            var tampilan1 = document.getElementById('tampilan1');
            var tampilan2 = document.getElementById('tampilan2');
            var buttonMove = document.getElementById('buttonMove');

            if (currentTampilan === 'tampilan2') {
                tampilan1.style.display = "none";
                tampilan2.style.visibility = "visible";
                tampilan2.style.display = 'block';
                buttonMove.textContent = "Tampilkan Sekolah Dengan Daftar";
            } else {
                tampilan1.style.display = "block";
                tampilan2.style.visibility = "hidden";
                tampilan2.style.display = 'none';
                buttonMove.textContent = "Tampilkan Sekolah Dengan Peta";
            }

            // Tampilkan elemen setelah JavaScript mengatur tampilan
            tampilan1.style.visibility = "visible";
            tampilan2.style.visibility = "visible";
        });

        const searchInput = document.getElementById('searchSekolah');
        const suggestionsBox = document.getElementById('suggestions');

        document.getElementById('searchSekolah').addEventListener('input', function() {
            let query = this.value;
            console.log(query)
            if (query.length > 1) { // mulai menampilkan saran setelah 2 karakter
                fetchSuggestions(query);
            } else {
                document.getElementById('suggestions').innerHTML = '';
            }
        });

        function fetchSuggestions(query) {
            // Ganti URL di bawah ini dengan endpoint API yang sesuai
            fetch(`/coba-json-search?searchkey=${query}`)
                .then(response => response.json())
                .then(data => {
                    displaySuggestions(data);
                })
                .catch(error => {
                    console.error('Error fetching suggestions:', error);
                });
        }

        function displaySuggestions(suggestions) {
            const suggestionsBox = document.getElementById('suggestions');
            suggestionsBox.innerHTML = '';
            if (suggestions) {
                suggestions.forEach(sekolah => {
                    // console.log(sekolah.nama_sekolah)
                    const suggestionItem = document.createElement('div');
                    suggestionItem.className = 'suggestion-item';
                    suggestionItem.textContent = sekolah.nama_sekolah;
                    suggestionItem.addEventListener('click', function() {
                        searchInput.value = sekolah.nama_sekolah;
                        suggestionsBox.innerHTML = '';
                        document.getElementById('searchForm').submit();
                    });
                    suggestionsBox.appendChild(suggestionItem);
                });
            }
        }

        //UNTUK FITUR FILTER
        document.getElementById('btnCari').addEventListener('click', function() {
            var jenjang = document.getElementById('jenjangSelect')?.value || '';
            var kategori = document.getElementById('kategoriSelect').value || '';
            var kecamatan = document.getElementById('kecamatanSelect').value || '';

            var url = new URL(window.location.href);
            url.searchParams.set('jenjang', jenjang);
            url.searchParams.set('kategori', kategori);
            url.searchParams.set('kecamatan', kecamatan);
            url.searchParams.set('page', 1); // Reset ke halaman pertama ketika melakukan pencarian baru

            window.location.href = url.toString();
        });
        document.addEventListener('DOMContentLoaded', function() {
    			var submitBtn = document.getElementById('btnCari');
			    var spinner = document.getElementById('spinner');
    			var btnText = document.getElementById('btn-text');

			    submitBtn.addEventListener('click', function() {
        			// Show the spinner
			        spinner.classList.remove('d-none');
        			btnText.classList.add('d-none');

    			    // Optionally, disable the button to prevent multiple submissions
    			    submitBtn.classList.add('btn-loading');
    			});
			});
    </script>

</body>

</html>
