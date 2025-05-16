<?php

namespace App\Models\Pivot;

use App\Models\File;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class FileOrder extends Pivot
{
    public $timestamps = false;

    protected $fillable = [
        'file_id',
        'order_id',
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
