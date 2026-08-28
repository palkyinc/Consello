<div>
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
    <div class="container">
        @foreach ($eventos as $evento)
            <div class="row justify-content-center m-5">
                <div class="card" style="width: 30rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{$evento->nombre}}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $evento->fecha->translatedFormat('D d/M/Y') }}</h6>
                        <h6 class="card-subtitle mb-2 text-muted">Precio: ${{$evento->precio}} por persona.</h6>
                        <h6 class="card-subtitle mb-2 text-muted">{{(count($evento->reservas) >= $evento->aforo) ? 'Entradas AGOTADAS' : 'Entradas Disponibles.'}}</h6>
                        <p class="card-text border p-2">{!! nl2br(e($evento->descripcion)) !!}</p>
                        @if ((count($evento->reservas) >= $evento->aforo))
                            <p class="card-subtitle mb-2 text-muted">
                                {{$evento->reservasSinPagar() > 0 ? 'Hay reservas sin CONFIRMAR regresá en 2hs.' : 'Nos vemos en la proxima.'}}
                            </p>
                        @else
                            <button wire:click="addReserva({{ $evento->id }})"
                                class="margenAbajo btn btn-outline-secundary"
                                title="Reservar">
                                RESERVAR
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Modals -->
    <section class="modal fade" id="addModal" tabindex="-1">
        <livewire:ClientesAddReservaModal :evento_id="$evento_id" />
    </section>
</div>

@script
    <script>
        const myModalsAdd = new bootstrap.Modal('#addModal');
        Livewire.on('cerrarModal', (datas) => {
            myModalsAdd.hide();
        });
        Livewire.on('showAddModal', () => {
            myModalsAdd.show();
        });
    </script>
@endscript
