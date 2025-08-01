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
}
