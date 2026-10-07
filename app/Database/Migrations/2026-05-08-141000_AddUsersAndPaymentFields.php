<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUsersAndPaymentFields extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('users')) {
            $this->forge->addField([
                'id' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                ],
                'email' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                ],
                'phone' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'null'       => true,
                ],
                'password_hash' => [
                    'type' => 'TEXT',
                ],
                'role' => [
                    'type'       => 'ENUM',
                    'constraint' => ['admin', 'user'],
                    'default'    => 'user',
                ],
                'is_active' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addUniqueKey('email');
            $this->forge->createTable('users', true);
        }

        $fields = [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
            ],
            'provider' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'manual',
                'after'      => 'transaction_code',
            ],
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'provider',
            ],
            'snap_token' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'order_id',
            ],
            'payment_url' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'snap_token',
            ],
            'provider_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'payment_url',
            ],
            'paid_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'provider_status',
            ],
        ];

        foreach ($fields as $name => $definition) {
            if (! $this->db->fieldExists($name, 'donations')) {
                $this->forge->addColumn('donations', [$name => $definition]);
            }
        }

        $adminEmail = env('SEED_ADMIN_EMAIL', 'admin@yb3m.local');
        $adminPassword = env('SEED_ADMIN_PASSWORD');

        $adminExists = $this->db->table('users')->where('email', $adminEmail)->countAllResults();
        if ($adminPassword && $adminExists === 0) {
            $this->db->table('users')->insert([
                'name'          => 'Administrator YB3M',
                'email'         => $adminEmail,
                'phone'         => null,
                'password_hash' => password_hash($adminPassword, PASSWORD_DEFAULT),
                'role'          => 'admin',
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
        foreach (['paid_at', 'provider_status', 'payment_url', 'snap_token', 'order_id', 'provider', 'user_id'] as $field) {
            if ($this->db->fieldExists($field, 'donations')) {
                $this->forge->dropColumn('donations', $field);
            }
        }

        if ($this->db->tableExists('users')) {
            $this->forge->dropTable('users', true);
        }
    }
}
