<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'address',
        'bedrooms',
        'bathrooms',
        'total_area',
        'purchased',
        'value',
        'discount',
        'owner_id',
        'expired'
    ];

    protected $hidden = ['deleted_at'];

    protected $appends = ['value_with_discount'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getValueWithDiscountAttribute()
    {
        return $this->value - ($this->value * ($this->discount/100));
    }
}
