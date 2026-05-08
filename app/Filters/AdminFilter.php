<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = session()->get('auth_user');

        if (! is_array($user)) {
            return redirect()->to(site_url('login'))->with('error', 'Silakan login sebagai admin.');
        }

        if (($user['role'] ?? null) !== 'admin') {
            return redirect()->to(site_url('dashboard'))->with('error', 'Akses hanya untuk admin.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
