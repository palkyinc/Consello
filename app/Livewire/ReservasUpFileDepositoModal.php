<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Reserva;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;


class ReservasUpFileDepositoModal extends Component
{
    use WithFileUploads;    

    public $status = null;
    public $ant_reserva_id;
    public $reserva;
    #[Validate('required|file|max:10240')] // Máximo 10MB (en KB)
    public $archivo; // Aquí se mapea el input file
    #[Reactive] 
    public $reserva_id;

    protected $messages = [
        'archivo.required' => 'Debe adjuntar un archivo.',
        'archivo.file' => 'Debe ser un archivo válido.',
        'archivo.max' => 'El archivo no debe superar los 10MB.',
    ];

    public function render()
    {
        return view('livewire.reservas-up-file-deposito-modal');
    }
    public function mount(int $reserva_id)
    {
        $this->reserva_id = $reserva_id;
        $this->ant_reserva_id = $reserva_id;
    
    }
    public function boot() 
    {
        if ($this->reserva_id && $this->reserva_id !== $this->ant_reserva_id) {
            $this->reserva = Reserva::
                select('id', 'ruta_comprobante')
                ->find($this->reserva_id);
            $this->ant_reserva_id = $this->reserva_id;
        }
    }
    public function update(){
        $this->validate();
        $rutaRelativa = $this->archivo->store('eventos/comprobantes', 'public');
        $this->reserva->ruta_comprobante = $rutaRelativa;
        $this->reserva->save();
        $reservas_vinculadas = Reserva::select('id', 'ruta_comprobante')
                                        ->where('reserva_main_id', $this->reserva_id)
                                        ->get();
        foreach ($reservas_vinculadas as $item) {
            $item->ruta_comprobante = $rutaRelativa;
            $item->save();
        }
        $this->status['success'][] = 'Comprobante Guardado';
        $this->closeModal();
    }
    public function closeModal()
    {
        $this->reset('ant_reserva_id');
        $this->reset('reserva');
        $this->dispatch('closeModal', ['status' => $this->status]);
        $this->reset('status');
    }
}
