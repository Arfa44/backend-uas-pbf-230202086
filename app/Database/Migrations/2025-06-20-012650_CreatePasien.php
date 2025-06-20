<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePasien extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('pasien');

    }

    public function down()
    {
        $this->forge->dropTable('pasien', true);
    }
}
