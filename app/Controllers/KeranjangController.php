<?php

namespace App\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiModel;
use App\Models\JualModel;

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
            'subtotal' => $subtotal
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
        } else {
            $pembeli = [
                'nama' => '',
                'hp' => '',
                'alamat' => '',
                'kecamatan' => '',
                'kota' => ''
            ];
        }

        return view('keranjang/checkout_view', ['pembeli' => $pembeli]);
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
            'kota' => $this->request->getVar('kota')
        ];

        // Validasi data identitas pembeli
        $validationRules = [
            'nama' => 'required',
            'hp' => 'required',
            'alamat' => 'required',
            'kecamatan' => 'required',
            'kota' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            $validation = \Config\Services::validation();
            session()->setFlashdata('error_message', 'Data identitas pembeli tidak lengkap');
            return redirect()->to('/keranjang/checkout')->withInput()->with('validation', $validation);
        }

        // Jika identitas pembeli valid, maka masukkan data pembeli ke session
        session()->set('pembeli', $pembeli);

        // Tambahkan total harga 
        $total = 0;
        foreach ($keranjang as $k) {
            $total += $k['jumlah'] * $k['harga_barang'];
        }

        // Jika data keranjang dan identitas pembeli valid, lanjutkan ke halaman preview dengan data pembeli
        return view('keranjang/preview_view', ['keranjang' => $keranjang, 'pembeli' => $pembeli, 'total' => $total]);
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

        // Tambahkan total harga
        $total = 0;
        foreach ($keranjang as $k) {
            $total += $k['jumlah'] * $k['harga_barang'];
        }

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
            'total_transaksi' => $total
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
            'total' => $total
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
