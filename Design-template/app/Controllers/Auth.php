<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login(): string
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/etudiants');
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Identifiants obligatoires.');
        }

        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user === null && $username === 'admin' && $password === 'admin') {
            $hasUsers = (new UserModel())->countAllResults() > 0;
            if (! $hasUsers) {
                $userModel->insert([
                    'username' => 'admin',
                    'password' => password_hash('admin', PASSWORD_DEFAULT),
                ]);
                $user = $userModel->where('username', 'admin')->first();
            }
        }

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Identifiants incorrects.');
        }

        session()->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'isLoggedIn' => true,
        ]);

        return redirect()->to('/etudiants');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}
