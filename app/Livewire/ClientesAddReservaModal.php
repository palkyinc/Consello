<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Config;
use App\Models\Evento;
use App\Models\Adicional;
use App\Models\Reserva;

class ClientesAddReservaModal extends Component
{
    public $evento;
    public $adicionales = [];
    public $ant_evento_id;
    public $status = null;
    public $precio = 0;
    public $total_depositar = 0;

    // Array clave-valor: [adicional_id => cantidad_seleccionada]
    public array $seleccion_adicionales = [];
    
    public $cant_entradas = 1;

    #[Reactive] 
    public $evento_id;
    
    public function mount(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->ant_evento_id = $evento_id;
    }
    public function boot() 
    {
        if ($this->evento_id && $this->evento_id !== $this->ant_evento_id) {
            $this->evento = Evento::
                select("id", "nombre", "fecha", "precio")
                ->find($this->evento_id);
            $this->precio = $this->evento->precio;
            $this->ant_evento_id = $this->evento_id;
            $this->adicionales = Adicional::select('*')
                                            ->where('evento_id', $this->evento_id)
                                            ->orderBy('precio', "ASC")
                                            ->get();
            foreach ($this->adicionales as $adicional) {
                if ($adicional->precio === 0) {
                    $this->seleccion_adicionales[$adicional->id] = 1;
                } else {
                    $this->seleccion_adicionales[$adicional->id] = 0;
                }
                
            }
        }
    }
    public function render()
    {
        return view('livewire.clientes-add-reserva-modal');
    }
    public function calculoTotal ($es_checkout)
    {
        $totalEntradas = $this->cant_entradas * $this->precio;
        $totalAdicionales = 0;
        $adicionales_checkout = '';
        
        foreach ($this->adicionales as $adicional) {
            $cantAdicional = (int) ($this->seleccion_adicionales[$adicional->id] ?? 0);
            
            // Si el adicional tiene precio (> 0), se suma
            if ($adicional->precio > 0 && $cantAdicional > 0) {
                $totalAdicionales += $cantAdicional * $adicional->precio * $this->cant_entradas;
                $adicionales_checkout = $adicionales_checkout . ' + ' . $cantAdicional * $this->cant_entradas . ' ' . $adicional->nombre;
            }
        }
        if ($es_checkout) {
            if(isset($this->evento->nombre))
                {
                    return 'Estas reservando: ' . $this->cant_entradas . ' Entradas a ' . $this->evento->nombre . $adicionales_checkout;
                }
        } else {
            return $this->total_depositar = $totalEntradas + $totalAdicionales;;
        }
        
    }
    public function save ()
    {
        $this->validate([
        'cant_entradas' => 'required|numeric|min:1|max:4',
            // Reglas para CADA adicional dentro del array asociativo
        'seleccion_adicionales.*' => 'required|integer|min:0|max:3',
    ], [
        // Mensajes personalizados opcionales
        'seleccion_adicionales.*.min' => 'La cantidad no puede ser menor a 0.',
        'seleccion_adicionales.*.max' => 'No puedes solicitar más de 10 unidades de este adicional.',
        'seleccion_adicionales.*.integer' => 'El valor debe ser un número entero.',
        'cant_entradas.required' => 'La cantidad es obligatoria.',
        'cant_entradas.min' => 'Mínimo 1 entrada.',
        'cant_entradas.max' => 'Máximo 4 entradas.',
        'cant_entradas.numeric' => 'La cantidad de entradas debe ser numerico',
        ]);
        #CRear la reserva
        #Crear los adicionales
        #enviar un email con el resumen + datos de deposito.
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('evento', 'adicionales', 'precio', 'total_depositar', 'seleccion_adicionales');
        $this->reset('ant_evento_id');
        $this->reset('cant_entradas');
        $this->resetValidation();
        $this->dispatch('closeModal', ['status' => $this->status]);
        $this->reset('status');
    }
}
