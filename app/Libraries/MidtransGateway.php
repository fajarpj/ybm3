<?php

namespace App\Libraries;

use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class MidtransGateway
{
    public function isConfigured(): bool
    {
        return (bool) env('midtrans.serverKey') && (bool) env('midtrans.clientKey');
    }

    public function clientKey(): string
    {
        return (string) env('midtrans.clientKey');
    }

    public function isProduction(): bool
    {
        return filter_var(env('midtrans.isProduction', false), FILTER_VALIDATE_BOOL);
    }

    public function configure(): void
    {
        Config::$serverKey = (string) env('midtrans.serverKey');
        Config::$clientKey = (string) env('midtrans.clientKey');
        Config::$isProduction = $this->isProduction();
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function createTransaction(array $payload): array
    {
        $this->configure();

        return Snap::createTransaction($payload);
    }

    public function notification(): Notification
    {
        $this->configure();

        return new Notification();
    }
}
