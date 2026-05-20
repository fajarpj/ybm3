<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
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
        $user = (new UserModel())->where('email', $this->request->getPost('email'))->first();

        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password tidak sesuai.');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->back()->with('error', 'Akun tidak aktif.');
        }

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
            'email'         => $this->request->getPost('email'),
            'phone'         => $this->request->getPost('phone'),
            'password_hash' => password_hash((string) $this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => 'user',
            'is_active'     => 1,
        ], true);

        $user = $userModel->find($userId);

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
        session()->remove('auth_user');

        return redirect()->to(site_url('/'))->with('success', 'Anda telah logout.');
    }
}
