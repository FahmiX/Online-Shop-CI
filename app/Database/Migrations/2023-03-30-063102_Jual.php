<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jual extends Migration
{
    public function up()
    {
        // id_barang, id_transaksi, jumlah_jual, harga_jual
        $this->forge->addField([
            'id_barang' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'id_transaksi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jumlah_jual' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'harga_jual' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id_barang', true);
        $this->forge->addKey('id_transaksi', true);
        $this->forge->createTable('jual');
    }

    public function down()
    {
        $this->forge->dropTable('jual');
    }
}
