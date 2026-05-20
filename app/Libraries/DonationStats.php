<?php

namespace App\Libraries;

use App\Models\DonationModel;
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
        $rows = (new DonationModel())
            ->select('program_id, COALESCE(SUM(amount), 0) AS total_amount, COUNT(id) AS donor_count')
            ->where('payment_status', 'paid')
            ->where('program_id IS NOT NULL', null, false)
            ->groupBy('program_id')
            ->findAll();

        $map = [];

        foreach ($rows as $row) {
            $map[(int) $row['program_id']] = [
                'total_amount' => (float) ($row['total_amount'] ?? 0),
                'donor_count'  => (int) ($row['donor_count'] ?? 0),
            ];
        }

        return $map;
    }

    public function getOverview(): array
    {
        $paidDonationModel = new DonationModel();
        $paidDonationRows = $paidDonationModel
            ->select('COALESCE(SUM(amount), 0) AS total_amount, COUNT(id) AS donation_count')
            ->where('payment_status', 'paid')
            ->first();

        $targetRow = $this->db->table('programs')
            ->select('COALESCE(SUM(target_dana), 0) AS total_target')
            ->where('status', 'aktif')
            ->get()
            ->getRowArray();

        $activeProgramCount = (new ProgramModel())
            ->where('status', 'aktif')
            ->countAllResults();

        $latestPaidAt = $this->db->table('donations')
            ->select('MAX(paid_at) AS latest_paid_at')
            ->where('payment_status', 'paid')
            ->get()
            ->getRowArray();

        $totalRaised = (float) ($paidDonationRows['total_amount'] ?? 0);
        $totalTarget = (float) ($targetRow['total_target'] ?? 0);
        $donationCount = (int) ($paidDonationRows['donation_count'] ?? 0);
        $progressPercent = $totalTarget > 0 ? min(100, (int) round(($totalRaised / $totalTarget) * 100)) : 0;

        return [
            'totalRaised'      => $totalRaised,
            'totalTarget'      => $totalTarget,
            'donationCount'    => $donationCount,
            'activePrograms'   => $activeProgramCount,
            'progressPercent'  => $progressPercent,
            'latestPaidAt'     => $latestPaidAt['latest_paid_at'] ?? null,
        ];
    }

    public function syncProgramTotal(?int $programId): void
    {
        if (! $programId) {
            return;
        }

        $totals = $this->getPaidProgramMap();
        $totalAmount = $totals[$programId]['total_amount'] ?? 0;

        (new ProgramModel())->update($programId, [
            'terkumpul' => $totalAmount,
        ]);
    }
}
