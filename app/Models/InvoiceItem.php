<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Database\Factories\InvoiceItemFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Infrastructure\Eloquent\Scopes\InvoiceItem\WithTotalsScope;

/**
 * @method static InvoiceItemFactory factory()
 */
final class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'price',
        'description',
        'qty',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'btw' => 'decimal:2',
        'btw_percent' => 'decimal:2',
    ];

    public static function booted(): void
    {
        self::addGlobalScope('*', static fn ($q) => $q->select('invoice_items.*'));
    }

    public function scopeWithTotals(Builder $query)
    {
        return $query->addGlobalScope(new WithTotalsScope());
    }

    public function getTotalAttribute(): string
    {
        return $this->asDecimal($this->subtotal + $this->btw, 2);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
