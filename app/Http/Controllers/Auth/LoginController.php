<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct(
        private LoginService $loginService
    )
    {
    }

    public function index (){

        return Inertia::render('Auth/Login');
    }
    public function login(LoginRequest $request){
        if(!$this->loginService->login($request->validated(), $request->remember())){
            Inertia::flash('error', 'Credenciales incorrectas');
            return back();
        }
        return redirect()->route('home',['user'=>Auth::user()->name]);
    }
    public function logout(){
        $this->loginService->logout();
        return redirect()->route('login');
    }
}
