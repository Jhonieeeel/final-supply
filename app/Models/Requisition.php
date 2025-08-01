<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    public function items()
    {
        return $this->hasMany(RequisitionItem::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, "requested_by");
    }
}
