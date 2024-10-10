@extends('layout.mainlayout')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    		<link
			href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
			rel="stylesheet"
			integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
			crossorigin="anonymous"
		    />
        <style>
            .center {
                margin-top:80px;
                position: relative;
                text-align:center;
                display:flex;
                justify-content: center;
                align-items:center;
                height: 70vh; /* Set tinggi agar bisa memusatkan secara vertikal */
                flex-direction: column;
            }
            .center-text{
                text-align:center;
                font-size: 24px;
            }

            .btn-custom {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius:10px;
                font-size:20px;
                width:200px;
                height:50px;
                background-color: #abccfe;
                margin-top:10px;
                color: black;
                text-decoration: none;
                cursor: pointer;
            }

            .btn-custom:hover {
                background-color: #a5cbe6;
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
            .modal {
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 1000px;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }
    .modal-content {
        margin: 15% auto;
        padding: 20px;
        border-radius: 12px;
        width: 50%;
    }
    .close {
        font-size: 28px;
        font-weight: bold;
    }
        </style>
    </head>
    <body>
        <div id="fadeOut" class="fade-out"></div>
        <div class="center">
            <div>
                <img src="inklusii.jpg" alt="Gambar Anda" style="width: 350px; height: 250px;">
            </div>

            <div class="center-text">
                <p>Cari Sekolah Inklusi Dengan Cepat</p>
            </div>
            
            <div>
                <select id="kategoriSelect" style="width:750px; font-size:20px; border-radius:12px; padding:10px;">
                    <option value="" disabled selected >Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{$kategori->id_kategori}}">{{$kategori->nama_kategori}}</option>
                    @endforeach
                </select>
                <div id="infoIcon" style="display: inline-block; width: 20px; height: 20px; border: 2px solid black; border-radius: 50%; text-align: center; line-height: 18px; margin-left: 10px; cursor: pointer;">
            <span style="color: black; font-weight: bold; font-size: 14px;">!</span>
        </div>
            </div>       
            <div>
                <a  class="btn-custom" id="cariBtn">Cari</a>
            </div> 
        </div> 
        
        <div id="kategoriModal" class="modal" style="display: none;">
            <div class="modal-content" style="padding: 20px; border-radius: 12px; background-color: white; max-height:400px; max-width:750px; overflow-y:auto;">
                <span class="close" id="closeModal" style="position:absolute; right:20px; top:10px; cursor: pointer;">&times;</span>
                <h2>Penjelasan Kategori Sekolah Inklusi</h2>
                <ul>
                    <li><strong>Low Vision:</strong> Anak yang  bila  melihat  sesuatu,  mata  harus  didekatkan,  atau  mata  harus  dijauhkan  dari  objek  yang dilihatnya, atau mereka yang memiliki pemandangan kabur ketika melihat objek.</li>
                    <li><strong>Tuna Rungu:</strong> Anak yang mengalami gangguan pada organ  pendengarannya  sehingga mengakibatkan  ketidakmampuan mendengar, dengan tingkatan yang ringan.</li>
                    <li><strong>Slow Learner:</strong> Anak yang memiliki prestasi belajar rendah atau sedikit di bawah rata-rata anak pada umumnya.</li>
                    <li><strong>Tunagrahita:</strong> Anak yang memiliki gangguan intelektual, seperti gangguan perkembangan belajar, penalaran sosial dan kemampuan hidup serta memiliki IQ dibawah rata-rata.</li>
                    <li><strong>Attention Deficit and Hyperactivity Disorder (ADHD):</strong> Anak yang kesulitan dalam memusatkan perhatian. Sulit berkonsentrasi (<i>inattention</i>), gangguan dalam mengontrol gerakan (<i>hyperactivity</i>), serta memiliki hambatan dalam pengendalian diri (<i>impulsivity</i>).</li>
                    <li><strong>Autis:</strong> Anak yang mengalami gangguan akan kemampuan sosial sehingga sulit bersosialisasi</li>
                    <li><strong>Tunadaksa:</strong> Anak yang mengalami kelainan atau kecacatan pada fungsi otot, tulang, persendian, syaraf, dan atau otak, sehingga mereka mengalami gangguan gerak, mobilisasi, persepsi, emosi, dan ada yang disertai gangguan kecerdasan</li>
                    <li><strong>Disleksia:</strong> Anak yang memiliki kemampuan membaca yang berada di bawah kemampuan seharusnya dengan mempertimbangkan tingkat intelegensi, usia, dan pendidikannya</li>
                    <li><strong>Cerdas Istimewa Berbakat Istimewa (CIBI):</strong> Anak yang memiliki kemampuan dan intelegensi di atas rata-rata atau dapat dikatakan sebagai anak yang mempunyai daya kreativitas tinggi sehingga menjadikan anak susah berinteraksi dan bersosialisasi dengan baik.</li>
                    <li><strong>Hiperaktif:</strong>  Anak yang sangat aktif dan gelisah, sering bergerak atau berbicara berlebihan, serta kesulitan duduk diam.</li>
                    <li><strong>Down Syndrome:</strong> Anak yang memiliki kondisi keterbelakangan perkembangan fisik dan mental anak yang diakibatkan adanya abnormalitas perkembangan kromosom</li>
                    <li><strong>Tuna Laras:</strong> Anak yang mengalami gangguan atau hambatan emosi dan berkelainan tingkah laku, sehingga kurang dapat menyesuaikan diri dengan baik.</li>
                    <li><strong>Retardasi Mental:</strong> Anak yang memiliki kinerja dan daya intelektual seseorang sangat rendah dengan rata-rata atau IQ di bawah 70.</li>
                </ul>
            </div>
        </div>
        <!-- Load Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fadeOutElement = document.getElementById('fadeOut');

                // Tunggu 0.5 detik sebelum menambahkan kelas 'hidden'
                setTimeout(function() {
                    fadeOutElement.classList.add('hidden');
                }, 500); // 500 ms = 0.5 detik
            });
            document.getElementById('cariBtn').addEventListener('click', function() {
                var selectedCategoryId = document.getElementById('kategoriSelect').value;
                var nextPageUrl = '/coba?kategori=' + selectedCategoryId;
                window.location.href = nextPageUrl;
            });

            const infoIcon = document.getElementById('infoIcon');
    const modal = document.getElementById('kategoriModal');
    const closeModal = document.getElementById('closeModal');

    // Ketika ikon tanda seru diklik, tampilkan modal
    infoIcon.addEventListener('click', function() {
        modal.style.display = 'block';
    });

    // Ketika tombol close diklik, sembunyikan modal
    closeModal.addEventListener('click', function() {
        modal.style.display = 'none';
    });

    // Ketika user mengklik di luar modal, sembunyikan modal
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
        </script>
    </body>
</html>