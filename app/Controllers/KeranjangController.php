<?php

namespace App\Controllers;

use App\Models\BarangModel;

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

        if (empty($barang)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang dengan ID ' . $id_barang . ' tidak ditemukan.');
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

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan ke keranjang.');
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
        $keranjang = session()->get('keranjang');

        if (empty($keranjang)) {
            return redirect()->back()->with('warning', 'Keranjang belanja masih kosong.');
        }

        return view('keranjang/checkout_view', ['keranjang' => $keranjang]);
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

        // Jika data keranjang dan identitas pembeli valid, lanjutkan ke halaman preview dengan data pembeli

        return view('keranjang/preview_view', ['keranjang' => $keranjang, 'pembeli' => $pembeli]);
    }

    // public function preview()
    // {
    //     $keranjang = session()->get('keranjang');

    //     dd($keranjang);

    //     if (empty($keranjang)) {
    //         return redirect()->back()->with('warning', 'Keranjang belanja masih kosong.');
    //     }

    //     return view('keranjang/preview_view', ['keranjang' => $keranjang]);
    // }
}
