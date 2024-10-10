<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use App\Models\KategoriSekolah;
use App\Models\Fasilitas;
use App\Models\Gambar;
use App\Models\FasilitasSekolah;
use App\Models\Lokasi;
use App\Models\Sekolah;
use App\Models\Jenjang;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class KategoriController extends Controller
{
    public function logout(Request $request)
{
    $request->session()->invalidate();

    $request->session()->regenerateToken();

    Auth::logout();

    return redirect('/login');
}
    public function showLoginForm()
    {
        return view('login'); // Nama view login
    }
    public function home()
    {
        return view('home'); // View halaman home
    }

    public function login(Request $request){
        if (empty($request->username) || empty($request->password)) {
            return back()->withErrors(['loginError' => 'Username dan password tidak boleh kosong'])->withInput();
        }
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cek pengguna di database
        $user = User::where('username', $request->username)->first(); // Menggunakan model User

        if ($user && $user->password === $request->password) {
            // Login berhasil
            Auth::login($user);
            return redirect('/home');
        } else {
            // Login gagal
            return back()->withErrors(['loginError' => 'Username atau password salah']);
        }
    }

    //UNTUK MENAMPILKAN DATA KATEGORI DI BERANDA
    public function index()
    {
        $kategoris = Kategori::all();
        return view('beranda', compact('kategoris'));
    }

    //UNTUK SEARCHING
    public function index56(Request $request)
    {
        // Ambil value search dari request
        $selectedsearchkey = $request->input('searchkey');

        // Query sekolah-sekolah yang memiliki keyword tertentu menggunakan LIKE
        $sekolah = Sekolah::where(function ($query) use ($selectedsearchkey) {
            $query->where('nama_sekolah', 'LIKE', '%' . $selectedsearchkey . '%');
        })->get(['nama_sekolah', 'latitude', 'longitude', 'jalan_sekolah']);

        // Konversi koleksi sekolah ke JSON
        return response()->json($sekolah);
    }

    //UNTUK DAFTAR SEKOLAH DI ADMIN
    public function index6(Request $request){
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all()->unique('kecamatan');
        $inputSekolah = $request->input('inputSekolah');
        $perPage = 15;
        $sekolahs = Sekolah::with([
            'lokasi', 
            'jenjang',
            'gambar' => function ($query) {
                $query->where('nama_file', 'like', '%-1.jpg')
                      ->orWhere('nama_file', 'like', '%-1.jpeg')
                      ->orWhere('nama_file', 'like', '%-1.png'); // Only include images ending with '-1.jpg'
            }
        ])
        ->when($inputSekolah, function ($query) use ($inputSekolah) {
            return $query->where('sekolah.nama_sekolah', 'like', '%' . $inputSekolah . '%');
        })
            ->orderBy('id_jenjang', 'asc') // Urutkan berdasarkan id_jenjang yang diambil dari model Sekolah
            ->paginate($perPage)->appends([
                'inputSekolah' => $inputSekolah,
            ]);
        return view('home', compact('sekolahs','lokasis', 'kategoris', 'inputSekolah'));
    }

    //UNTUK DETAIL SEKOLAH
    function detailinstansi($npsn){
        $kategori = Kategori::all();
        $lokasi = Lokasi::all();

        $sekolah = Sekolah::leftJoin('lokasi', 'sekolah.kodepos', '=', 'lokasi.kodepos')
            ->where('sekolah.npsn', $npsn)
            ->first();

        // Ambil data dari tabel pivot kategorisekolah berdasarkan NPSN
        $kategorisekolah = Kategorisekolah::join('kategori', 'kategorisekolah.id_kategori', '=', 'kategori.id_kategori')
            ->select('kategori.nama_kategori', 'kategorisekolah.total_siswa')
            ->where('kategorisekolah.npsn', $npsn)
            ->get();

        // Ambil data fasilitas berdasarkan NPSN
        $fasilitas = Fasilitassekolah::join('fasilitas', 'fasilitassekolah.id_fasilitas', '=', 'fasilitas.id_fasilitas')
            ->select('fasilitas.nama_fasilitas')
            ->where('fasilitassekolah.npsn', $npsn)
            ->get();

        // Ambil semua gambar terkait dengan sekolah berdasarkan NPSN
        $gambar = Gambar::where('npsn', $npsn)->get();

        return view('detailinstansi', compact('sekolah', 'kategori', 'lokasi', 'kategorisekolah', 'fasilitas', 'gambar'));
    }

    //UNTUK MUNCUL DATA DI DROPDOWN
    public function tambah()
    {
        $kategoris = Kategori::all();
        $fasilitas = Fasilitas::all();
        $lokasis = Lokasi::all();
        $jenjangs = Jenjang::all();
        return view('tambahdata', compact('kategoris', 'fasilitas','lokasis', 'jenjangs'));
    }

    //UNTUK NAMBAH DATA
    public function store(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'npsn' => 'required|string|min:1|unique:sekolah,npsn',
            'nama_sekolah' => 'required|string',
            'jalan_sekolah' => 'required|string',
            'kodepos' => 'required|string',
            'latitude' => 'required|numeric|min:-180|max:180',
            'longitude' => 'required|numeric|min:-180|max:180',
            'jenjang' => 'required|string', // Pastikan ini sesuai dengan nama field di form
            'web_sekolah' => 'required|nullable|string',
            'total_siswa' => 'required|nullable|integer|min:1',
            'kategoris' => 'required|array|min:1', // Pastikan ada setidaknya 1 kategori
            'kategoris.*.id_kategori' => 'required|exists:kategori,id_kategori',
            'kategoris.*.total_siswa' => 'required|nullable|integer|min:1',
            'fasilitas.*.id_fasilitas' => 'required|exists:fasilitas,id_fasilitas',
            'files' => 'required|array', // Files array harus ada
            'files.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'npsn.required' => 'NPSN tidak boleh kosong.', // Pesan error jika NPSN kosong
    'npsn.unique' => 'NPSN sudah terdaftar.',
            'files.required' => 'Foto sekolah wajib diunggah.',
            'files.*.mimes' => 'Foto harus berformat jpg, jpeg, atau png.',
            'files.*.max' => 'Ukuran foto maksimal adalah 5MB.',
            'kategoris.*.id_kategori.required' => 'Kategori tidak boleh kosong.',
    'kategoris.*.total_siswa.min' => 'Total siswa harus minimal 1.',
    'fasilitas.*.id_fasilitas.required' => 'Fasilitas tidak boleh kosong.',
        ]);
        Log::info('Data yang tervalidasi:', $validated);

        // Store Sekolah data
        $sekolah = Sekolah::create([
            'npsn' => $validated['npsn'],
            'kodepos' => $validated['kodepos'],
            'nama_sekolah' => $validated['nama_sekolah'],
            'jalan_sekolah' => $validated['jalan_sekolah'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'id_jenjang'=> $validated['jenjang'], // Pastikan field ini ada
            'link_sekolah' => $validated['web_sekolah'],
            'total_siswa' => $validated['total_siswa'],
        ]);
        Log::info('Data sekolah berhasil disimpan dengan NPSN: ' . $sekolah->npsn);

        // Store Kategori data
        foreach ($validated['kategoris'] as $kategori) {
            KategoriSekolah::create([
                'npsn' => $sekolah->npsn,
                'id_kategori' => $kategori['id_kategori'],
                'total_siswa' => $kategori['total_siswa'] ?? null,
            ]);
            Log::info('Data kategori berhasil disimpan untuk NPSN: ' . $sekolah->npsn . ' dengan ID Kategori: ' . $kategori['id_kategori']);
        }
        
        
        // Simpan data fasilitas ke tabel FasilitasSekolah
        foreach ($validated['fasilitas'] as $fasilitas) {
            FasilitasSekolah::create([
                'npsn' => $sekolah->npsn,
                'id_fasilitas' => $fasilitas['id_fasilitas'],
            ]);
            Log::info('Data fasilitas berhasil disimpan untuk NPSN: ' . $sekolah->npsn . ' dengan ID Fasilitas: ' . $fasilitas['id_fasilitas']);
        }

        // Handle file uploads
        if ($request->hasFile('files')) {
            $i = 1; // Inisialisasi angka untuk setiap file
            $namaSekolah = str_replace(' ', '-', strtoupper($validated['nama_sekolah'])); // Mengganti spasi dengan '-'
            
            foreach ($request->file('files') as $file) {
                $extension = $file->getClientOriginalExtension(); // Dapatkan ekstensi file
                $filename = $namaSekolah . '-' . $i . '.' . $extension; // Buat nama file dengan angka berturut-turut
                $destinationPath = public_path('img/Sekolah/');
                
                // Memindahkan file ke folder tujuan
                $file->move($destinationPath, $filename);
                
                // Simpan nama file ke database
                Gambar::create([
                    'npsn' => $sekolah->npsn,
                    'nama_file' => $filename,
                ]);
                
                Log::info('Gambar berhasil diupload dan disimpan dengan nama file: ' . $filename);
                
                $i++; // Increment angka untuk file berikutnya
            }
        }
        
        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    //UNTUK FILTER DATA DAFTAR DAN PETA
    public function index10(Request $request){

        // Ambil filter dari request
        $selectedJenjang = $request->input('jenjang');
        $selectedCategoryId = $request->input('kategori');
        $selectedKecamatan = $request->input('kecamatan');
        $inputSekolah = $request->input('inputSekolah');

        // Ambil koordinat pengguna dari session
        $userLatitude = $request->session()->get('user_latitude');
        $userLongitude = $request->session()->get('user_longitude');

        // Pengaturan pagination
        $perPage = 10;

        // Kueri untuk semua sekolah (untuk peta)
        $allSekolahsQuery = Sekolah::selectRaw('sekolah.*, 
            (6371000 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance_meters', 
            [$userLatitude, $userLongitude, $userLatitude])
            ->leftJoin('lokasi', 'sekolah.kodepos', '=', 'lokasi.kodepos')
            ->leftJoin('jenjang', 'sekolah.id_jenjang', '=', 'jenjang.id_jenjang')
            ->when($selectedJenjang, function ($query) use ($selectedJenjang) {
                return $query->where('sekolah.id_jenjang', $selectedJenjang);
            })
            ->when($selectedCategoryId, function ($query) use ($selectedCategoryId) {
                $query->whereIn('sekolah.npsn', function($subQuery) use ($selectedCategoryId) {
                    $subQuery->select('kategorisekolah.npsn')
                        ->from('kategorisekolah')
                        ->where('kategorisekolah.id_kategori', $selectedCategoryId);
                });
            })
            ->when($selectedKecamatan, function ($query) use ($selectedKecamatan) {
                return $query->where('lokasi.kodepos', $selectedKecamatan);
            })
            ->when($inputSekolah, function ($query) use ($inputSekolah) {
                return $query->where('sekolah.nama_sekolah', 'like', '%' . $inputSekolah . '%');
            })
            ->with(['gambar' => function ($query) {
                $query->where('nama_file', 'like', '%-1.jpg')
                      ->orWhere('nama_file', 'like', '%-1.jpeg')
                      ->orWhere('nama_file', 'like', '%-1.png');
            }, 'lokasi'])
            ->orderBy('distance_meters');

        // Kueri untuk daftar dengan pagination
        $paginatedSekolahs = (clone $allSekolahsQuery)->paginate($perPage)->appends([
            'jenjang' => $selectedJenjang,
            'kategori' => $selectedCategoryId,
            'kecamatan' => $selectedKecamatan,
            'inputSekolah' => $inputSekolah,
        ]);

        // Ambil semua data untuk peta tanpa pagination
        $allSekolahs = $allSekolahsQuery->get();

        // Format jarak untuk semua sekolah di peta
        foreach ($allSekolahs as $sekolah) {
            $sekolah->distance_formatted = ($sekolah->distance_meters >= 1000)
                ? round($sekolah->distance_meters / 1000, 2) . ' km'
                : round($sekolah->distance_meters) . ' m';
        }

        // Format jarak untuk sekolah yang dipaginate di daftar
        foreach ($paginatedSekolahs as $sekolah) {
            $sekolah->distance_formatted = ($sekolah->distance_meters >= 1000)
                ? round($sekolah->distance_meters / 1000, 2) . ' km'
                : round($sekolah->distance_meters) . ' m';
        }

        // Ambil data kategori dan lokasi
        $kategoris = Kategori::all();
        $lokasis = Lokasi::all()->unique('kecamatan');
        $jenjangs = Jenjang::all();

        // Kirim data ke view
        return view('coba', compact('jenjangs', 'kategoris', 'lokasis', 'paginatedSekolahs', 'allSekolahs', 'perPage', 'selectedJenjang', 'selectedCategoryId', 'selectedKecamatan', 'inputSekolah'));
    }

    //UNTUK UPDATE LOKASI USER
    public function updateLocation(Request $request){
        $request->session()->put('user_latitude', $request->input('latitude'));
        $request->session()->put('user_longitude', $request->input('longitude'));
    
        return response()->json(['success' => true]);
    }

    //UNTUK HAPUS DATA DI ADMIN
    public function delete(Request $request){

        $npsn = $request->input('npsn');
        \Log::info('Request received for deletion: ' . $npsn);
   
        try {
            // Menghapus gambar terkait
            Gambar::where('npsn', $npsn)->delete();

            // Menghapus fasilitas terkait
            FasilitasSekolah::where('npsn', $npsn)->delete();

            // Menghapus kategori terkait
            KategoriSekolah::where('npsn', $npsn)->delete();

            // Menghapus sekolah
            Sekolah::where('npsn', $npsn)->delete();

            return response()->json(['success' => true, 'message' => 'Sekolah berhasil dihapus.']);
        } catch (\Exception $e) {
            \Log::error('Error deleting data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //UNTUK AMBIL DATA EDIT
    public function edit($npsn){
        
        // Ambil data sekolah berdasarkan ID
        $sekolah = Sekolah::find($npsn);

        // Ambil data lokasi, jenjang, kategori, dan fasilitas
        $lokasis = Lokasi::all();
        $jenjangs = Jenjang::all();
        $kategoris = Kategori::all();
        $fasilitas = Fasilitas::all();

        // Ambil data kategori dan fasilitas terkait
        $kategoriSekolah = KategoriSekolah::where('npsn', $npsn)->get();
        $fasilitasSekolah = FasilitasSekolah::where('npsn', $npsn)->get();

        // Kirim data ke view
        return view('editdata', compact('sekolah', 'lokasis', 'jenjangs', 'kategoris', 'fasilitas', 'kategoriSekolah', 'fasilitasSekolah'));
    }

    //UNTUK UPDATE DATA
    public function update(Request $request, $npsn){

        $request->validate([
            'npsn' => 'required|exists:sekolah,NPSN',
            'nama_sekolah' => 'required|string|max:255',
            'jalan_sekolah' => 'required|string|max:255',
            'kodepos' => 'required|string|max:10',
            'latitude' => 'required|numeric|min:-180|max:180',
            'longitude' => 'required|numeric|min:-180|max:180',
            'jenjang' => 'required|integer|exists:jenjang,id_jenjang',
            'web_sekolah' => 'required|nullable|string',
            'total_siswa' => 'required|nullable|integer|min:1',
            'kategoris.*.id_kategori' => 'required|integer|exists:kategori,id_kategori',
            'kategoris.*.total_siswa' => 'required|integer|min:1',
            'fasilitas.*.id_fasilitas' => 'required|integer|exists:fasilitas,id_fasilitas',
            'files.*' => 'nullable|file|mimes:jpg,png,jpeg,gif,webp|max:5120', // Atur sesuai kebutuhan
        ]);

        // Temukan sekolah berdasarkan NPSN
        $sekolah = Sekolah::where('NPSN', $npsn)->firstOrFail();
        Sekolah::where('NPSN', $npsn)->update([
            'nama_sekolah' => $request->input('nama_sekolah'),
            'jalan_sekolah' => $request->input('jalan_sekolah'),
            'kodepos' => $request->input('kodepos'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'id_jenjang' => $request->input('jenjang'),
            'link_sekolah' => $request->input('web_sekolah'),
            'total_siswa' => $request->input('total_siswa'),
        ]);

         // Perbarui data kategori
        foreach ($request->input('kategoris', []) as $kategori) {
            $npsn = $sekolah->NPSN;
    $id_kategori = $kategori['id_kategori'];
    $total_siswa = $kategori['total_siswa'];

    // Delete existing category if it exists
    KategoriSekolah::where('npsn', $npsn)
                   ->where('id_kategori', $id_kategori)
                   ->delete();

    // Create a new category with the updated total_siswa
    KategoriSekolah::create([
        'npsn' => $npsn,
        'id_kategori' => $id_kategori,
        'total_siswa' => $total_siswa
    ]);
        }

        // Hapus kategori yang tidak ada lagi
        KategoriSekolah::where('npsn', $sekolah->NPSN)
            ->whereNotIn('id_kategori', array_column($request->input('kategoris', []), 'id_kategori'))
            ->delete();

        foreach ($request->input('fasilitas', []) as $fasilitas) {
            $existingFasilitas = FasilitasSekolah::where('npsn', $sekolah->NPSN)
                                    ->where('id_fasilitas', $fasilitas['id_fasilitas'])
                                    ->first();
            if (!$existingFasilitas) {
                // Tambahkan fasilitas baru jika diperlukan
                FasilitasSekolah::create([
                    'npsn' => $sekolah->NPSN,
                    'id_fasilitas' => $fasilitas['id_fasilitas']
                ]);
            }
        }

        // Hapus fasilitas yang tidak ada lagi
        FasilitasSekolah::where('npsn', $sekolah->NPSN)
                            ->whereNotIn('id_fasilitas', array_column($request->input('fasilitas', []), 'id_fasilitas'))
                            ->delete();

        // Proses unggah file
        if ($request->hasFile('files')) {
            // Hapus gambar lama dari database dan server
            $i = 1; // Inisialisasi angka untuk setiap file
            $namaSekolah = str_replace(' ', '-', strtoupper($request['nama_sekolah']));
            $existingGambar = Gambar::where('npsn', $npsn)->get();
            foreach ($existingGambar as $gambar) {
                $filePath = public_path('img/Sekolah/' . $gambar->nama_file);
                if (file_exists($filePath)) {
                    unlink($filePath); // Hapus file dari server
                }
            }
            Gambar::where('npsn', $npsn)->delete(); // Hapus data dari database
                
            // Tambahkan gambar baru
            foreach ($request->file('files') as $file) {
                $extension = $file->getClientOriginalExtension(); // Dapatkan ekstensi file
                $filename = $namaSekolah . '-' . $i . '.' . $extension; // Buat nama file dengan angka berturut-turut
                $destinationPath = public_path('img/Sekolah/');
            
                // Memindahkan file ke folder tujuan
                $file->move($destinationPath, $filename);
    
                // Simpan data gambar ke database
                Gambar::create([
                    'npsn' => $sekolah->NPSN,
                    'nama_file' => $filename,
                ]);
                $i++;
            }
        }
        return redirect()->back()->with('success', 'Data sekolah berhasil diperbarui');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function indexcoba()
    {
        $sekolah = Sekolah::all();
        return response()->json($sekolah);
    }


    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     */
    
}
