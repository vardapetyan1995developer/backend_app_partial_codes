<?php

namespace App\Models;

use App\Enums\InvoiceStatus;
use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Infrastructure\Eloquent\Scopes\Invoice\WithTotalsScope;

/**
 * @method static InvoiceFactory factory()
 */
final class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'invoice_id',
        'price',
        'status',
        'sent_at',
        'paid_at',
        'is_credit',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'sent_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'btw' => 'decimal:2',
        'btw_percent' => 'decimal:2',
        'price' => 'decimal:2',
        'is_credit' => 'boolean',
        'status' => InvoiceStatus::class,
    ];

    public static function booted(): void
    {
        self::addGlobalScope('*', static fn ($q) => $q->select('invoices.*'));
    }

    public function scopeWithTotals(Builder $query)
    {
        return $query->addGlobalScope(new WithTotalsScope());
    }

    public function getPriceBtwAttribute(): string
    {
        return $this->asDecimal($this->price * $this->btw_percent / 100, 2);
    }

    public function getPriceTotalAttribute(): string
    {
        return $this->asDecimal($this->price + $this->price_btw, 2);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function client(): HasOneThrough
    {
        return $this->hasOneThrough(Client::class, Order::class, 'id', 'id', 'order_id', 'client_id');
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
