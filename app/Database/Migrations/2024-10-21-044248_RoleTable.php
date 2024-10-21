<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleTable extends Migration
{
    public function up()
    {
        // Create the 'role' table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
        ]);

        // Add primary key
        $this->forge->addKey('id', true);

        // Create the table
        $this->forge->createTable('role');

        // Insert data into 'role' table
        $data = [
            ['label' => 'Manager', 'name' => 'manager'],
            ['label' => 'Karyawan', 'name' => 'karyawan'],
            ['label' => 'Viewers', 'name' => 'viewers'],
            ['label' => 'Users', 'name' => 'users'],
        ];

        // Use the database connection to insert
        $db = \Config\Database::connect();
        $db->table('role')->insertBatch($data);
    }

    public function down()
    {
        // Drop the 'role' table
        $this->forge->dropTable('role');
    }
}
