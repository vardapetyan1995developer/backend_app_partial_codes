<?php

namespace App\Http\Schemas;

use Infrastructure\Http\Schemas\AbstractSchema;

/**
 * @OA\Schema(schema="SuperAdminSchema", type="object")
 */
final class SuperAdminSchema extends AbstractSchema
{
    public function __construct(
        /** @OA\Property() */
        public int $id,
        /** @OA\Property() */
        public string $email,
        /** @OA\Property() */
        public ?string $username,
        /** @OA\Property() */
        public bool $hasAcceptedTerms,
    ) {
        //
    }
}
