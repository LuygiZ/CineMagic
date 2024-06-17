<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $table = 'configuration';

    protected $fillable = [
        'id',
        'ticket_price',
        'registered_customer_ticket_discount',
        'custom',
    ];

    public $timestamps = false;

    public static function getTicketPrice()
    {
        $configuration = Configuration::first();
        return $configuration ? $configuration->ticket_price : null;
    }

    public static function getTicketDiscount()
    {
        $configuration = Configuration::first();
        return $configuration ? $configuration->registered_customer_ticket_discount : null;
    }
}
