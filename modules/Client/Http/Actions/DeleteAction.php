<?php

namespace Modules\Client\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Client\Services\ClientCommandService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class DeleteAction
{
    use AuthorizesRequests;

    /**
     * @OA\Delete(
     *      path="/clients/{id}",
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
     * @param  ClientCommandService $command
     * @param  int                  $id
     * @return JsonResponse
     */
    public function __invoke(ClientCommandService $command, int $id): JsonResponse
    {
        $this->authorize('client:delete', [$id]);
        $command->delete($id);

        return response()->message(trans('messages.client.deleted'));
    }
}
