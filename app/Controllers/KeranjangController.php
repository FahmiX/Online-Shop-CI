<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiModel;
use App\Models\JualModel;
use App\Models\OngkirModel;

class KeranjangController extends BaseController
{
    public function display()
    {
        if (empty(session()->get('keranjang'))) {
            // buat session keranjang jika belum ada
            session()->set('keranjang', []);
            $keranjang = session()->get('keranjang');
        } else {
            // ambil data keranjang dari session
            $keranjang = session()->get('keranjang');
        }
        return view('keranjang/display_view', ['keranjang' => $keranjang]);
    }

    public function tambah($id_barang)
    {
        $barangModel = new BarangModel();
        $barang = $barangModel->find($id_barang);
        $jumlah = 1;

        // cek id barang
        if (empty($barang)) {
            return redirect()->to('/barang');
        }

        // cek stok barang
        if ($barang['stok_barang'] < $jumlah) {
            return redirect()->to('/barang');
        }

        // Ambil data keranjang dari session
        $keranjang = session()->get('keranjang');

        // Buat keranjang jika belum ada
        if (empty($keranjang)) {
            $keranjang = [
                $id_barang => [
                    'id_barang' => $barang['id_barang'],
                    'gambar_barang' => $barang['gambar_barang'],
                    'nama_barang' => $barang['nama_barang'],
                    'harga_barang' => $barang['harga_barang'],
                    'berat_barang' => $barang['berat_barang'],
                    'jumlah' => $jumlah
                ]
            ];
        } else {
            // Tambah jumlah barang jika sudah ada di keranjang
            if (isset($keranjang[$id_barang])) {
                $keranjang[$id_barang]['jumlah'] += $jumlah;
            } else {
                // Tambah barang baru ke keranjang
                $keranjang[$id_barang] = [
                    'id_barang' => $barang['id_barang'],
                    'gambar_barang' => $barang['gambar_barang'],
                    'nama_barang' => $barang['nama_barang'],
                    'harga_barang' => $barang['harga_barang'],
                    'berat_barang' => $barang['berat_barang'],
                    'jumlah' => $jumlah
                ];
            }
        }

        // Simpan data keranjang ke session
        session()->set('keranjang', $keranjang);

        //kembali ke halaman home 
        return redirect()->to('/')->with('success', 'Barang berhasil ditambahkan ke keranjang.');
    }

    public function hapus($id_barang)
    {
        $keranjang = session()->get('keranjang');

        if (isset($keranjang[$id_barang])) {
            unset($keranjang[$id_barang]);
            session()->set('keranjang', $keranjang);
        }

        return redirect()->back()->with('success', 'Barang berhasil dihapus dari keranjang.');
    }

    public function ubah()
    {
        $id = $this->request->getVar('id');
        $action = $this->request->getVar('action');

        // Ambil data barang dari session
        $keranjang = session()->get('keranjang');
        $barang = $keranjang[$id];

        if ($action == 'tambah') {
            // Tambah jumlah barang pada keranjang
            $barang['jumlah'] += 1;
        } elseif ($action == 'kurang') {
            // Kurangi jumlah barang pada keranjang
            $barang['jumlah'] -= 1;
        }

        if ($barang['jumlah'] <= 0) {
            // Hapus barang dari keranjang jika jumlah <= 0
            unset($keranjang[$id]);
            $message = 'Barang berhasil dihapus dari keranjang.';
        } else {
            // Update data barang pada session
            $keranjang[$id] = $barang;
            $message = 'Jumlah barang berhasil diupdate.';
        }

        // Hitung total harga keranjang
        $total = 0;
        foreach ($keranjang as $k) {
            $total += $k['jumlah'] * $k['harga_barang'];
        }

        // Hitung total berat keranjang pada id tersebut
        $barang['berat'] = $barang['berat_barang'] * $barang['jumlah'];

        // Update session keranjang
        session()->set('keranjang', $keranjang);

        // Ubah Format Rupiah
        $subtotal = number_format($barang['jumlah'] * $barang['harga_barang'], 0, ',', '.');
        $total = number_format($total, 0, ',', '.');

        // Kirim response dalam format JSON
        $response = [
            'status' => 'success',
            'message' => $message,
            'total' => $total,
            'jumlah' => $barang['jumlah'],
            'subtotal' => $subtotal,
            'berat' => $barang['berat']
        ];

        return $this->response->setJSON($response);
    }

    public function checkout()
    {
        // Ambil data keranjang dari session
        $keranjang = session()->get('keranjang');

        if (empty($keranjang)) {
            return redirect()->back()->with('error_message', 'Keranjang belanja masih kosong.');
        }

        // Ambil data identitas pembeli dari session jika sudah ada
        if (session()->has('pembeli')) {
            $pembeli = session()->get('pembeli');

            $ongkir = new OngkirModel();

            // Ambil seluruh data kode pos tujuan dari database
            $kodepos_tujuan = $ongkir->getKodeposTujuan();

            $data = [
                'pembeli' => $pembeli,
                'kodepos_tujuan' => $kodepos_tujuan
            ];

            // Validasi data pembeli
            if (!$this->validate([
                'pembeli.nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama pembeli harus diisi.'
                    ]
                ],
                'pembeli.hp' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Nomor HP pembeli harus diisi.',
                        'numeric' => 'Nomor HP pembeli harus berupa angka.'
                    ]
                ],
                'pembeli.alamat' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Alamat pembeli harus diisi.'
                    ]
                ],
                'pembeli.kecamatan' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kecamatan pembeli harus diisi.'
                    ]
                ],
                'pembeli.kota' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kota pembeli harus diisi.'
                    ]
                ],
                'pembeli.kode_pos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kode pos pembeli harus diisi.'
                    ]
                ]
            ])) {
                return view('keranjang/checkout_view', $data);
            }
        } else {
            $pembeli = [
                'nama' => '',
                'hp' => '',
                'alamat' => '',
                'kecamatan' => '',
                'kota' => '',
                'kode_pos' => '',
            ];

            $ongkir = new OngkirModel();

            // Ambil seluruh data kode pos tujuan dari database
            $kodepos_tujuan = $ongkir->getKodeposTujuan();

            $data = [
                'pembeli' => $pembeli,
                'kodepos_tujuan' => $kodepos_tujuan
            ];
        }

        return view('keranjang/checkout_view', $data);
    }

    public function preview()
    {
        // Ambil data keranjang dari session
        $keranjang = session()->get('keranjang');

        // Validasi jika data keranjang kosong
        if (empty($keranjang)) {
            session()->setFlashdata('error_message', 'Keranjang kosong, silahkan tambahkan barang terlebih dahulu');
            return redirect()->to('/keranjang');
        }

        // Ambil data identitas pembeli dari form
        $pembeli = [
            'nama' => $this->request->getVar('nama'),
            'hp' => $this->request->getVar('hp'),
            'alamat' => $this->request->getVar('alamat'),
            'kecamatan' => $this->request->getVar('kecamatan'),
            'kota' => $this->request->getVar('kota'),
            'kode_pos' => $this->request->getVar('kode_pos'),
        ];

        // Validasi data identitas pembeli
        $validationRules = [
            'nama' => 'required',
            'hp' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'required',
            'kota' => 'required',
            'kode_pos' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('error_message', 'Data identitas pembeli tidak lengkap');
            return redirect()->to('/keranjang/checkout')->withInput()->with('validation', $validation);
        }

        // Jika identitas pembeli valid, maka masukkan data pembeli ke session
        session()->set('pembeli', $pembeli);

        // Ambil data harga ongkos kirim berdasarkan kode pos tujuan
        $ongkir = new OngkirModel();
        $ongkir = $ongkir->getHargaByTujuan($pembeli['kode_pos']);

        // Hitung total berat barang
        $jumlah_berat = 0;
        foreach ($keranjang as $k) {
            $jumlah_berat += $k['jumlah'] * $k['berat_barang'];
        }

        // Hitung total harga barang
        $total_harga_barang = 0;
        foreach ($keranjang as $k) {
            $total_harga_barang += $k['jumlah'] * $k['harga_barang'];
        }

        // Hitung total harga ongkos kirim setiap kilogram
        $jumlah_berat_kg = $jumlah_berat / 1000;
        if ($jumlah_berat_kg < 1) {
            $jumlah_berat_kg = 1;
        } else {
            // Memisahkan bilangan di kedua sisi desimal
            $jumlah_berat_array = explode('.', $jumlah_berat_kg);

            // mengambil angka dibelakang koma
            $angka = isset($jumlah_berat_array[1]) ? $jumlah_berat_array[1] : 0;

            // Cek kondisi
            if ($angka <= 3) {
                // Dibulatkan kebawah
                $jumlah_berat_kg = floor($jumlah_berat_kg);
            } else {
                // Dibulatkan keatas
                $jumlah_berat_kg = ceil($jumlah_berat_kg);
            }
        }
        $total_ongkir = $jumlah_berat_kg * $ongkir;

        // Hitung total harga keseluruhan
        $total_seluruh = $total_harga_barang + $total_ongkir;

        $data = [
            'keranjang' => $keranjang,
            'pembeli' => $pembeli,
            'ongkir' => $ongkir,
            'jumlah_berat' => $jumlah_berat,
            'total_harga_barang' => $total_harga_barang,
            'total_ongkir' => $total_ongkir,
            'total_seluruh' => $total_seluruh
        ];

        // Jika data keranjang dan identitas pembeli valid, lanjutkan ke halaman preview dengan data pembeli
        return view('keranjang/preview_view', $data);
    }

    public function bayar()
    {
        // Ambil data keranjang dari session
        $keranjang = session()->get('keranjang');

        // Validasi jika data keranjang kosong
        if (empty($keranjang)) {
            session()->setFlashdata('error_message', 'Keranjang kosong, silahkan tambahkan barang terlebih dahulu');
            return redirect()->to('/keranjang');
        }

        // Ambil data identitas pembeli dari session
        $pembeli = session()->get('pembeli');

        // Validasi jika data identitas pembeli kosong
        if (empty($pembeli)) {
            session()->setFlashdata('error_message', 'Data identitas pembeli tidak lengkap');
            return redirect()->to('/keranjang/checkout');
        }

        // Ambil data harga ongkos kirim berdasarkan kode pos tujuan
        $ongkir = new OngkirModel();
        $ongkir = $ongkir->getHargaByTujuan($pembeli['kode_pos']);

        // Hitung total berat barang
        $jumlah_berat = 0;
        foreach ($keranjang as $k) {
            $jumlah_berat += $k['jumlah'] * $k['berat_barang'];
        }

        // Hitung total harga barang
        $total_harga_barang = 0;
        foreach ($keranjang as $k) {
            $total_harga_barang += $k['jumlah'] * $k['harga_barang'];
        }

        // Hitung total harga ongkos kirim setiap kilogram
        $jumlah_berat_kg = $jumlah_berat / 1000;
        if ($jumlah_berat_kg < 1) {
            $jumlah_berat_kg = 1;
        } else {
            // Memisahkan bilangan di kedua sisi desimal
            $jumlah_berat_array = explode('.', $jumlah_berat_kg);

            // mengambil angka dibelakang koma
            $angka = isset($jumlah_berat_array[1]) ? $jumlah_berat_array[1] : 0;

            // Cek kondisi
            if ($angka <= 3) {
                // Dibulatkan kebawah
                $jumlah_berat_kg = floor($jumlah_berat_kg);
            } else {
                // Dibulatkan keatas
                $jumlah_berat_kg = ceil($jumlah_berat_kg);
            }
        }
        $total_ongkir = $jumlah_berat_kg * $ongkir;

        // Hitung total harga keseluruhan
        $total_seluruh = $total_harga_barang + $total_ongkir;

        // Simpan data transaksi ke database
        $transaksi = new TransaksiModel();

        // data_transaksi terdiri dari id_transaksi, tanggal_transaksi, nama, hp, alamat, kecamatan, kota, total_transaksi
        $data_transaksi = [
            'tanggal_transaksi' => date('Y-m-d H:i:s'),
            'nama' => $pembeli['nama'],
            'hp' => $pembeli['hp'],
            'alamat' => $pembeli['alamat'],
            'kecamatan' => $pembeli['kecamatan'],
            'kota' => $pembeli['kota'],
            'total_transaksi' => $total_seluruh
        ];

        // Simpan data transaksi dan dapatkan id_transaksi
        $id_transaksi = $transaksi->insertTransaksi($data_transaksi);

        // Simpan data jual berupa id_transaksi, id_barang, jumlah_jual, harga_jual
        $jual = new JualModel();

        foreach ($keranjang as $k) {
            $data_jual = [
                'id_transaksi' => $id_transaksi,
                'id_barang' => $k['id_barang'],
                'jumlah_jual' => $k['jumlah'],
                'harga_jual' => $k['harga_barang']
            ];

            $jual->insertJual($data_jual);
        }

        // Hapus data keranjang dan identitas pembeli dari session
        session()->remove('keranjang');
        session()->remove('pembeli');

        // Kurangi stok barang
        $barang = new BarangModel();

        foreach ($keranjang as $k) {
            $barang->kurangiStok($k['id_barang'], $k['jumlah']);
        }

        $data = [
            'keranjang' => $keranjang,
            'pembeli' => $pembeli,
            'ongkir' => $ongkir,
            'jumlah_berat' => $jumlah_berat,
            'total_harga_barang' => $total_harga_barang,
            'total_ongkir' => $total_ongkir,
            'total_seluruh' => $total_seluruh
        ];

        session()->set('data', $data);

        // Tampilkan halaman pembayaran
        return redirect()->to('/keranjang/checkout/invoice');
    }

    public function invoice()
    {
        $data = session()->get('data');

        return view('keranjang/invoice_view', $data);
    }
}
