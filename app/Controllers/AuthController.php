<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

// ? Service
use App\Models\AuthService;
use App\Models\UserService;

class AuthController extends BaseController {
    protected $service;

    public function __construct() {
        $this->service = new AuthService();
    }

    public function authenticate() {
        $token = $this->request->getGet('token');
        $role = $this->request->getGet('role');

        if (!empty($token) && !empty($role)) {
            if (!$token) {
                return self::redirectToLogin();
            }

            $response = $this->service->checkToken($token);
            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                return redirect()->route('logout');
            }

            // save token to session
            session()->set('token', $token);

            // get user profile
            $userService = new UserService();
            $user = json_decode($userService->getMyProfile()->getBody())->data;
            $userProfile = $user->profile;
            $userAccount = $user['account'];

            // verify role
            if ($userAccount[$role]) {
                session()->set('role', [$role => true]);
            }

            session()->set('account', $userAccount);
            session()->set('profile', $userProfile);
            session()->set('user_image', $user->account->image);
            session()->set('user_email', $user->account->email);

            return redirect('home');
        } else {
            if (session()->has('token') and session()->has('role')) {
                return redirect('home');
            }

            return self::redirectToVerifySite();
        }
    }

    public function logout() {
        if (session()->has('token')) {
            session()->destroy();
        }

        return self::redirectToLogout();
    }

    private function redirectToVerifySite() {
        return redirect()->to(
            getenv('LOGIN_BASE_URL') . 'verify?site=' . base_url()
        );
    }

    private function redirectToLogin() {
        return redirect()->to(
            getenv('LOGIN_BASE_URL') . 'login?site=' . base_url()
        );
    }

    private function redirectToLogout() {
        return redirect()->to(
            getenv('LOGIN_BASE_URL') . 'logout?site=' .  base_url()
        );
    }
}
