<?php

namespace Modules\Client\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Client\Services\ClientCommandService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class AcceptTermsAction
{
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *      path="/clients/{id}/acceptTerms",
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
     * @param  ClientCommandService   $command
     * @param  int                    $id
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function __invoke(ClientCommandService $command, int $id): JsonResponse
    {
        $this->authorize('client:terms', [$id]);
        $command->acceptTerms($id);

        return response()->message(trans('messages.client.terms_accepted'));
    }
}
