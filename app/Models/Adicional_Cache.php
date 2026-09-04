<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Adicional_Cache extends Model
{
    use HasFactory;

    protected $fillable = [
        'reserva_id',
        'adicional_id',
    ];

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(Reserva::class, 'reserva_id');
    }
    public function adicional(): BelongsTo
    {
        return $this->belongsTo(Adicional::class, 'adicional_id');
    }
    public function checkedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'check_by_id');
    }
    public function getAdicionalCacheNombre()
    {
        return Adicional::find($this->adicional_id)->nombre; 
    }
}
