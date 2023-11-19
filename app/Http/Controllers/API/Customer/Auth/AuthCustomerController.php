<?php

namespace App\Http\Controllers\API\Customer\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Customer\Auth\LoginRequest;
use App\Http\Requests\API\Customer\Auth\RegisterRequest;
use App\Http\Resources\API\Customer\Profile\CustomerProfileResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class  AuthCustomerController extends BaseController
{
    /**
     * Validate the user login request.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $user = User::query()->where($request['type'], $request['username'])->first();

        if ($user && Hash::check($request['password'], $user['password'])) {

            return $this->respondData([
                'user' => new CustomerProfileResource($user),
                'token' => $this->generateToken($user)
            ]);
        }

        throw ValidationException::withMessages(['password' => 'Wrong password']);
    }


    /**
     * Validate the user login request.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::query()->create($request->validated());

        return $this->respondData([
            'user' => new CustomerProfileResource($user),
            'token' => $this->generateToken($user)
        ]);
    }

    private function generateToken($user)
    {
        return $user->createToken(config('app.name'))->plainTextToken;
    }


    /**
     * Revoke Token     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logOut(Request $request)
    {
        auth('customer')->user()->tokens()->delete();

        return $this->respondMessage('logout successful');
    }

}
