<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 150,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'email' => [
                'type' => 'MEDIUMTEXT',
                'null' => true,
            ],
            'password' => [
                'type' => 'MEDIUMTEXT',
                'null' => true,
            ],
            'nama' => [
                'type' => 'MEDIUMTEXT',
                'null' => true,
            ],
            'img' => [
                'type'       => 'LONGTEXT',
                'default'    => 'asset/img/profile.png',
            ],
            'role' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 3,
            ],
            'token_reset' => [
                'type'       => 'VARCHAR',
                'constraint' => 65,
                'null'       => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('users');

        // Insert default data
        $db = \Config\Database::connect();
        $db->table('users')->insert([
            'username'    => 'admin',
            'email'       => 'admin@admin.com',
            'password'    => 'admin123',
            'nama'        => 'Super Admin',
            'img'         => 'asset/img/profile.png',
            'role'        => 1,
            'token_reset' => null,
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
