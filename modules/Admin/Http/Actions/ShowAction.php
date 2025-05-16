<?php

namespace Modules\Admin\Http\Actions;

use App\Http\Resources\AdminResource;
use Modules\Admin\Services\AdminQueryService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class ShowAction
{
    use AuthorizesRequests;

    /**
     * @OA\Get(
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
     *      @OA\Response(
     *          response=200,
     *          description="Successful",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", ref="#/components/schemas/AdminSchema"),
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
     * @param  AdminQueryService $query
     * @param  int               $id
     * @return JsonResource
     */
    public function __invoke(AdminQueryService $query, int $id): JsonResource
    {
        $admin = $query->sole($id);

        return new AdminResource($admin);
    }
}
