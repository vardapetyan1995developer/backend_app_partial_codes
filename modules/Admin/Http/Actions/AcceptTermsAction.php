<?php

namespace Modules\Admin\Http\Actions;

use Illuminate\Http\JsonResponse;
use Modules\Admin\Services\AdminCommandService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

final class AcceptTermsAction
{
    use AuthorizesRequests;

    /**
     * @OA\Post(
     *      path="/admins/{id}/acceptTerms",
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
     * @param  AdminCommandService    $command
     * @param  int                    $id
     * @throws AuthorizationException
     * @return JsonResponse
     */
    public function __invoke(AdminCommandService $command, int $id): JsonResponse
    {
        $this->authorize('admin:terms', [$id]);
        $command->acceptTerms($id);

        return response()->message(trans('messages.admin.terms_accepted'));
    }
}
