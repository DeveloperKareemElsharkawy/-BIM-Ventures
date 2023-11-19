<?php

namespace App\Http\Controllers\API\Admin;

use App\Enums\RoleEnum;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Admin\Admins\FindAdminRequest;
use App\Http\Requests\API\Admin\Admins\StoreAdminRequest;
use App\Http\Requests\API\Admin\Admins\UpdateAdminRequest;
use App\Http\Requests\API\Admin\Auth\AdminLoginRequest;
use App\Http\Resources\API\Admin\Profile\AdminProfileResource;
use App\Http\Resources\API\Customer\Profile\CustomerProfileResource;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class  AdminsController extends BaseController
{
    /**
     * List Admins
     *
     * @param AdminLoginRequest $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $admins = Admin::query()->paginate(10);

        return $this->respondWithPagination(AdminProfileResource::collection($admins));
    }



    /**
     * @param FindAdminRequest $request
     * @param $adminId
     * @return JsonResponse
     */
    public function show(FindAdminRequest $request, $adminId)
    {
        $admin = Admin::query()->find($adminId);

        return $this->respondData(new AdminProfileResource($admin));
    }

    /**
     * @param StoreAdminRequest $request
     * @return JsonResponse
     */
    public function store(StoreAdminRequest $request)
    {
        $admin = Admin::query()->create($request->validated());

        $admin->assignRole(RoleEnum::Admin);

        return $this->respondData(new AdminProfileResource($admin),'created successfully');
    }


    /**
     * @param UpdateAdminRequest $request
     * @param int $adminId
     * @return JsonResponse
     */
    public function update(UpdateAdminRequest $request, int $adminId)
    {
        $admin = Admin::query()->where('id', $adminId)->first();

        $admin->update($request->except('admin_id'));

        return $this->respondData(new AdminProfileResource($admin),'updated successfully');
    }


    /**
     * @param FindAdminRequest $request
     * @param int $adminId
     * @return JsonResponse
     */
    public function destroy(FindAdminRequest $request, int $adminId)
    {
        $admin = Admin::query()->where('id', $adminId)->first();

        if ($admin->hasRole('super-admin')) {
            return $this->respondError('Cant delete Super Admin',403);
        }

        $admin->delete();

        return $this->respondData(new AdminProfileResource($admin),'deleted successfully');
    }
}
