<?php

namespace App\Libraries;

use App\Models\ProgramModel;
use CodeIgniter\Database\BaseConnection;

class DonationStats
{
    private BaseConnection $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function getPaidProgramMap(): array
    {
        $rows = (new ProgramModel())
            ->select('id, COALESCE(terkumpul, 0) AS total_amount')
            ->findAll();

        $map = [];

        foreach ($rows as $row) {
            $map[(int) $row['id']] = [
                'total_amount' => (float) ($row['total_amount'] ?? 0),
                'donor_count'  => 0,
            ];
        }

        return $map;
    }

    public function getOverview(): array
    {
        $targetRow = $this->db->table('programs')
            ->select('COALESCE(SUM(target_dana), 0) AS total_target, COALESCE(SUM(terkumpul), 0) AS total_raised, SUM(CASE WHEN terkumpul > 0 THEN 1 ELSE 0 END) AS filled_program_count')
            ->where('status', 'aktif')
            ->get()
            ->getRowArray();

        $activeProgramCount = (new ProgramModel())
            ->where('status', 'aktif')
            ->countAllResults();

        $totalRaised = (float) ($targetRow['total_raised'] ?? 0);
        $totalTarget = (float) ($targetRow['total_target'] ?? 0);
        $donationCount = (int) ($targetRow['filled_program_count'] ?? 0);
        $progressPercent = $totalTarget > 0 ? min(100, (int) round(($totalRaised / $totalTarget) * 100)) : 0;

        return [
            'totalRaised'      => $totalRaised,
            'totalTarget'      => $totalTarget,
            'donationCount'    => $donationCount,
            'activePrograms'   => $activeProgramCount,
            'progressPercent'  => $progressPercent,
            'latestPaidAt'     => null,
        ];
    }

    public function syncProgramTotal(?int $programId): void
    {
        // Donasi QRIS dicatat manual oleh admin melalui kolom `terkumpul`.
        // Method ini dipertahankan agar callback lama tidak menimpa angka manual.
    }
}
