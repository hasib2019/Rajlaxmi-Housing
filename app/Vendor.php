<?php

namespace App;

use App\PurchaseOrder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'mailing_address',
        'website',
        'phone',
        'email',
        'description',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function purchase_orders()
    {
        return $this->hasMany(PurchaseOrder::class, 'vendor_id', 'id');
    }
}
