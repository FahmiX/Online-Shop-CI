<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id_barang';
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

    public function getAllBarang()
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM barang");

        // Close Connection
        $db->close();

        // Return result
        return $query->getResultArray();
    }

    public function getBarang($id_barang)
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM barang WHERE id_barang = $id_barang");

        // Close Connection
        $db->close();

        // Return result
        return $query->getRowArray();
    }

    public function createBarang($data)
    {
        // Connect to database
        $db = db_connect();

        // set ID
        $id_barang = $db->query("SELECT MAX(id_barang) AS id_barang FROM barang")->getRowArray()['id_barang'] + 1;

        // Query
        $query = $db->query("INSERT INTO barang VALUES ($id_barang, '{$data['nama_barang']}', '{$data['harga_barang']}', '{$data['stok_barang']}', '{$data['gambar_barang']}')");

        // Close Connection
        $db->close();

        // Return result
        return $query;
    }
}
