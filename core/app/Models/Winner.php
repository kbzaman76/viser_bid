<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }
}
