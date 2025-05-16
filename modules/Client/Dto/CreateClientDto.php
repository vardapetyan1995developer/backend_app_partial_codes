<?php

namespace Modules\Client\Dto;

final class CreateClientDto
{
    public function __construct(
        public readonly string $companyName,
        public readonly string $email,
        public readonly string $phoneNumber,
        public readonly ?string $kvkNumber,
        public readonly ?string $btwNumber,
        public readonly float $btwPercent,
        public readonly string $invoiceEmail,
        public readonly ?string $invoiceForAttention,
        public readonly string $password,
        public readonly ?string $details,
        public readonly string $billingStreet,
        public readonly string $billingHouseNumber,
        public readonly ?string $billingAddition,
        public readonly string $billingPostcode,
        public readonly string $billingCity,
        public readonly ?string $billingCountry,
    ) {
        //
    }
}
