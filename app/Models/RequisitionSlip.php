<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequisitionSlip extends Model
{
    public function requisition()
    {
        return $this->belongsTo(Requisition::class, 'requisition_id');
    }
}
