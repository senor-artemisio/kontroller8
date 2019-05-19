<?php

namespace App\Api\Http\Controllers;

use App\Api\DTO\DTOException;
use App\Api\DTO\ProfileDTO;
use App\Api\Http\Requests\ProfileRequest;
use App\Api\Http\Resources\ProfileResource;
use App\Api\Models\Profile;
use App\Api\Repositories\ProfileRepository;
use App\Api\Services\ProfileService;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * REST API for profile.
 */
class ProfileController extends Controller
{
    /** @var ProfileService */
    private $profileService;

    /** @var ProfileRepository */
    private $profileRepository;

    /**
     * @param ProfileService $profileService
     * @param ProfileRepository $profileRepository
     */
    public function __construct(ProfileService $profileService, ProfileRepository $profileRepository)
    {
        $this->profileService = $profileService;
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param Profile $profile
     * @return ProfileResource
     * @throws AuthorizationException
     */
    public function show(Profile $profile)
    {
        $this->authorize('show', $profile);

        return ProfileResource::make($profile);
    }

    /**
     * @param ProfileRequest $request
     * @param Profile $profile
     * @throws AuthorizationException
     * @throws DTOException
     */
    public function update(ProfileRequest $request, Profile $profile)
    {
        $this->authorize('update', $profile);

        $profileDTO = new ProfileDTO($request->all());

        $this->profileService->update($profile, $profileDTO);
    }
}
