<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'created_by',
        'amount',
        'due_date',
        'vat_percentage',
        'is_vat_inclusive',
        'status',
    ];


    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class,'created_by');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Payment::class);
    }
}
