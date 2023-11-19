<?php

namespace App\Http\Controllers\API\Admin\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Admin\Auth\AdminLoginRequest;
use App\Http\Resources\API\Admin\Profile\AdminProfileResource;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class  AuthAdminController extends BaseController
{
    /**
     * Validate the user login request.
     *
     * @param AdminLoginRequest $request
     * @return JsonResponse
     */
    public function login(AdminLoginRequest $request)
    {
        $user = Admin::query()->where($request['type'], $request['username'])->first();

        if ($user && Hash::check($request['password'], $user['password'])) {

            return $this->respondData([
                'user' => new AdminProfileResource($user),
                'token' => $this->generateToken($user)
            ]);
        }

        throw ValidationException::withMessages(['password' => 'Wrong password']);
    }

    private function generateToken($user)
    {
        return $user->createToken(config('app.name'))->plainTextToken;
    }


    /**
     * Revoke Token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logOut(Request $request)
    {
        auth('admin')->user()->tokens()->delete();

        return $this->respondMessage('logout successful');
    }

}
