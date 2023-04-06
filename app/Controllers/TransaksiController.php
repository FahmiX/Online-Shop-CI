<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransaksiModel as Transaksi;
use App\Models\BarangModel as Barang;
use App\Models\JualModel as Jual;

class TransaksiController extends BaseController
{
    public function display()
    {
        $transaksi = new Transaksi();

        $data = [
            'transaksi' => $transaksi->getAllTransaksi()
        ];

        return view('transaksi/display_view', $data);
    }

    public function detail($id_transaksi)
    {
        $jual = new Jual(); 

        $data = [
            'jual' => $jual->getJualByTransaksi($id_transaksi),
        ];

        return view('transaksi/detail_view', $data);
    }

    public function hapus($id_transaksi)
    {
        $jual = new Jual();
        $transaksi = new Transaksi();

        $jual->deleteJualByTransaksi($id_transaksi);
        $transaksi->deleteTransaksi($id_transaksi);

        return redirect()->to('/transaksi');
    }
}
