<?php

namespace Modules\Client\Http\Requests;

use App\Rules\PasswordRule;
use Modules\Client\Dto\CreateClientDto;
use Illuminate\Foundation\Http\FormRequest;

final class CreateClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyName' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],
            'phoneNumber' => [
                'required',
                'string',
                'max:255',
                'phone:AUTO',
            ],
            'kvkNumber' => [
                'nullable',
                'string',
                'max:255',
            ],
            'btwNumber' => [
                'nullable',
                'string',
                'max:255',
            ],
            'btwPercent' => [
                'required',
                'numeric',
                'min:0',
            ],
            'invoiceEmail' => [
                'required',
                'email',
                'max:255',
            ],
            'invoiceForAttention' => [
                'nullable',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'confirmed',
                new PasswordRule(),
            ],
            'details' => [
                'nullable',
                'string',
                'max:1024',
            ],
            'billing' => [
                'required',
                'array',
            ],
            'billing.street' => [
                'required',
                'string',
                'max:255',
            ],
            'billing.houseNumber' => [
                'required',
                'string',
                'max:255',
            ],
            'billing.addition' => [
                'nullable',
                'string',
                'max:255',
            ],
            'billing.postcode' => [
                'required',
                'string',
                'max:255',
            ],
            'billing.city' => [
                'required',
                'string',
                'max:255',
            ],
            'billing.country' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function toDto(): CreateClientDto
    {
        return new CreateClientDto(
            $this->input('companyName'),
            $this->input('email'),
            $this->input('phoneNumber'),
            $this->input('kvkNumber'),
            $this->input('btwNumber'),
            (float) $this->input('btwPercent'),
            $this->input('invoiceEmail'),
            $this->input('invoiceForAttention'),
            $this->input('password'),
            $this->input('details'),
            $this->input('billing.street'),
            $this->input('billing.houseNumber'),
            $this->input('billing.addition'),
            $this->input('billing.postcode'),
            $this->input('billing.city'),
            $this->input('billing.country'),
        );
    }
}
