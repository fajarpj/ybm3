<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EnhanceDonationAndSeedContent extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('payment_gateway', 'donations')) {
            $this->forge->addColumn('donations', [
                'payment_gateway' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Manual Transfer',
                    'after'      => 'payment_method',
                ],
            ]);
        }

        if (! $this->db->fieldExists('payment_channel', 'donations')) {
            $this->forge->addColumn('donations', [
                'payment_channel' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'default'    => 'Bank Transfer',
                    'after'      => 'payment_gateway',
                ],
            ]);
        }

        if (! $this->db->fieldExists('transaction_code', 'donations')) {
            $this->forge->addColumn('donations', [
                'transaction_code' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => 'payment_status',
                ],
            ]);
        }

        $programCount = $this->db->table('programs')->countAllResults();
        if ($programCount === 0) {
            $this->db->table('programs')->insertBatch([
                [
                    'judul'       => 'Santunan Kepedulian Umat',
                    'slug'        => 'santunan-kepedulian-umat',
                    'deskripsi'   => 'Program bantuan dan santunan untuk masyarakat yang membutuhkan melalui penyaluran yang amanah dan terarah.',
                    'target_dana' => 50000000,
                    'terkumpul'   => 0,
                    'gambar'      => 'assets/images/gallery/slide-1.svg',
                    'status'      => 'aktif',
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ],
                [
                    'judul'       => 'Pembinaan dan Pendidikan Umat',
                    'slug'        => 'pembinaan-dan-pendidikan-umat',
                    'deskripsi'   => 'Program yang berfokus pada pembinaan, pendidikan, dan penguatan nilai-nilai kebaikan untuk masyarakat.',
                    'target_dana' => 35000000,
                    'terkumpul'   => 0,
                    'gambar'      => 'assets/images/gallery/slide-2.svg',
                    'status'      => 'aktif',
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ],
                [
                    'judul'       => 'Pemberdayaan Masyarakat Mandiri',
                    'slug'        => 'pemberdayaan-masyarakat-mandiri',
                    'deskripsi'   => 'Program untuk mendorong daya tumbuh masyarakat melalui semangat kemandirian, kebersamaan, dan kerja nyata.',
                    'target_dana' => 40000000,
                    'terkumpul'   => 0,
                    'gambar'      => 'assets/images/gallery/slide-3.svg',
                    'status'      => 'aktif',
                    'created_at'  => date('Y-m-d H:i:s'),
                    'updated_at'  => date('Y-m-d H:i:s'),
                ],
            ]);
        }

        $galleryCount = $this->db->table('galleries')->countAllResults();
        if ($galleryCount === 0) {
            $this->db->table('galleries')->insertBatch([
                [
                    'title'        => 'Bakti Sosial dan Santunan',
                    'slug'         => 'bakti-sosial-dan-santunan',
                    'image'        => 'assets/images/gallery/slide-1.svg',
                    'caption'      => 'Dokumentasi awal untuk menampilkan kegiatan santunan dan kepedulian sosial yayasan.',
                    'category'     => 'Sosial',
                    'is_published' => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
                [
                    'title'        => 'Pembinaan dan Pendidikan',
                    'slug'         => 'pembinaan-dan-pendidikan',
                    'image'        => 'assets/images/gallery/slide-2.svg',
                    'caption'      => 'Dokumentasi pembinaan yang dapat diganti dengan foto kegiatan asli dari yayasan.',
                    'category'     => 'Pembinaan',
                    'is_published' => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
                [
                    'title'        => 'Pemberdayaan Masyarakat',
                    'slug'         => 'pemberdayaan-masyarakat',
                    'image'        => 'assets/images/gallery/slide-3.svg',
                    'caption'      => 'Dokumentasi yang merepresentasikan semangat kemandirian masyarakat dan program manfaat jangka panjang.',
                    'category'     => 'Kemandirian',
                    'is_published' => 1,
                    'created_at'   => date('Y-m-d H:i:s'),
                    'updated_at'   => date('Y-m-d H:i:s'),
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('transaction_code', 'donations')) {
            $this->forge->dropColumn('donations', 'transaction_code');
        }

        if ($this->db->fieldExists('payment_channel', 'donations')) {
            $this->forge->dropColumn('donations', 'payment_channel');
        }

        if ($this->db->fieldExists('payment_gateway', 'donations')) {
            $this->forge->dropColumn('donations', 'payment_gateway');
        }
    }
}
