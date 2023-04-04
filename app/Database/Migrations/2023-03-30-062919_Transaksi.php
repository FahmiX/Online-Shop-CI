<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Transaksi extends Migration
{
    public function up()
    {
        // id transaksi, tanggal, nama, hp, alamat, kecamatan, kota, total
        $this->forge->addField([
            'id_transaksi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tanggal_transaksi' => [
                'type' => 'DATE',
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'hp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kota' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'total_transaksi' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id_transaksi', true);
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}
