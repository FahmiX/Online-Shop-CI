<?php

namespace App\Controllers;

use App\Models\BarangModel;

class KeranjangController extends BaseController
{
    public function display()
    {
        $data = [
            'title' => 'Keranjang Belanja',
            'keranjang' => session()->get('keranjang')
        ];

        return view('keranjang/display_view', $data);
    }

    public function tambah($id_barang)
    {
        $barangModel = new BarangModel();
        $barang = $barangModel->find($id_barang);

        if (empty($barang)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang dengan ID ' . $id_barang . ' tidak ditemukan.');
        }

        // Ambil jumlah barang dari form input
        $jumlah = $this->request->getVar('jumlah');
        if (empty($jumlah)) {
            $jumlah = 1;
        }

        // Validasi jumlah
        if ($jumlah < 1) {
            return redirect()->back()->with('error', 'Jumlah barang tidak valid.');
        } elseif ($jumlah > $barang['stok_barang']) {
            return redirect()->back()->with('error', 'Jumlah barang melebihi stok yang tersedia.');
        }

        // Ambil data keranjang dari session
        $keranjang = session()->get('keranjang');

        // Buat keranjang jika belum ada
        if (empty($keranjang)) {
            $keranjang = [
                $id_barang => [
                    'id_barang' => $barang['id_barang'],
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
}
