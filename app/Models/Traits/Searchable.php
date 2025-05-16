<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearchable(Builder $query, ?string $q = null): Builder
    {
        return $query->where(function (Builder $builder) use ($q): void {
            foreach ($this->searchable as $i => $column) {
                $builder->{$i === 0 ? 'where' : 'orWhere'}($column, 'ILIKE', "%{$q}%");
            }
        });
    }
}
