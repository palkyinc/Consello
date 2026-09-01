<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Form;
use App\Models\Reserva;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Computed;
use App\Mail\ComprobanteAprobadoMail;
use Illuminate\Support\Facades\Mail;

class DashboardConfirmTransfModal extends Component
{
    public $reserva;
    public $ant_reserva_id;
    public $status = null;
    public $cantidadReservadas = 0;
    public $adicionales_listado = [];
    public $comprador = '';
    
    #[Reactive] 
    public $reserva_id = 0;
    
    public function mount(int $reserva_id)
    {
        $this->reserva_id = $reserva_id;
        $this->ant_reserva_id = $reserva_id;
    }
    public function boot() 
    {
        if ($this->reserva_id && $this->reserva_id !== $this->ant_reserva_id) {
            $this->reserva = Reserva::
                select("*")
                ->find($this->reserva_id);
            $this->ant_reserva_id = $this->reserva_id;
            $this->cantidadReservadas = ($this->reserva->cantidadReservadas());
            $this->comprador = $this->reserva->creador->name;
            $this->getAdionalesList($this->reserva);
            foreach ($this->reserva->reservas as $key => $item) {
                $this->getAdionalesList($item);
            }
        }
    }
    private function getAdionalesList (Reserva $reserva)
    {
        foreach ($reserva->adicionales_cache as $value) {
            if (isset($this->adicionales_listado[$value->adicional->nombre])) {
                $this->adicionales_listado[$value->adicional->nombre] ++; 
            } else {
                $this->adicionales_listado[$value->adicional->nombre] = 1; 
            }
        }
    } 
    public function render()
    {
        return view('livewire.dashboard-confirm-transf-modal');
    }
    public function aprobar()
    {
        #pasar todas las reservas a pagadas
        $this->reserva->pagada = true;
        $this->reserva->cliente_id = $this->reserva->creador_id;
        $this->reserva->save();
        foreach ($this->reserva->reservas as $key => $item) {
                $item->pagada = true;
                $item->save();
        }
        #enviar email confirmando pago e informando que pronto debera personaliar entradas.
        Mail::to($this->reserva->creador->email)->send(new ComprobanteAprobadoMail($this->reserva));
        $this->status['success'][] = 'Comprobante aprobado y notificación enviada.';
        $this->closeModal();
    }
    public function closeModal ()
    {
        $this->reset('reserva');
        $this->reset('ant_reserva_id');
        $this->reset('cantidadReservadas');
        $this->adicionales_listado = [];
        $this->reset('comprador');
        $this->dispatch('closeModal', ['status' => $this->status]);
        $this->reset('status');
    } 
}
