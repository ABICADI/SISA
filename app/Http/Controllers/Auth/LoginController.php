<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    protected function hasTooManyLoginAttempts ($request) {
        $maxLoginAttempts = 2;
        $lockoutTime = 1; // 1 minuto
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), $maxLoginAttempts, $lockoutTime
        );
    }

    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }
}
