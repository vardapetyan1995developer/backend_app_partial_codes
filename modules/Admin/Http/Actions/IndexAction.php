<?php

namespace Modules\Admin\Http\Actions;

use App\Http\Resources\AdminResource;
use Modules\Admin\Services\AdminQueryService;
use Modules\Admin\Http\Requests\QueryAdminRequest;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class IndexAction
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
     *      path="/admins",
     *      tags={"Admin"},
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
     *                  @OA\Items(ref="#/components/schemas/AdminSchema")
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
     * @param  QueryAdminRequest  $request
     * @param  AdminQueryService  $query
     * @return ResourceCollection
     */
    public function __invoke(QueryAdminRequest $request, AdminQueryService $query): ResourceCollection
    {
        $admins = $query->query($request->toDto());

        return AdminResource::collection($admins);
    }
}
