<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}
