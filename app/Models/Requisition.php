<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Requisition extends Model
{

    public function slips()
    {
        return $this->hasMany(RequisitionSlip::class);
    }
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function items()
    {
        return $this->hasMany(RequisitionItem::class);
    }
    public function requestedBy()
    {
        return $this->belongsTo(User::class, "requested_by");
    }
    public function approvedBy()
    {
        return $this->belongsTo(User::class, "approved_by");
    }
    public function issuedBy()
    {
        return $this->belongsTo(User::class, "issued_by");
    }
    public function receivedBy()
    {
        return $this->belongsTo(User::class, "received_by");
    }

    protected static function booted()
    {
        static::saving(function ($requisition) {
            if (
                $requisition->requestedBy()->exists()
                && $requisition->approvedBy()->exists()
                && $requisition->issuedBy()->exists()
                && $requisition->receivedBy()->exists()
            ) {

                $date = now()->format('Y-m-d');
                $numberOfRequisition = Requisition::where('owner_id', Auth::id())
                    ->count() + 1;

                $userId = Auth::id();
                $format = "RIS-{$userId}-{$date}-{$numberOfRequisition}";

                $requisition->ris = $format;
            }
        });
    }
}
