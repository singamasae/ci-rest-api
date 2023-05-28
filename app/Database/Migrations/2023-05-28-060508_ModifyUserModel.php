<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUserModel extends Migration
{
    public function up()
    {
        $fields = [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ]
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        //
    }
}
