<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table            = 'programs';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'judul',
        'slug',
        'deskripsi',
        'target_dana',
        'terkumpul',
        'gambar',
        'status',
    ];
}
