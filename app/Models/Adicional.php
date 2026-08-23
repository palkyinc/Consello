<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adicional extends Model
{
    use HasFactory;

    protected $fillable = [
        'cantidad',
        'nombre',
        'evento_id',
        'creador_id',
    ];

    public function adicional_cache(): HasMany
    {
        return $this->hasMany(Adicional_Cache::class, 'adicional_id');
    }
}
