<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{
    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
