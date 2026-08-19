<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\Form;
use app\Models\Evento;
use Illuminate\Support\Facades\Config;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;

class EventosEditMOdal extends Component
{
    use WithFileUploads;    

    public $evento;
    public $ant_evento_id;
    public $status = null;

    #[Reactive] 
    public $evento_id;

    #[Validate('required|min:2|max:255')]
    public $nombre;
    #[Validate('required|date')]
    public $fecha;
    #[Validate('required|string|max:65535')]
    public $descripcion = '';
    #[Validate('required|string|max:65535')]
    public $descripcion_transf = '';
    #[Validate('nullable|file|max:10240')] // Máximo 10MB (en KB)
    public $archivo; // Aquí se mapea el input file
    #[Validate('required|numeric|min:0')]
    public $precio = 0;
    #[Validate('required|numeric|min:0|max:999')]
    public $aforo = 0;
    #[Validate('required|boolean')]
    public $activo = false;
    
    protected $messages = [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.min' => 'Como mínimo 2 caracteres.',
        'nombre.max' => 'Como máximo 255 caracteres.',
        'fecha.required' => 'La fecha es obligatoria.',
        'fecha.date' => 'La fecha no es válida.',
        'descripcion.required' => 'La descripción es obligatoria.',
        'descripcion.max' => 'Como máximo 65535 caracteres.',
        'descripcion_transf.required' => 'La descripción es obligatoria.',
        'descripcion_transf.max' => 'Como máximo 65535 caracteres.',
        'archivo.file' => 'Debe ser un archivo válido.',
        'archivo.max' => 'El archivo no debe superar los 10MB.',
        'precio.required' => 'El precio es obligatorio',
        'precio.numeric' => 'El precio debe ser un numero',
        'precio.min' => 'El precio debe ser cero o mayor',
        'aforo.required' => 'El aforo es obligatorio',
        'aforo.numeric' => 'El aforo debe ser un numero',
        'aforo.min' => 'El aforo debe ser cero o mayor',
        'aforo.max' => 'El aforo debe ser menor a 1000',
    ];

    public function mount(int $evento_id)
    {
        $this->evento_id = $evento_id;
        $this->ant_evento_id = $evento_id;
    }
    public function boot() 
    {
        if ($this->evento_id && $this->evento_id !== $this->ant_evento_id) {
            $this->evento = Evento::
                select('*')
                ->find($this->evento_id);
            $this->nombre = $this->evento->nombre;
            $this->fecha = $this->evento->fecha ? $this->evento->fecha->format('Y-m-d') : null;
            $this->descripcion = $this->evento->descripcion;
            $this->descripcion_transf = $this->evento->descripcion_transferencia;
            $this->precio = $this->evento->precio;
            $this->aforo = $this->evento->aforo;
            $this->activo = $this->evento->activo;
            $this->ant_evento_id = $this->evento_id;
        }
    }
    public function render()
    {
        return view('livewire.eventos-edit-m-odal');
    }
    public function update()
    {
        $this->validate();
        
        if ($this->evento) {
            if ($this->archivo) {
                $rutaRelativa = $this->archivo->store('eventos/flyers', 'public');
                $this->evento->ruta_archivo = $rutaRelativa;
                $this->status['success'][] = 'Archivo Guardado en el evento: ' . $this->evento->nombre;
            }
            $this->evento->nombre = $this->nombre;
            $this->evento->fecha = $this->fecha;
            $this->evento->descripcion = $this->descripcion;
            $this->evento->descripcion_transferencia = $this->descripcion_transf;
            $this->evento->precio = $this->precio;
            $this->evento->aforo = $this->aforo;
            $this->evento->activo = $this->activo;
            $this->evento->save();
            $this->status['success'][] = 'Evento: ' . $this->evento->nombre . ' fue editado.';
        } else {
            $this->status['error'][] = 'Evento no encontrado.';
        }
        $this->closeModal();
    }
    public function deleteFile()
    {
        if ($this->evento && $this->evento->ruta_archivo) {
            // Eliminar el archivo del almacenamiento
            \Storage::disk('public')->delete($this->evento->ruta_archivo);
            // Actualizar la ruta del archivo en la base de datos
            $this->evento->ruta_archivo = null;
            $this->evento->save();
            $this->status['warning'][] = 'Archivo del evento: ' . $this->evento->nombre . ' fue eliminado.';
        } else {
            $this->status['error'][] = 'No hay archivo para eliminar.';
        }
    }
    public function closeModal()
    {
        $this->reset('nombre');
        $this->reset('fecha');
        $this->reset('descripcion');
        $this->reset('descripcion_transf');
        $this->reset('archivo');
        $this->reset('evento');
        $this->reset('precio');
        $this->reset('aforo');
        $this->reset('ant_evento_id');
        $this->resetValidation();
        $this->dispatch('closeModal', ['status' => $this->status]);
        $this->reset('status');
    }
}
