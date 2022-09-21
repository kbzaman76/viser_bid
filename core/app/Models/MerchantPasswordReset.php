<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantPasswordReset extends Model
{
    protected $table = "merchant_password_resets";
    protected $guarded = ['id'];
    public $timestamps = false;
}
