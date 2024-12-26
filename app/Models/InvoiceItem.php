<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = ['invoice_id', 'service_id', 'hours_used', 'rate_per_hour', 'total'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
