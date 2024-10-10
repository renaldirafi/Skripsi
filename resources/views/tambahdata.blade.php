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
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
		<style>
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
				margin-right: 5px; /* Jarak antara setiap item halaman */
			}
			.pagination .page-link {
				border: 1px solid #ddd; /* Warna border kotak */
				padding: 8px 20px; /* Padding di dalam kotak */
				border-radius: 4px; /* Membuat sudut kotak lebih melengkung */
				transition: all 0.3s ease; /* Efek transisi hover */
				color: #000000; /* Warna teks */
				background-color: #fff; /* Warna latar belakang */
			}
			.pagination .page-link:hover {
				background-color: #d8d8d8; /* Warna latar belakang saat hover */
			}
			.pagination .page-item.active .page-link {
				background-color: #d8d8d8; /* Warna latar belakang item aktif */
				color: #000000; /* Warna teks item aktif */
				border-color: #d8d8d8; /* Warna border item aktif */
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

			/* CSS untuk scrollbar di sidebar */
			.sidebar::-webkit-scrollbar {
				width: 8px; /* Lebar scrollbar */
			}

			.sidebar::-webkit-scrollbar-track {
				background-color: #f1f1f1; /* Warna latar belakang scrollbar */
			}

			.sidebar::-webkit-scrollbar-thumb {
				background-color: #888; /* Warna handle scrollbar */
				border-radius: 4px; /* Membuat sudut handle scrollbar lebih melengkung */
			}

			/* Sembunyikan tombol scrollbar (opsional) */
			.sidebar::-webkit-scrollbar-button {
				display: none;
			}

			.back-button {
            	margin-bottom: 20px;
	        }

	        .back-button a {
    	        font-size: 14px;
        	    color: #007bff;
            	text-decoration: none;
	        }

			.back-button a:hover {
				
				text-decoration: underline;
			}

			.btn-remove {
				background: none; /* Hilangkan background */
				border: none; /* Hilangkan border */
				color: #dc3545; /* Warna teks merah (sesuai dengan warna 'btn-danger') */
				font-size: 14px; /* Sesuaikan ukuran font */
				cursor: pointer; /* Tunjukkan bahwa ini adalah tombol yang dapat diklik */
			}

			.btn-remove:hover {
				text-decoration: underline; /* Tambahkan garis bawah saat hover */
			}

			.d-flex {
				display: flex;
				align-items: center;
			}

			.d-flex .btn {
				margin-right: 10px; /* Jarak antara tombol-tombol */
			}

			.d-flex .btn.ms-2 {
				margin-left: 10px; /* Jarak antara tombol "Tambah" dan tombol "Hapus" */
			}

			#spinner {
				margin-right: 5px;
			}

			/* Optionally, add styles for the button in loading state */
			.btn-loading {
				pointer-events: none;
				opacity: 0.7;
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

			input[type=number]::-webkit-inner-spin-button,
			input[type=number]::-webkit-outer-spin-button {
				-webkit-appearance: none;
				margin: 0;
			}

			/* Hapus spinner di Firefox */
			input[type=number] {
				-moz-appearance: textfield;
			}
    	</style>
	</head>
	<body>
		<div id="fadeOut" class="fade-out"></div>

		<!-- Main Content -->
		<div class="container-fluid content">
			<div class="row">
				<!-- Main Content Area -->
				<div class="col-md-12 main-content">
					<div class="bg-light p-3 main-contentt">
						<div class="back-button">
    						<a href="/home" class="btn btn-link">
        						<i class="fas fa-arrow-left"></i> Kembali
    						</a>
						</div>
						<h2>Tambah Data Sekolah</h2>
						@if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
						<form action="/tambahdata" method="POST" enctype="multipart/form-data">
                   			@csrf
	            			<div class="row mt-5">
					          	<div class="col-md-4">
        	        				<div class="card" style="width: 18rem;">
				                  		<div class="card-body">
				            		        <h5 class="card-title"><i class="fas fa-image"></i> Foto Sekolah Inklusi <span class="text-danger">*</span></h5>
            					    		<h6 class="card-subtitle mb-2 text-body-secondary"></h6>
			            			        <div class="form-group">
												<label for="file-upload">Pilih File:</label>
                								<input type="file" class="form-control-file @error('files') is-invalid @enderror" id="file-upload" name="files[]" multiple accept=".jpg,.jpeg,.png">
                								@error('files')
                    								<span class="text-danger">{{ $message }}</span>
                								@enderror
                								@error('files.*')
                    								<span class="text-danger">{{ $message }}</span>
                								@enderror
											</div>
				              			</div>
        	        				</div>
            	  				</div>
              					{{-- Profil Sekolah Inklusi --}}
            					<div class="col-md-4">
            						<div class="card" style="width: 18rem;">
				  	    	            <div class="card-body">
					        	            <h5 class="card-title"><i class="fas fa-school"></i> Profil Sekolah Inklusi </h5>
					                	    <label for="npsn" class="form-label">NPSN <span class="text-danger">*</span></label>
											<input type="text" class="form-control @error('npsn') is-invalid @enderror" id="npsn" name="npsn" value="{{ old('npsn') }}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
        									@error('npsn')
											<div class="text-danger">{{ $message }}</div>
        									@enderror

						                    <label for="nama_sekolah" class="form-label mt-2">Nama Sekolah <span class="text-danger">*</span></label>
    	                					<input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror" id="nama_sekolah" name="nama_sekolah" value="{{ old('nama_sekolah') }}"maxlength="255">
											@error('nama_sekolah')
            									<div class="text-danger">Nama Sekolah tidak boleh kosong</div>
        									@enderror

						                    <label for="jalan_sekolah" class="form-label mt-2">Jalan Sekolah <span class="text-danger">*</span></label>
        	            					<input type="text" class="form-control @error('jalan_sekolah') is-invalid @enderror" id="jalan_sekolah" name="jalan_sekolah" value="{{ old('jalan_sekolah') }}"maxlength="255">
											@error('jalan_sekolah')
            									<div class="text-danger">Jalan Sekolah tidak boleh kosong</div>
        									@enderror

						                    <label for="kodepos" class="form-label mt-2">Kode Pos <span class="text-danger">*</span></label>
        	            					<select class="form-select @error('kodepos') is-invalid @enderror" id="kodepos" name="kodepos" style="max-height: 100px; overflow-y: auto;">
										    	<option value="{{ old('kodepos') }}" selected></option>
										    	@foreach ($lokasis as $lokasi)
										        	<option value="{{ $lokasi->kodepos }}">{{ $lokasi->kodepos }} - {{ $lokasi->kelurahan }}</option>
    											@endforeach
											</select>
											@error('kodepos')
            									<div class="text-danger">Kode pos tidak boleh kosong</div>
        									@enderror

											<label for="latitude" class="form-label mt-2">Latitude <span class="text-danger">*</span></label>
                    						<input type="number" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}"  step="0.000000000000001">
											@error('latitude')
            									<div class="text-danger">Latitude tidak boleh kosong</div>
        									@enderror

											<label for="longitude" class="form-label mt-2">Longitude <span class="text-danger">*</span></label>
        	            					<input type="number" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" step="0.0000000000000001">
											@error('longitude')
            									<div class="text-danger">Longitude tidak boleh kosong</div>
        									@enderror

											<label for="jenjang" class="form-label mt-2">Jenjang <span class="text-danger">*</span></label>
        	            					<select class="form-select @error('jenjang') is-invalid @enderror" id="jenjang" name="jenjang" style="max-height: 100px; overflow-y: auto;">
    											<option value="{{ old('jenjang') }}" selected></option>
    											@foreach ($jenjangs as $jenjang)
        											<option value="{{ $jenjang->id_jenjang }}">{{ $jenjang->nama_jenjang }}</option>
    											@endforeach
											</select>
											@error('jenjang')
            									<div class="text-danger">Jenjang tidak boleh kosong</div>
        									@enderror

						                    <label for="web_sekolah" class="form-label mt-2">Website Sekolah <span class="text-danger">*</span></label>
        	            					<input type="text" class="form-control @error('web_sekolah') is-invalid @enderror" id="web_sekolah" name="web_sekolah" value="{{ old('web_sekolah') }}" maxlength="50">
											@error('web_sekolah')
            									<div class="text-danger">Website Sekolah tidak boleh kosong</div>
        									@enderror

						                    <label for="total_siswa" class="form-label mt-2">Total Siswa <span class="text-danger">*</span></label>
        	            					<input type="text" class="form-control @error('total_siswa') is-invalid @enderror" id="total_siswa" name="total_siswa" value="{{ old('total_siswa') }}" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);">
											@error('total_siswa')
            									<div class="text-danger">Total Siswa minimal 1</div>
        									@enderror
    	              					</div>
        	        				</div>
            	  				</div>
              					{{-- Kategori Inklusi --}}
								<div class="col-md-4">
    								<div class="card" style="width: 18rem;">
        								<div class="card-body">
            								<h5 class="card-title"><i class="fas fa-wheelchair"></i> Kategori Inklusi <span class="text-danger">*</span></h5>
            								<h6 class="card-subtitle mb-2 text-body-secondary"></h6>

            								<div class="row">
                								<div class="col-md-7">
                    								<p>Kategori</p>
                								</div>
                								<div class="col-md-5">
                    								<p style="font-size:14px; margin-left:17px;">Total Siswa</p>
								                </div>
								            </div>

            								<div id="kategori-container">
                								<div class="row add_content">
                    								<div class="col-md-8 ">
                        								<select class="form-select form-select-sm kategori-select" name="kategoris[0][id_kategori]">
                            								<option selected>-- Pilih --</option>
                            								@foreach ($kategoris as $item)
                                								<option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                            								@endforeach
                        								</select>
        											</div>
        											<div class="col-md-4">
            											<input class="form-control form-control-sm kategori-total" type="number" name="kategoris[0][total_siswa]" maxlength="4" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4);">
                									</div>
													<div class="col-md-12">
            										@error('kategoris.0.id_kategori')
													<div class="text-danger">{{ $message }}</div>
            										@enderror
            										@error('kategoris.0.total_siswa')
                										<span class="text-danger">Total Siswa minimal 1</span>
            										@enderror
            										</div>
												</div>
											</div>
            								<div class="d-flex align-items-center mt-2">
												<button type="button" class="btn btn-primary btn-sm" id="addKategori"><i class="fas fa-plus"></i> Kategori</button>
        										<button type="button" class="btn btn-remove btn-sm ms-2 d-none" id="removeKategori" style="color:#F44336;"><i class="fas fa-minus"></i> Kategori</button>
    										</div>

            								<p class="mt-4">Fasilitas <span class="text-danger">*</span></p>
            								<div id="fasilitas-container">
                								<div class="row add_content2 mt-2">
                    								<div class="col-md-12">
                        								<select class="form-select form-select-sm fasilitas-select" name="fasilitas[0][id_fasilitas]">
                          		  							<option selected>-- Pilih --</option>
                            								@foreach ($fasilitas as $item)
                                								<option value="{{ $item->id_fasilitas }}">{{ $item->nama_fasilitas }}</option>
                            								@endforeach
                								        </select>
                								    </div>
													@error('fasilitas.0.id_fasilitas')
													<div class="text-danger">{{ $message }}</div>
            										@enderror
            								    </div>
            								</div>
											<div class="d-flex align-items-center mt-2">
												<button type="button" class="btn btn-primary btn-sm" id="addFasilitas" ><i class="fas fa-plus"></i> Fasilitas</button>
        										<button type="button" class="btn btn-remove btn-sm ms-2 d-none" id="removeFasilitas" style="color:#F44336;"><i class="fas fa-minus"></i> Fasilitas</button>
    										</div>
        								</div>
    								</div>
					        		<div class="row mt-5">
					        		    <div class="col-md-12 d-flex justify-content-end">
					                		<button type="reset" class="btn btn-sm btn-danger" style="margin-right: 20px; background-color:#F44336;">Batal</button>
							                <button type="submit" class="btn btn-sm btn-success text-white" id="submitBtn" style="margin-right:30%; background-color:#0D6EFD; border:none;">
    											<span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
    											<span id="btn-text">Simpan</span>
											</button>
					            		</div>
				            		</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Bootstrap JS (Optional) -->
		<script
			src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
			integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
			crossorigin="anonymous"
		></script>

	    <script>
			document.addEventListener('DOMContentLoaded', function() {
        		const fadeOutElement = document.getElementById('fadeOut');

		        // Tunggu 0.5 detik sebelum menambahkan kelas 'hidden'
        		setTimeout(function() {
		            fadeOutElement.classList.add('hidden');
        		}, 500); // 500 ms = 0.5 detik
		    });
	
			document.addEventListener('DOMContentLoaded', function() {
    			var submitBtn = document.getElementById('submitBtn');
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

			document.addEventListener('DOMContentLoaded', function () {
		        const addKategoriBtn = document.getElementById('addKategori');
        		const removeKategoriBtn = document.getElementById('removeKategori');
		        const kategoriContainer = document.getElementById('kategori-container');
        
        		const addFasilitasBtn = document.getElementById('addFasilitas');
		        const removeFasilitasBtn = document.getElementById('removeFasilitas');
        		const fasilitasContainer = document.getElementById('fasilitas-container');

		        addKategoriBtn.addEventListener('click', function () {
        		    // Tambahkan kategori baru
		            const index = kategoriContainer.querySelectorAll('.add_content').length;
        		    const newRow = document.createElement('div');
		            newRow.className = 'row add_content mt-2';
        		    newRow.dataset.index = index;
            		newRow.innerHTML = `
                		<div class="col-md-8">
                    		<select class="form-select form-select-sm kategori-select" name="kategoris[${index}][id_kategori]">
                        		<option selected>-- Pilih --</option>
                        		@foreach ($kategoris as $item)
                            		<option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                        		@endforeach
                    		</select>
                		</div>
                		<div class="col-md-4">
                    		<input class="form-control form-control-sm kategori-total" type="text" name="kategoris[${index}][total_siswa]" aria-label=".form-control-sm example">
                		</div>
            		`;
            		kategoriContainer.appendChild(newRow);

            		// Tampilkan tombol hapus jika lebih dari satu kategori
            		if (kategoriContainer.querySelectorAll('.add_content').length > 1) {
                		removeKategoriBtn.classList.remove('d-none');
            		}
        		});

        		removeKategoriBtn.addEventListener('click', function () {
            		const rows = kategoriContainer.querySelectorAll('.add_content');
            		if (rows.length > 1) {
                		kategoriContainer.removeChild(rows[rows.length - 1]); // Hapus kategori terakhir
            		}
            		// Sembunyikan tombol hapus jika hanya tersisa satu kategori
            		if (kategoriContainer.querySelectorAll('.add_content').length <= 1) {
            		    removeKategoriBtn.classList.add('d-none');
            		}
        		});

        		addFasilitasBtn.addEventListener('click', function () {
            		// Tambahkan fasilitas baru
            		const index = fasilitasContainer.querySelectorAll('.add_content2').length;
            		const newRow = document.createElement('div');
            		newRow.className = 'row add_content2 mt-2';
            		newRow.dataset.index = index;
            		newRow.innerHTML = `
                		<div class="col-md-12">
                    		<select class="form-select form-select-sm fasilitas-select" name="fasilitas[${index}][id_fasilitas]">
                        		<option selected>-- Pilih --</option>
                        		@foreach ($fasilitas as $item)
                            		<option value="{{ $item->id_fasilitas }}">{{ $item->nama_fasilitas }}</option>
                        		@endforeach
                    		</select>
                		</div>
            		`;
            		fasilitasContainer.appendChild(newRow);

            		// Tampilkan tombol hapus jika lebih dari satu fasilitas
            		if (fasilitasContainer.querySelectorAll('.add_content2').length > 1) {
                		removeFasilitasBtn.classList.remove('d-none');
            		}
        		});

        		removeFasilitasBtn.addEventListener('click', function () {
            		const rows = fasilitasContainer.querySelectorAll('.add_content2');
            		if (rows.length > 1) {
                		fasilitasContainer.removeChild(rows[rows.length - 1]); // Hapus fasilitas terakhir
            		}
            		// Sembunyikan tombol hapus jika hanya tersisa satu fasilitas
            		if (fasilitasContainer.querySelectorAll('.add_content2').length <= 1) {
                		removeFasilitasBtn.classList.add('d-none');
            		}
        		});
    		});
		</script>
	</body>
</html>
