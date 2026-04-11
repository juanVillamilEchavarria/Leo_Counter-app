<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Application\Profile\Services\ProfileService;
use Inertia\Inertia;
class ProfileController extends Controller
{
    public function __construct(
        private ProfileService $profileService
    )
    {
    }
    public function index(){

        return Inertia::render('Profile/Profile', [
            'title'=>'Perfil'
        ]);
    }
    public function update(UpdateProfileRequest $request){
        $this->profileService->update($request->validated());
        Inertia::flash('success', 'Perfil actualizado correctamente');
        return redirect()->route('profile.index');
    }
}
