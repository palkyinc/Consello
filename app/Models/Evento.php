<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Evento extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha' => 'date', // o 'date' si solo guarda año-mes-día
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fecha',
        'nombre',
        'descripcion',
    ];
    public function getFlyerUrlAttribute(): ?string
    {
        return $this->ruta_archivo ? Storage::url($this->ruta_archivo) : null;
    }
}
