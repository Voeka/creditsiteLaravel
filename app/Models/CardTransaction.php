<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'type',
        'amount',
        'comment',
    ];

    // Связь с картой
    public function card()
    {
        return $this->belongsTo(Card::class);
    }
}
