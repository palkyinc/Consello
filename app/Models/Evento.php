<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Reserva;

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
    public function Reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'evento_id');
    }
    public function reservasSinPagar()
    {
        return Reserva::where('evento_id', $this->id)
                        ->where('invitado', false)
                        ->where('pagada', false)
                        ->count();
    }
}
