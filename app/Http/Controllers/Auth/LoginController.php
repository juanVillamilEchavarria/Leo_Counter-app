<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Shared\Application\Contracts\Services\AuthServiceContract;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct(
        private AuthServiceContract $authService
    )
    {
    }

    public function index (){

        return Inertia::render('Auth/Login');
    }
    public function login(LoginRequest $request){
        if(!$this->authService->login($request->validated(), $request->remember())){
            Inertia::flash('error', 'Credenciales incorrectas');
            return back();
        }
        return redirect()->route('home',['user'=>Auth::user()->name]);
    }
    public function logout(){
        $this->authService->logout();
        return redirect()->route('login');
    }
}
