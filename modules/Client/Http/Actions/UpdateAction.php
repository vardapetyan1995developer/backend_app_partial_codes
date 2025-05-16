<?php

namespace Modules\Client\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Client\Services\ClientCommandService;
use Modules\Client\Http\Requests\UpdateClientRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class UpdateAction
{
    use AuthorizesRequests;

    /**
     * @OA\Put(
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
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="companyName", type="string"),
     *              @OA\Property(property="phoneNumber", type="string"),
     *              @OA\Property(property="kvkNumber", type="string", nullable=true),
     *              @OA\Property(property="btwNumber", type="string", nullable=true),
     *              @OA\Property(property="btwPercent", type="integer"),
     *              @OA\Property(property="invoiceEmail", type="string"),
     *              @OA\Property(property="invoiceForAttention", type="string", nullable=true),
     *              @OA\Property(property="details", type="string", nullable=true),
     *              @OA\Property(
     *                  property="billing",
     *                  type="object",
     *                  @OA\Property(property="street", type="string"),
     *                  @OA\Property(property="houseNumber", type="string"),
     *                  @OA\Property(property="addition", type="string", nullable=true),
     *                  @OA\Property(property="postcode", type="string"),
     *                  @OA\Property(property="city", type="string"),
     *                  @OA\Property(property="country", type="string", nullable=true),
     *               )
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
     * @param  UpdateClientRequest  $request
     * @param  ClientCommandService $command
     * @param  int                  $id
     * @return JsonResponse
     */
    public function __invoke(UpdateClientRequest $request, ClientCommandService $command, int $id): JsonResponse
    {
        $dto = $request->toDto();

        $this->authorize('client:update', [$id, $dto]);
        $command->update($id, $dto);

        return response()->message(trans('messages.client.updated'));
    }
}
