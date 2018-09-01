<?php

namespace App\Models\Finance\PaymentModes;

use App\Models\Finance\Payment;
use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $fillable = [];

    public function payment()
    {
        return $this->morphOne(Payment::class, 'mode');
    }
}
