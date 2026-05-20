<?php

namespace App\Controllers;

use App\Libraries\DonationStats;
use App\Libraries\MidtransGateway;
use App\Models\DonationModel;

class PaymentController extends BaseController
{
    public function finish(): string
    {
        return view('pages/payment_finish', $this->basePageData([
            'title'       => 'Pembayaran Diproses',
            'description' => 'Pembayaran sedang diproses. Status akhir dapat dilihat di dashboard atau riwayat donasi.',
        ]));
    }

    public function midtransNotification()
    {
        $gateway = new MidtransGateway();
        $notification = $gateway->notification();

        $orderId = $notification->order_id ?? null;
        if (! $orderId) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Order ID missing']);
        }

        $donation = (new DonationModel())->where('order_id', $orderId)->first();
        if (! $donation) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'Donation not found']);
        }

        $transactionStatus = $notification->transaction_status ?? 'pending';
        $fraudStatus = $notification->fraud_status ?? null;

        $paymentStatus = 'pending';
        $paidAt = null;

        if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus === 'accept')) {
            $paymentStatus = 'paid';
            $paidAt = date('Y-m-d H:i:s');
        } elseif (in_array($transactionStatus, ['expire', 'cancel', 'deny'], true)) {
            $paymentStatus = 'failed';
        }

        (new DonationModel())->update($donation['id'], [
            'payment_status' => $paymentStatus,
            'provider_status'=> $transactionStatus,
            'paid_at'        => $paidAt,
        ]);

        (new DonationStats())->syncProgramTotal((int) ($donation['program_id'] ?? 0));

        return $this->response->setJSON(['message' => 'OK']);
    }
}
