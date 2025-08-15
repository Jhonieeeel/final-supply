<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportSupply extends Model
{
    public function requisition()
    {
        return $this->hasMany(Requisition::class);
    }

    protected static function booted()
    {
        static::creating(function ($report) {
            $date = now()->format('Y-m-d');
            $report->serial_number = $date . "-" . $report->id;
        });
    }
}
