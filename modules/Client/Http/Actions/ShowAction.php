<?php

namespace Modules\Client\Http\Actions;

use App\Http\Resources\ClientResource;
use Modules\Client\Services\ClientQueryService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class ShowAction
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
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
     *              @OA\Property(property="data", ref="#/components/schemas/ClientSchema"),
     *              @OA\Property(property="schema", type="string"),
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
     * @param  ClientQueryService $query
     * @param  int                $id
     * @return JsonResource
     */
    public function __invoke(ClientQueryService $query, int $id): JsonResource
    {
        $this->authorize('client:view', [$id]);
        $client = $query->sole($id);

        return new ClientResource($client);
    }
}
