<?php

namespace Modules\Admin\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Admin\Services\AdminCommandService;
use Modules\Admin\Http\Requests\CreateAdminRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class CreateAction
{
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *      path="/admins",
     *      tags={"Admin"},
     *      security={
     *          {"passport": {}},
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="email", type="string", format="email"),
     *              @OA\Property(property="username", type="string", nullable=true),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="password_confirmation", type="string"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful",
     *          @OA\JsonContent(
     *              type="object",
     *              ref="#/components/schemas/IdSchema",
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
     * @param  CreateAdminRequest  $request
     * @param  AdminCommandService $command
     * @return JsonResponse
     */
    public function __invoke(CreateAdminRequest $request, AdminCommandService $command): JsonResponse
    {
        return response()->id($command->create($request->toDto()), JsonResponse::HTTP_CREATED);
    }
}
