<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAllTransaksi()
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM transaksi");

        // Close Connection
        $db->close();

        // Return result
        return $query->getResultArray();
    }

    public function getTransaksi($id_transaksi)
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM transaksi WHERE id_transaksi = $id_transaksi");

        // Close Connection
        $db->close();

        // Return result
        return $query->getRowArray();
    }

    public function insertTransaksi($data)
    {
        // Connect to database
        $db = db_connect();

        // Query
        // id_transaksi, tanggal_transaksi, nama, hp, alamat, kecamatan, kota, total_transaksi
        $db->query("INSERT INTO transaksi (tanggal_transaksi, nama, hp, alamat, kecamatan, kota, total_transaksi) VALUES ('$data[tanggal_transaksi]', '$data[nama]', '$data[hp]', '$data[alamat]', '$data[kecamatan]', '$data[kota]', '$data[total_transaksi]')");

        // Get inserted ID
        $insertID = $db->insertID();

        // Close Connection
        $db->close();

        // Return result
        return $insertID;
    }

    public function deleteTransaksi($id_transaksi)
    {
        // Connect to database
        $db = db_connect();

        // Query
        $db->query("DELETE FROM transaksi WHERE id_transaksi = $id_transaksi");

        // Close Connection
        $db->close();
    }
}
