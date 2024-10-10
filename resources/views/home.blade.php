@extends('layout.mainlayout')
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Bootstrap Layout</title>
		<!-- Bootstrap CSS -->
		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
			crossorigin="anonymous"
		/>
		<link href="" rel="stylesheet" />

		<style>
			@import url('https://fonts.googleapis.com/css2?family=Zilla+Slab:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap');
			@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');
			/* Custom CSS */

			/* Main Content */
			.content {
				margin-top: 80px; /* Adjust based on header height */
			}

			/* Left Sidebar */
			.sidebar {
				position: fixed;
				top: 80px; /* Same as header height */
				bottom: 0;
				left: 0;
				z-index: 100;
				overflow-y: auto;
				padding-top: 20px;
			}

			/* Main Content Area */
			.main-content {
				padding: 20px;
			}

			@media (min-width: 768px) {
				.main-content {
					margin-left: 250px; /* Adjust based on sidebar width */
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
				background-color: #c7ddf4;
				color: black;
				transition: background-color 0.3s ease;
			}

			.btn-hover:hover {
				background-color: #a5cbe6;
			}

			body::-webkit-scrollbar {
				width: 8px; /* Contoh: Mengatur lebar scrollbar di browser WebKit (seperti Chrome, Safari) */
			}

			body::-webkit-scrollbar-track {
				background-color: #f1f1f1; /* Warna latar belakang scrollbar */
			}

			body::-webkit-scrollbar-thumb {
				background-color: #888; /* Warna handle scrollbar */
				border-radius: 4px; /* Membuat sudut handle scrollbar lebih melengkung */
			}

			/* Hide the scrollbar buttons (optional) */
			body::-webkit-scrollbar-button {
				display: none;
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

			.search-box {
			    position: relative;
			}

			.suggestions {
				position: absolute;
				background: white;
				border: 1px solid #ccc;
				max-height: 200px;
				overflow-y: auto;
				z-index: 1000;
				width: 100%;
			}

			.suggestion-item {
				padding: 10px;
				cursor: pointer;
			}

			.suggestion-item:hover {
				background-color: #f0f0f0;
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
				<!-- Left Sidebar -->
				<div class="col-md-3 sidebar bg-light p-3" id="sidebar">
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
						<a href="/tambahdata" class="btn btn-primary" style="background-color:#ABCCFE; border:none; color:black;" >Tambah Data</a>
					</div>
				</div>

				<!-- Main Content Area -->
				<div class="col-md-9 main-content">
					<div class="bg-light p-3 main-contentt">
						<!-- Card Instansi -->
						<div class="row">
							@foreach ($sekolahs as $sekolah)
								<div class="col-md-12">
									<div class="card mb-3" style="width: 900px;" >
										<div class="row g-0">
											<div class="col-md-5">
												@if($sekolah->gambar->isNotEmpty())
                                                    <img src="/img/Sekolah/{{ $sekolah->gambar->first()->nama_file }}" 
                                                    style="width: 300px; height:180px; object-fit: cover;"
                                                    class="img-fluid rounded-start" 
                                                    alt="{{ $sekolah['nama_sekolah'] }}"  />
                                                @else
                                                    <img src="/img/default.jpg" 
                                                    class="img-fluid rounded-start" 
                                                    alt="Default Image" />
                                                @endif
											</div>
											<div class="col-md-7" >
												<div class="card-body">
													<h5 class="card-title">{{ $sekolah->nama_sekolah }}</h5>
													<p class="card-text">
														{{ $sekolah->jalan_sekolah }}, {{ $sekolah->lokasi->kelurahan }}, Kec.
                                					    {{ $sekolah->lokasi->kecamatan }}, Kota Yogyakarta, Daerah Istimewa Yogyakarta
                        					            {{ $sekolah->lokasi->kodepos }}.
													</p>					
												</div>
												<div class="d-flex justify-content-end mr-3">
													<!-- Button Edit with icon -->
													<a href="{{ route('sekolah.edit', $sekolah->NPSN) }}" class="btn btn-primary" style="margin-right:10px; background-color:#0D6EFD; border:none;">
														<i class="fas fa-edit"></i>
													</a>
													<!-- Button Delete with icon -->
													<button type="button" class="btn btn-danger delete-btn" data-id="{{ $sekolah->NPSN }}" data-nama="{{$sekolah->nama_sekolah}}" style="margin-right:20px; background-color:#F44336; border:none;">
														<i class="fas fa-trash"></i>
													</button>
												</div>
											</div>	
										</div>
									</div>
								</div>				
							@endforeach 
							<div class="d-flex justify-content-between mt-4">
								<div>
									{{ $sekolahs->links('pagination::bootstrap-4') }} <!-- Gunakan tampilan pagination Bootstrap 4 -->
								</div>
                        	</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  			<div class="modal-dialog">
    			<div class="modal-content">
    			  	<div class="modal-header">
        				<h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
        				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      				</div>
      				<div class="modal-body">
        				Apakah Anda yakin ingin menghapus Sekolah <span id="sekolah-nama"></span>?
      				</div>
      				<div class="modal-footer">
        				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        				<button type="button" class="btn btn-danger" id="confirmDeleteButton" style="background-color:#F44336;">
					<span>Hapus</span>
					<div class="spinner-border spinner-border-sm text-light d-none" role="status" id="deleteSpinner">
						<span class="visually-hidden">Sedang memuat...</span>
					</div>
				</button>
						
      				</div>
    			</div>
  			</div>
		</div>

		<!-- Bootstrap JS (Optional) -->
		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
			crossorigin="anonymous"
		>
		</script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const fadeOutElement = document.getElementById('fadeOut');

				// Tunggu 0.5 detik sebelum menambahkan kelas 'hidden'
				setTimeout(function() {
					fadeOutElement.classList.add('hidden');
				}, 500); // 500 ms = 0.5 detik
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
				fetch(`/home-json-search?searchkey=${query}`)
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

			document.addEventListener('DOMContentLoaded', function () {
	const deleteButtons = document.querySelectorAll('.delete-btn');
	let deleteNPSN = null;
	let deleteNamaSekolah = null;
	const deleteSpinner = document.getElementById('deleteSpinner');
	const confirmDeleteButton = document.getElementById('confirmDeleteButton');
	const confirmDeleteModal = document.getElementById('confirmDeleteModal');
	const confirmDeleteButtonText = confirmDeleteButton.querySelector('span');

	deleteButtons.forEach(button => {
		button.addEventListener('click', function () {
			deleteNPSN = this.getAttribute('data-id');
			deleteNamaSekolah = this.getAttribute('data-nama');
			document.getElementById('sekolah-nama').innerText = deleteNamaSekolah;
			new bootstrap.Modal(confirmDeleteModal).show();
		});
	});

	document.getElementById('confirmDeleteButton').addEventListener('click', function () {
		// Sembunyikan teks "Hapus" dan tampilkan spinner
		confirmDeleteButtonText.classList.add('d-none');
		deleteSpinner.classList.remove('d-none');
		confirmDeleteButton.setAttribute('disabled', 'true');

		// Kirim permintaan penghapusan ke server
		fetch('/home/delete', { // Ganti dengan rute yang sesuai
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			},
			body: JSON.stringify({ npsn: deleteNPSN })
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				document.querySelector(`[data-id="${deleteNPSN}"]`).closest('.card').remove();
				alert(`${deleteNamaSekolah} berhasil dihapus.`);
				// Sembunyikan modal setelah penghapusan berhasil
				bootstrap.Modal.getInstance(confirmDeleteModal).hide();
			} else {
				alert('Gagal menghapus data: ' + data.message);
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Terjadi kesalahan.');
		})
		.finally(() => {
			// Tampilkan kembali teks "Hapus", sembunyikan spinner, dan aktifkan tombol kembali
			confirmDeleteButtonText.classList.remove('d-none');
			deleteSpinner.classList.add('d-none');
			confirmDeleteButton.removeAttribute('disabled');
		});
	});
});

			
		</script>
	</body>
</html>
