<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_id',
        'tot_pagado',
        'creador_id',
        'reserva_main_id',
    ];
    

    protected static function boot()
    {
        parent::boot();

        static::created(function ($reserva) {
            $fecha = $reserva->created_at->format('Ymd');
            $paddedId = str_pad($reserva->id, 5, '0', STR_PAD_LEFT);
            $randomHash = strtoupper(Str::random(6));

            // Guarda el código generado usando el ID recién asignado
            $reserva->ticket_code = "{$fecha}-{$paddedId}-{$randomHash}";
            $reserva->saveQuietly();
        });
    }
    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creador_id');
    }
    public function checkedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'check_by_id');
    }
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }
    public function adicionales_cache(): HasMany
    {
        return $this->hasMany(Adicional_Cache::class, 'reserva_id');
    }
    public function Reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'reserva_main_id');
    }
    public function cantidadReservadas ()
    {
        return count($this->reservas) + 1;
    }
}
