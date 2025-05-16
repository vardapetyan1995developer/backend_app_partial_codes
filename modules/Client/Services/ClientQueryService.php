<?php

namespace Modules\Client\Services;

use App\Models\Client;
use Modules\Client\Dto\QueryClientDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

final class ClientQueryService
{
    public function query(QueryClientDto $query): CursorPaginator
    {
        $builder = Client::query()
            ->with(['user'])
            ->orderBy('id');

        if ($queryString = $query->queryString) {
            $builder->search($queryString);
        }

        return $builder
            ->orderBy('clients.id')
            ->cursorPaginate();
    }

    public function sole(int $clientId): Client
    {
        return Client::query()
            ->with(['user'])
            ->findOrFail($clientId);
    }
}
