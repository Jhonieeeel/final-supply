<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
    public function items()
    {
        return $this->belongsTo(RequisitionItem::class);
    }

    protected static function booted()
    {
        static::creating(function ($stock) {
            $date = now()->format('Y-m-d');
            $stock->stock_number =  "Supply-{$date}";
        });
    }
}
