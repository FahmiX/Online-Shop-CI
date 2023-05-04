<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel as Barang;

class BarangController extends BaseController
{
    public function display()
    {
        $barang = new Barang();

        $data = [
            'barang' => $barang->getAllBarang()
        ];

        return view('barang/display_view', $data);
    }

    public function create()
    {
        return view('barang/create_view');
    }

    public function store()
    {
        $barang = new Barang();

        // Mengambil data dari form
        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'harga_barang' => $this->request->getPost('harga_barang'),
            'stok_barang' => $this->request->getPost('stok_barang'),
            'berat_barang' => $this->request->getPost('berat_barang'),
        ];

        // Mengambil file yang di-upload
        $gambar_barang = $this->request->getFile('gambar_barang');

        // Mengecek apakah file valid
        if ($gambar_barang->isValid()) {
            $filename = $gambar_barang->getRandomName();
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d-H-i-s');

            // Generate nama file, dengan menambahkan tanggal dan jam
            $newName = $date . '_' . $filename;

            // Pindahkan file ke direktori yang diinginkan
            $gambar_barang->move('barang', $newName);

            // Menambahkan nama file ke dalam data
            $data['gambar_barang'] = $newName;
        }

        // Menyimpan data ke database
        $barang->createBarang($data);

        return redirect()->to('/barang');
    }
}
