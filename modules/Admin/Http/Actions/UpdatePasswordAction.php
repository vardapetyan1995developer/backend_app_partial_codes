<?php

namespace Modules\Admin\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Admin\Services\AdminCommandService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Admin\Http\Requests\UpdateAdminPasswordRequest;

final class UpdatePasswordAction
{
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *      path="/admins/{id}/updatePassword",
     *      tags={"Admin"},
     *      security={
     *          {"passport": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          parameter="id",
     *          @OA\Schema(type="integer"),
     *          in="path",
     *          required=true
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="password_confirmation", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/MessageSchema",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/ErrorMessageSchema",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/ErrorMessageSchema",
     *          ),
     *      ),
     * )
     *
     * @param  UpdateAdminPasswordRequest $request
     * @param  AdminCommandService        $command
     * @param  int                        $id
     * @return JsonResponse
     */
    public function __invoke(UpdateAdminPasswordRequest $request, AdminCommandService $command, int $id): JsonResponse
    {
        $command->updatePassword($id, $request->toDto());

        return response()->message(trans('messages.admin.password_updated'));
    }
}
