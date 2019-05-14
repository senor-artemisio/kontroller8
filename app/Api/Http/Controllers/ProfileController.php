<?php

namespace App\Api\Http\Controllers;

use App\Api\DTO\ProfileDTO;
use App\Api\Http\Resources\ProfileResource;
use App\Api\Models\Profile;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Nexmo\Client\Request\ProfileRequest;

/**
 * REST API for profile.
 */
class ProfileController extends Controller
{
    /**
     * @param Profile $profile
     * @return ProfileResource
     * @throws AuthorizationException
     */
    public function show(Profile $profile)
    {
        $this->authorize('show',$profile);

        return ProfileResource::make($profile);
    }

    public function create(ProfileRequest $request)
    {
        $this->authorize('create', Profile::class);

        $profileDTO = new ProfileDTO($request->all());


    }

    public function update(ProfileRequest $request, Profile $profile){
        $this->authorize('update', $profile);

    }
}
