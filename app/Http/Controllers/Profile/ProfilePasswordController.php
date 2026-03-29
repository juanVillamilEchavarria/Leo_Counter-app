<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
class ProfilePasswordController extends Controller
{
    public function index(){
        return Inertia::render('Profile/Password',[
            'title' => 'Contraseña'
        ]);
    }
}
