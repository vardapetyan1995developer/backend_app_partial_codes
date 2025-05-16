<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Schemas\AdminSchema;
use Infrastructure\Http\Resources\JsonResource;
use Infrastructure\Http\Schemas\AbstractSchema;
use Infrastructure\Http\Resources\Traits\ConvertsSchemaToArray;

/**
 * @property User $resource
 */
final class AdminResource extends JsonResource
{
    use ConvertsSchemaToArray;

    public function getSchemaName(): string
    {
        return class_basename(AdminSchema::class);
    }

    public function toSchema($request): AbstractSchema
    {
        return new AdminSchema(
            $this->resource->id,
            $this->resource->email,
            $this->resource->username,
            $this->resource->has_accepted_terms,
        );
    }
}
