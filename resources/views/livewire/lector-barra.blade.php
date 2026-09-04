<div>
    @can('lectorBarra_index')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <!-- Flash Messages -->
        @if (session('status'))
            @foreach (session('status') as $key => $messages)
                @foreach ($messages as $message)
                    <div class="alert alert-{{$key}} alert-dismissible fade show" role="alert">
                        <p><strong>{{ $message }}</strong></p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endforeach
        @endif
        <div class="p-4" x-data="qrScanner()">
            <h2 class="text-lg font-bold mb-4">Adicionales / BARRA</h2>
            <div class="d-flex flex-row align-items-center mb-4">
                <h5 class="card-title">Evento</h5>
                <select class="form-select" aria-label="Default select example" wire:model.live="evento_id">
                    @foreach ($eventos as $item)
                            <option value="{{$item->id}}">{{$item->nombre}}</option>
                    @endforeach
                </select>
            </div>
            @if ($evento_id)
                    <!-- Contenedor del video/cámara -->
                    <div id="reader" class="w-full max-w-md mx-auto overflow-hidden rounded-lg shadow-md"></div>

                    <!-- Botones opcionales de control -->
                    <div class="mt-4 text-center">
                        <button x-show="!scanning" @click="startScanner()" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Iniciar Escáner
                        </button>
                        <button x-show="scanning" @click="stopScanner()" class="bg-red-600 text-white px-4 py-2 rounded">
                            Detener Escáner
                        </button>
                    </div>
                    <!-- Tabla de Reservas -->
                    <div x-show="!scanning" class="mt-5 text-center">
                        @if ($reserva)
                            <h4>Asistente: {{ $reserva->cliente->name ?? 'No asignado' }}</h4>
                            <h4>Comprador: {{ $reserva->creador->name ?? 'ERROR' }}</h4>
                            <hr>
                        @endif
                        @foreach ($adicionalesReserva as $adicional)
                            <h3>{{ $adicional->adicional->nombre}}</h3>
                            <p>Usada: {{ $adicional->usada ? 'SI' : 'NO'}}</p>
                            @if ($adicional->usada)
                                <p class="alert alert-info">Checkeada por: {{ $adicional->checkedBy->name }}</p>
                                <p class="alert alert-info">Hora: {{ $adicional->updated_at }}</p>
                            @else
                                <button wire:click="checkInAdicional({{ $adicional->id }})" class="btn btn-success">
                                    Marcar Check-in Adicional
                                </button>
                            @endif
                        <hr>
                        @endforeach
                    </div>
            @else
                    <h1 class="alert alert-info">No hay eventos en el dia de la fecha</h1>
            @endif
        </div>

        <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('qrScanner', () => ({
                html5QrcodeScanner: null,
                scanning: false,

                init() {
                    this.startScanner();
                },

                startScanner() {
                    this.html5QrcodeScanner = new Html5Qrcode("reader");
                    
                    const config = { 
                        fps: 10, 
                        qrbox: { width: 250, height: 250 } 
                    };

                    // Fuerza el uso de la cámara trasera
                    this.html5QrcodeScanner.start(
                        { facingMode: "environment" }, 
                        config, 
                        (decodedText, decodedResult) => {
                            // Evitar múltiples lecturas del mismo código en milisegundos
                            this.stopScanner();
                            
                            // Enviar el código escaneado al backend de Livewire
                            @this.validarTicket(decodedText);
                        },
                        (errorMessage) => {
                            // Errores de frame (opcional ignorar)
                        }
                    ).then(() => {
                        this.scanning = true;
                    }).catch(err => {
                        console.error("Error al iniciar cámara:", err);
                    });
                },

                stopScanner() {
                    if (this.html5QrcodeScanner && this.scanning) {
                        this.html5QrcodeScanner.stop().then(() => {
                            this.scanning = false;
                        });
                    }
                }
            }));
        });
        </script>
    @else
        <livewire:UnauthorizedPage/>
    @endcan
</div>
