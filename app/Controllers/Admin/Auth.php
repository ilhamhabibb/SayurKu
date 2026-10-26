<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    private const MAX_ATTEMPTS = 5;
    private const MAX_IP_ATTEMPTS = 20;
    private const ATTEMPT_WINDOW = 60;

    public function login()
    {
        if (session()->get('admin_user') !== null) {
            return redirect()->to('/admin');
        }

        if (! $this->request->is('post')) {
            return view('admin/auth/login');
        }

        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');
        $throttler = service('throttler');
        $userKey = 'admin_login_' . md5(strtolower($username) . '|' . $this->request->getIPAddress());
        $ipKey = 'admin_login_ip_' . md5($this->request->getIPAddress());
        $userAllowed = $throttler->check($userKey, self::MAX_ATTEMPTS, self::ATTEMPT_WINDOW);
        $userWait = $throttler->getTokenTime();
        $ipAllowed = $throttler->check($ipKey, self::MAX_IP_ATTEMPTS, self::ATTEMPT_WINDOW);
        $ipWait = $throttler->getTokenTime();

        if (! $userAllowed || ! $ipAllowed) {
            $wait = max(1, $userAllowed ? $ipWait : $userWait);

            return redirect()->back()
                ->with('error', 'Terlalu banyak percobaan login. Coba lagi dalam ' . $wait . ' detik.')
                ->withInput();
        }

        $user = (new UserModel())->where('username', $username)->first();

        if ($user === null || ! password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Username atau password salah.')->withInput();
        }

        $throttler->remove($userKey);
        $throttler->remove($ipKey);
        session()->regenerate(true);
        session()->set('admin_user', [
            'id' => (int) $user['id'],
            'username' => $user['username'],
        ]);

        return redirect()->to('/admin')->with('success', 'Selamat datang, ' . $user['username'] . '.');
    }

    public function logout()
    {
        session()->remove('admin_user');
        session()->destroy();

        return redirect()->to('/admin/login');
    }
}
