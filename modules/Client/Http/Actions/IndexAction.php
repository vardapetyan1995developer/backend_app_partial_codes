<?php

namespace Modules\Client\Http\Actions;

use App\Http\Resources\ClientResource;
use Modules\Client\Services\ClientQueryService;
use Modules\Client\Http\Requests\QueryClientRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class IndexAction
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     *      path="/clients",
     *      tags={"Client"},
     *      security={
     *          {"passport": {}},
     *      },
     *      @OA\Parameter(
     *          name="q",
     *          @OA\Schema(type="string"),
     *          in="query"
     *      ),
     *      @OA\Parameter(
     *          name="cursor",
     *          @OA\Schema(type="string"),
     *          in="query"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\Header(header="x-pagination-per-page", @OA\Schema(type="string", nullable=true)),
     *          @OA\Header(header="x-pagination-previous", @OA\Schema(type="string", nullable=true)),
     *          @OA\Header(header="x-pagination-next", @OA\Schema(type="string", nullable=true)),
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/ClientSchema")
     *              ),
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
     * @param  QueryClientRequest $request
     * @param  ClientQueryService $query
     * @return ResourceCollection
     */
    public function __invoke(QueryClientRequest $request, ClientQueryService $query): ResourceCollection
    {
        $dto = $request->toDto();

        $this->authorize('client:query', [$dto]);
        $clients = $query->query($dto);

        return ClientResource::collection($clients);
    }
}
