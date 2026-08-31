<div>
    <div class="container-fluid px-4 d-flex flex-column">
        @can('dashboard_index')
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
            
            <!-- Fila Superior -->
            <div class="row g-3 mb-3 row-quadrant">
                <div class="col-12 col-md-6 quadrant-col">
                    <div class="card h-100 shadow-sm p-3">
                        <h5 class="card-title">Evento</h5>
                        <select class="form-select" aria-label="Default select example" wire:model.live="evento_id">
                            @foreach ($eventos as $item)
                                    <option value="{{$item->id}}">{{$item->nombre}}</option>
                            @endforeach
                        </select>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Dato</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Aforo</th>
                                    <td>{{$evento->aforo ?? ''}} personas</td>
                                </tr>
                                <tr>
                                    <th>Precio</th>
                                    <td>${{number_format($evento->precio ?? 0, 2)}}</td>
                                </tr>
                                <tr>
                                    <th>Creador</th>
                                    <td>{{$evento->creador->name ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th>Recaudado</th>
                                    <td>${{$this->getRecaudacion() ?? 'N/A'}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 col-md-6 quadrant-col">
                    <div class="card h-100 shadow-sm p-3">
                        <h5 class="card-title">Reservas</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Dato</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Reservas</th>
                                    <td>{{count($reservas) ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th>Sin Comprobante</th>
                                    <td>{{$sinComprobante ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th>Pagadas</th>
                                    <td>{{$pagadas ?? ''}}</td>
                                </tr>
                                <tr>
                                    <th>Sin Asignar</th>
                                    <td>{{$asignadas ?? ''}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Fila Inferior -->
            <div class="row g-3 row-quadrant">
                <div class="col-12 col-md-6 quadrant-col">
                    <div class="card h-100 shadow-sm p-3">
                        <h5 class="card-title">Resumen de adicionales</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Dato</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adicionales as $adicional)
                                    <tr>
                                        <th>{{$adicional->nombre}}</th>
                                        <td>{{count($adicional->adicional_cache)}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 col-md-6 quadrant-col">
                    <div class="card h-100 shadow-sm p-3">
                        <h5 class="card-title">Comprobantes para revisa</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Revisar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservas as $con_compro)
                                    @if ($con_compro->ruta_comprobante && !$con_compro->reserva_main_id && !$con_compro->pagada)
                                        <tr>
                                            <th>{{$con_compro->creador->name}}</th>
                                            <td>
                                            @can('dashboard_edit')
                                                    <button wire:click="reservaParaConfirmar({{ $con_compro->id }})"
                                                        class="margenAbajo btn btn-outline-danger"
                                                        title="Revisar">
                                                        Revisar
                                                    </button>
                                                @else    
                                                    Compro. para confirmar
                                                @endcan
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Modals -->
            <section class="modal fade" id="editModal" tabindex="-1">
                <livewire:DashboardConfirmTransfModal :reserva_id="$reserva_id" />
            </section>
        @else
            <livewire:UnauthorizedPage />
        @endcan
    </div>

    <style>
        /* Escritorio: Distribución 2x2 cubriendo la altura de la pantalla */
        @media (min-width: 768px) {
            .row-quadrant {
                height: calc(45vh - 50px);
            }
            .quadrant-col {
                height: 100%;
            }
        }

        /* Móvil / Colapsado: 1 sola columna con alto parejo por cuadrante */
        @media (max-width: 767.98px) {
            .row-quadrant {
                height: auto;
            }
            .quadrant-col {
                min-height: 22vh; /* Ajusta la altura proporcional idéntica para cada card */
            }
        }
    </style>
</div>

@script
    <script>
        const myModalsEdit = new bootstrap.Modal('#editModal');
        Livewire.on('cerrarModal', (datas) => {
            myModalsEdit.hide();
        });
        Livewire.on('showEditModal', () => {
            myModalsEdit.show();
        });
    </script>
@endscript
