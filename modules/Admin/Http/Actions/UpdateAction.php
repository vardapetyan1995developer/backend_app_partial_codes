<?php

namespace Modules\Admin\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Admin\Services\AdminCommandService;
use Modules\Admin\Http\Requests\UpdateAdminRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class UpdateAction
{
    use AuthorizesRequests;

    /**
     * @OA\Put(
     *      path="/admins/{id}",
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
     *              @OA\Property(property="username", type="string", nullable=true),
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
     * @param  UpdateAdminRequest  $request
     * @param  AdminCommandService $command
     * @param  int                 $id
     * @return JsonResponse
     */
    public function __invoke(UpdateAdminRequest $request, AdminCommandService $command, int $id): JsonResponse
    {
        $command->update($id, $request->toDto());

        return response()->message(trans('messages.admin.updated'));
    }
}
