<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    private function throttleKey(string $prefix, ?string $identifier = null): string
    {
        $ip = (string) service('request')->getIPAddress();
        $id = trim(strtolower((string) $identifier));
        $safePrefix = preg_replace('/[^a-z0-9_-]/i', '-', $prefix) ?: 'auth';
        $safeIp = preg_replace('/[^a-z0-9_-]/i', '-', $ip) ?: 'ip';

        return $safePrefix . '-' . $safeIp . ($id !== '' ? '-' . sha1($id) : '');
    }

    private function publicRegistrationEnabled(): bool
    {
        return filter_var(env('auth.allowPublicRegistration', false), FILTER_VALIDATE_BOOL);
    }

    public function login()
    {
        return view('auth/login', $this->basePageData([
            'title'       => 'Login',
            'description' => 'Masuk ke dashboard sesuai akses akun Anda.',
            'allowPublicRegistration' => $this->publicRegistrationEnabled(),
        ]));
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email|max_length[150]',
            'password' => 'required|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Mohon isi email dan password dengan benar.');
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $throttler = service('throttler');

        if (! $throttler->check($this->throttleKey('login', $email), 5, MINUTE)) {
            return redirect()->back()->withInput()->with('error', 'Terlalu banyak percobaan login. Silakan tunggu sekitar 1 menit lalu coba lagi.');
        }

        $user = (new UserModel())->where('email', $email)->first();

        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password tidak sesuai.');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->back()->with('error', 'Akun tidak aktif.');
        }

        session()->regenerate(true);
        session()->set('auth_user', [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ]);

        return redirect()->to($user['role'] === 'admin' ? site_url('admin') : site_url('dashboard'));
    }

    public function register()
    {
        if (! $this->publicRegistrationEnabled()) {
            return redirect()->to(site_url('login'))->with('error', 'Pendaftaran akun publik saat ini dinonaktifkan. Silakan hubungi pengurus yayasan.');
        }

        return view('auth/register', $this->basePageData([
            'title'       => 'Daftar',
            'description' => 'Buat akun untuk memantau riwayat donasi.',
        ]));
    }

    public function attemptRegister()
    {
        if (! $this->publicRegistrationEnabled()) {
            return redirect()->to(site_url('login'))->with('error', 'Pendaftaran akun publik saat ini dinonaktifkan.');
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $throttler = service('throttler');

        if (! $throttler->check($this->throttleKey('register', $email), 3, MINUTE * 5)) {
            return redirect()->back()->withInput()->with('error', 'Terlalu banyak percobaan pendaftaran. Silakan tunggu beberapa menit lalu coba lagi.');
        }

        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Mohon periksa kembali data pendaftaran.');
        }

        $userModel = new UserModel();
        $userId = $userModel->insert([
            'name'          => $this->request->getPost('name'),
            'email'         => $email,
            'phone'         => $this->request->getPost('phone'),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'user',
            'is_active'     => 1,
        ], true);

        $user = $userModel->find($userId);

        session()->regenerate(true);
        session()->set('auth_user', [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ]);

        return redirect()->to(site_url('dashboard'))->with('success', 'Akun berhasil dibuat.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('/'))->with('success', 'Anda telah logout.');
    }
}
