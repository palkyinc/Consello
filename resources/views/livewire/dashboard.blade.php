<div>
    @can('permissions_index')
        <div class="container-fluid pt-5 mt-2 pb-4 px-4 d-flex flex-column">
            
            <!-- Fila Superior -->
            <div class="row g-3 mb-3 row-quadrant">
                <div class="col-12 col-md-6 quadrant-col">
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
                                <td>${{$evento->precio ?? ''}}</td>
                            </tr>
                            <tr>
                                <th>Fecha</th>
                                <td>{{$evento->fecha ?? ''}}</td>
                            </tr>
                            <tr>
                                <th>Creador</th>
                                <td>{{$evento->creador->name ?? ''}}</td>
                            </tr>
                            <tr>
                                <th>Recaudado</th>
                                <td>{{$recaudado ?? ''}}</td>
                            </tr>
                        </tbody>
                    </table>
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
                                @foreach ($reservas as $conCompro)
                                    @if ($conCompro->ruta_comprobante && !$conCompro->reserva_main_id)
                                        <tr>
                                            <th>{{$conCompro->creador->name}}</th>
                                            <td>Link</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    @else
        <livewire:UnauthorizedPage />
    @endcan

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