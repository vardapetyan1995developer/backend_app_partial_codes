<?php

namespace App\Http\Schemas\Partial;

use Infrastructure\Http\Schemas\AbstractSchema;

/**
 * @OA\Schema(schema="ClientBillingSchema", type="object")
 */
final class ClientBillingSchema extends AbstractSchema
{
    public function __construct(
        /** @OA\Property() */
        public string $street,
        /** @OA\Property() */
        public string $houseNumber,
        /** @OA\Property() */
        public ?string $addition,
        /** @OA\Property() */
        public string $postcode,
        /** @OA\Property() */
        public string $city,
        /** @OA\Property() */
        public ?string $country,
    ) {
        //
    }
}
