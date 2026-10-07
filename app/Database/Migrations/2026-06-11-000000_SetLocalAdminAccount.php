<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SetLocalAdminAccount extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('users')) {
            return;
        }

        $adminEmail = 'adminybm3@gmail.com';
        $now = date('Y-m-d H:i:s');
        $payload = [
            'name'          => 'Administrator YBM3',
            'email'         => $adminEmail,
            'phone'         => null,
            'password_hash' => password_hash('admybm32023', PASSWORD_DEFAULT),
            'role'          => 'admin',
            'is_active'     => 1,
            'updated_at'    => $now,
        ];

        $existingAdmin = $this->db->table('users')->where('email', $adminEmail)->get()->getRowArray();

        if ($existingAdmin) {
            $this->db->table('users')->where('id', $existingAdmin['id'])->update($payload);
        } else {
            $payload['created_at'] = $now;
            $this->db->table('users')->insert($payload);
        }

        $this->db->table('users')
            ->whereIn('email', [
                'admin@yb3m.local',
                'fajar.web2.ti24a4@gmail.com',
                'admybm3peduli@gmail.com',
            ])
            ->update([
                'is_active'  => 0,
                'updated_at' => $now,
            ]);
    }

    public function down()
    {
        if (! $this->db->tableExists('users')) {
            return;
        }

        $this->db->table('users')->where('email', 'adminybm3@gmail.com')->delete();
    }
}
