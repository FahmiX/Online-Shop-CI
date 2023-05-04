<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Ongkir extends Migration
{
    public function up()
    {
        // id_ongkir, kodepos_awal, kodepos_tujuan, harga_ongkir
        $this->forge->addField([
            'id_ongkir' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kodepos_awal' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'kodepos_tujuan' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'harga_ongkir' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id_ongkir', true);
        $this->forge->createTable('ongkir');
    }

    public function down()
    {
        $this->forge->dropTable('ongkir');
    }
}
