<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Repository\Profile\ProfileRepository;

class ProfileController extends Controller
{

    protected ProfileRepository $profile;

    public function __construct(ProfileRepository $profile)
    {
        $this->profile = $profile;
    }



}
