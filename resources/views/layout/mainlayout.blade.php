<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            z-index: 0;
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .lds-default {
            color: #1c4c5b; /* Ubah warna di sini */
        }

        .lds-default,
        .lds-default div {
            box-sizing: border-box;
        }

        .lds-default {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
            top: 40%;
        }

        .lds-default div {
            position: absolute;
            width: 6.4px;
            height: 6.4px;
            background: currentColor;
            border-radius: 50%;
            animation: lds-default 1.2s linear infinite;
        }

        .lds-default div:nth-child(1) { animation-delay: 0s; top: 36.8px; left: 66.24px; }
        .lds-default div:nth-child(2) { animation-delay: -0.1s; top: 22.08px; left: 62.29579px; }
        .lds-default div:nth-child(3) { animation-delay: -0.2s; top: 11.30421px; left: 51.52px; }
        .lds-default div:nth-child(4) { animation-delay: -0.3s; top: 7.36px; left: 36.8px; }
        .lds-default div:nth-child(5) { animation-delay: -0.4s; top: 11.30421px; left: 22.08px; }
        .lds-default div:nth-child(6) { animation-delay: -0.5s; top: 22.08px; left: 11.30421px; }
        .lds-default div:nth-child(7) { animation-delay: -0.6s; top: 36.8px; left: 7.36px; }
        .lds-default div:nth-child(8) { animation-delay: -0.7s; top: 51.52px; left: 11.30421px; }
        .lds-default div:nth-child(9) { animation-delay: -0.8s; top: 62.29579px; left: 22.08px; }
        .lds-default div:nth-child(10) { animation-delay: -0.9s; top: 66.24px; left: 36.8px; }
        .lds-default div:nth-child(11) { animation-delay: -1s; top: 62.29579px; left: 51.52px; }
        .lds-default div:nth-child(12) { animation-delay: -1.1s; top: 51.52px; left: 62.29579px; }

        @keyframes lds-default {
            0%, 20%, 80%, 100% { transform: scale(1); }
            50% { transform: scale(1.5); }
        }
        a {
        text-decoration: none;
        color: inherit; /* Mengatur warna teks agar mengikuti elemen sekitarnya */
    }
        .overlay {
            z-index: 9999;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ffffff; /* Background solid, tanpa transparansi */
            text-align: center;
            opacity: 1; /* Pastikan overlay sepenuhnya opaque */
        }
        .logout-button {
            background-color: transparent;
            color: #f44336; /* Warna merah */
            border: none;
            padding: 0;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }

        .logout-button:hover {
            text-decoration: underline;
            color: #d32f2f; /* Warna merah lebih gelap saat dihover */
        }
    </style>
</head>
<body onload="hide_loading();">
    <div class="loading overlay">
        <div class="lds-default">
            <div></div><div></div><div></div><div></div><div></div><div></div>
            <div></div><div></div><div></div><div></div><div></div><div></div>
        </div>
    </div>

    <header class="bg-white text-light py-3 shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="/beranda"><img src="/img/logo.jpg" alt="" width="50px" /></a>
                    
                </div>
                <div class="col">
                    <a href="/beranda" style="display:inline-block;"><h5 class="text-black">SISTEM INFORMASI GEOGRAFIS</h5>
                    <h5 class="text-black">SEKOLAH INKLUSI KOTA YOGYAKARTA</h5></a>
                </div>
                <div class="col-auto">
                    @auth
                        <a href="{{ route('logout') }}" class="logout-button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <script>
        let fadeTarget = document.querySelector('.loading');

        function show_loading() {
            fadeTarget.style.display = 'block';

        }

        function hide_loading() {
            let fadeEffect = setInterval(() => {
                if (!fadeTarget.style.opacity) {
                    fadeTarget.style.opacity = 1;
                }
                if (fadeTarget.style.opacity > 0) {
                    fadeTarget.style.opacity -= 0.09;
                } else {
                    clearInterval(fadeEffect);
                    fadeTarget.style.display = 'none';
                }
            },100);
        }

        function tampil_data() {
            show_loading();
            setTimeout(() => {
                hide_loading();
            }, 1000);
        }
    </script>
</body>
