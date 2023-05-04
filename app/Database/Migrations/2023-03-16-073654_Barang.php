<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_barang'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_barang'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'stok_barang'       => [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
            'harga_barang'       => [
                'type'           => 'INT',
                'constraint'     => '11',
            ],
            'gambar_barang' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'berat_barang' => [
                'type' => 'INT',
                'constraint' => '11',
            ],
        ]);

        $this->forge->addKey('id_barang', true);
        $this->forge->createTable('barang');
    }

    public function down()
    {
        $this->forge->dropTable('barang');
    }
}
