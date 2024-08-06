<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VirtualStoreLot extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'user_id',
        'company_id',
        'status_id',
        'qty',
        'virtual_store_order_id'
    ];


    public function virtual_store_order()
    {
        return $this->hasOne(VirtualStoreOrder::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function status(){
        return $this->belongsTo(VirtualStoreStatus::class);
    }

    public function matrices(){
        return $this->hasMany(VirtualStoreMatrix::class,'id','lot_id');
    }

    public function getFirstMatrixAttribute(){
        $matrix = VirtualStoreMatrix::where('lot_id',$this->id)->whereYear('created_at',date('Y'))->first();
        if (empty($matrix)){
            return "";
        }
        return $matrix->code."/".$matrix->progressive."/".$matrix->year;
    }
}
