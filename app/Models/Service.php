<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['service_name', 'hourly_rate', 'description'];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
