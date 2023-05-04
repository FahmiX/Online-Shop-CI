<?php

namespace App\Models;

use CodeIgniter\Model;

class OngkirModel extends Model
{
    protected $table            = 'ongkir';
    protected $primaryKey       = 'id_ongkir';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_ongkir', 'kodepos_awal', 'kodepos_tujuan', 'harga_ongkir'];

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

    // FUNCTION

    // Get All Ongkir
    public function getAllOngkir()
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT * FROM ongkir");

        // Close Connection
        $db->close();

        // Return result
        return $query->getResultArray();
    }

    // Get Kode Pos Tujuan
    public function getKodePosTujuan()
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT DISTINCT kodepos_tujuan FROM ongkir");

        // Close Connection
        $db->close();

        // Return result
        return $query->getResultArray();
    }

    // Get Harga Ongkir by Kode Pos Tujuan
    public function getHargaByTujuan($kodepos_tujuan)
    {
        // Connect to database
        $db = db_connect();

        // Query
        $query = $db->query("SELECT DISTINCT harga_ongkir FROM ongkir WHERE kodepos_tujuan = '$kodepos_tujuan'");

        // Get one row result
        $row = $query->getRow();

        // Return result as integer
        return intval($row->harga_ongkir);
    }
}
