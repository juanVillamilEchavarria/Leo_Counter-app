<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Http\Requests\Profile\UpdatePasswordProfileRequest;
use App\Domains\Profile\Services\Application\ProfileService;

class ProfilePasswordController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    )
    {
    }
    public function index(){
        return Inertia::render('Profile/Password',[
            'title' => 'Contraseña'
        ]);
    }
    public function update(UpdatePasswordProfileRequest $request){
        $this->profileService->update($request->validated());
        Inertia::flash('success', 'Contraseña actualizada correctamente');
        return redirect()->route('profile.password.index');
    }
}
