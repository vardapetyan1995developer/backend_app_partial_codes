<?php

namespace Modules\Client\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Client\Services\ClientCommandService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Client\Http\Requests\UpdateClientPasswordRequest;

final class UpdatePasswordAction
{
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *      path="/clients/{id}/updatePassword",
     *      tags={"Client"},
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
     * @param  UpdateClientPasswordRequest $request
     * @param  ClientCommandService        $command
     * @param  int                         $id
     * @return JsonResponse
     */
    public function __invoke(UpdateClientPasswordRequest $request, ClientCommandService $command, int $id): JsonResponse
    {
        $dto = $request->toDto();

        $this->authorize('client:update:password', [$id, $dto]);
        $command->updatePassword($id, $dto);

        return response()->message(trans('messages.client.password_updated'));
    }
}
