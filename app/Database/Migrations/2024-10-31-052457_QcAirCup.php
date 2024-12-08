<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QcAirCup extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'date' => [
                'type'       => 'JSON',
                'null'       => true,
                
            ],
            'update_date' => [
                'type'       => 'LONGTEXT',
                'null'       => true,
            ],
            'data' => [
                'type'       => 'JSON',
                'null'       => true,
                
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'shift' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('qc_air_cup');
    }

    public function down()
    {
        $this->forge->dropTable('qc_air_cup');
    }
}
