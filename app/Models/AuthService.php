<?php

namespace App\Models;

use App\Models\MyWebService;

class AuthService extends MyWebService {
    public function __construct() {
        parent::__construct('authentications');
    }

    public function validateUserSiteAccess($url) {
        $query = "/check/site?url=$url";

        return $this->get(null, $query);
    }

    public function checkToken($token) {
        $payload = [
            'token' => $token,
        ];

        return $this->get($payload, '/check');
    }
}
