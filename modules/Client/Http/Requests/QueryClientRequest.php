<?php

namespace Modules\Client\Http\Requests;

use Modules\Client\Dto\QueryClientDto;
use Illuminate\Foundation\Http\FormRequest;

final class QueryClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'q' => [
                'string',
                'max:255',
            ],
        ];
    }

    public function toDto(): QueryClientDto
    {
        return new QueryClientDto(
            $this->query('q'),
        );
    }
}
