<?php

namespace App\Models;

use CodeIgniter\Model;

class JualModel extends Model
{
    protected $table            = 'jual';
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

    public function getAllJual()
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM jual");

        // Close Connection
        $db->close();

        // Return result
        return $query->getResultArray();
    }

    public function getJual($id_barang, $id_transaksi)
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM jual WHERE id_barang = $id_barang AND id_transaksi = $id_transaksi");

        // Close Connection
        $db->close();

        // Return result
        return $query->getResultArray();
    }

    public function getJualByBarang($id_barang)
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM jual WHERE id_barang = $id_barang");

        // Close Connection
        $db->close();

        // Return result
        return $query->getResultArray();
    }

    public function getJualByTransaksi($id_transaksi)
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM jual WHERE id_transaksi = $id_transaksi");

        // Close Connection
        $db->close();

        // Return result
        return $query->getResultArray();
    }

    public function insertJual($data)
    {
        // Connect to database
        $db = db_connect();

        // Query
        // id_barang, id_transaksi, jumlah_jual, harga_jual
        $query = $db->query("INSERT INTO jual VALUES ($data[id_barang], $data[id_transaksi], $data[jumlah_jual], $data[harga_jual])");

        // Close Connection
        $db->close();

        // Return result
        return $query;
    }

    public function deleteJualByTransaksi($id_transaksi)
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("DELETE FROM jual WHERE id_transaksi = $id_transaksi");

        // Close Connection
        $db->close();

        // Return result
        return $query;
    }
}
