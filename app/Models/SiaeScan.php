<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiaeScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'virtual_store_matrix_id', 'operator_id', 'siae_order_item_id', 'is_scanned', 'date_scanned', 'date_expiration', 'qr_code', 'verification_needed'
    ];


    public function virtual_store_matrix() : BelongsTo
    {
        return $this->belongsTo(VirtualStoreMatrix::class,'virtual_store_matrix_id', 'id');
    }


    public function order_item() : BelongsTo
    {
        return $this->belongsTo(SiaeOrderItem::class, 'siae_order_item_id', 'id');
    }
}
