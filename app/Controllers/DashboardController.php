<?php

namespace App\Controllers;

use App\Models\DonationModel;
use App\Models\GalleryModel;
use App\Models\ProgramModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function user(): string
    {
        $user = auth_user();
        $donations = (new DonationModel())
            ->where('user_id', $user['id'])
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('dashboard/user', $this->basePageData([
            'title'       => 'Dashboard User',
            'description' => 'Pantau riwayat donasi Anda.',
            'authUser'    => $user,
            'donations'   => $donations,
        ]));
    }

    public function admin(): string
    {
        $donationModel = new DonationModel();

        return view('dashboard/admin', $this->basePageData([
            'title'         => 'Dashboard Admin',
            'description'   => 'Kelola donasi, user, program, dan galeri.',
            'authUser'      => auth_user(),
            'donationCount' => $donationModel->countAllResults(),
            'totalRaised'   => $donationModel->selectSum('amount')->first()['amount'] ?? 0,
            'userCount'     => (new UserModel())->countAllResults(),
            'programCount'  => (new ProgramModel())->countAllResults(),
            'galleryCount'  => (new GalleryModel())->countAllResults(),
            'donations'     => $donationModel->orderBy('id', 'DESC')->findAll(20),
        ]));
    }

    public function updateDonationStatus(int $id)
    {
        $status = $this->request->getPost('payment_status');
        $allowed = ['pending', 'paid', 'failed'];

        if (! in_array($status, $allowed, true)) {
            return redirect()->back()->with('error', 'Status pembayaran tidak valid.');
        }

        (new DonationModel())->update($id, [
            'payment_status' => $status,
            'provider_status'=> $status,
            'paid_at'        => $status === 'paid' ? date('Y-m-d H:i:s') : null,
        ]);

        return redirect()->to(site_url('admin'))->with('success', 'Status donasi berhasil diperbarui.');
    }
}
