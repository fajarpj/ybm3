<?php

namespace App\Models;

use CodeIgniter\Model;

class DonationModel extends Model
{
    protected $table         = 'donations';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'user_id',
        'donor_name',
        'donor_phone',
        'program_id',
        'amount',
        'payment_method',
        'provider',
        'order_id',
        'snap_token',
        'payment_url',
        'provider_status',
        'paid_at',
        'payment_gateway',
        'payment_channel',
        'payment_status',
        'transaction_code',
        'message',
    ];
}
