<?php

namespace Modules\Client\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Client\Services\ClientCommandService;
use Modules\Client\Http\Requests\CreateClientRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class CreateAction
{
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *      path="/clients",
     *      tags={"Client"},
     *      security={
     *          {"passport": {}},
     *      },
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="companyName", type="string"),
     *              @OA\Property(property="email", type="string", format="email"),
     *              @OA\Property(property="phoneNumber", type="string"),
     *              @OA\Property(property="kvkNumber", type="string", nullable=true),
     *              @OA\Property(property="btwNumber", type="string", nullable=true),
     *              @OA\Property(property="btwPercent", type="integer"),
     *              @OA\Property(property="invoiceEmail", type="string", format="email"),
     *              @OA\Property(property="invoiceForAttention", type="string", nullable=true),
     *              @OA\Property(property="password", type="string"),
     *              @OA\Property(property="password_confirmation", type="string"),
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
     * @param  CreateClientRequest  $request
     * @param  ClientCommandService $command
     * @return JsonResponse
     */
    public function __invoke(CreateClientRequest $request, ClientCommandService $command): JsonResponse
    {
        $dto = $request->toDto();

        $this->authorize('client:create', [$dto]);
        return response()->id($command->create($dto), JsonResponse::HTTP_CREATED);
    }
}
