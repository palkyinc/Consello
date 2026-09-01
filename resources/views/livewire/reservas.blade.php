<div>
    @can('reservas_index')
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
        <div class="form-inline mx-6 margin-10">
            <div class="container text-center">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mx-2">Mis Reservas</h2>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($reservas as $reserva)
            @if (!$reserva->reserva_main_id)
                <hr class="border-4 border-danger">
            @else
                <hr class="border-4 border-alert">
            @endif
            <h5>Reserva ID: {{$reserva->id}}</h5>
            <p>Fecha: {{$reserva->created_at}}</p>
            <p>Entrada para: {{$reserva->evento->nombre}}</p>
            <p>Pagada: {{$reserva->pagada ? 'SI' : 'NO'}}</p>
            <p>Usada: {{$reserva->usada ? 'SI' : 'NO'}}</p>
            <p>Asignada:
                        @if ($reserva->creador_id === Auth()->User()->id)
                            @if ($reserva->cliente_id)
                                {{$reserva->cliente->name . ' (' . $reserva->cliente->email . ')' }}
                                <button wire:click="asignarAsistente({{$reserva->id}})"
                                        class="margenAbajo btn btn-info"
                                        title="Reasignar Entrada">
                                    Reasignar
                                </button>
                            @else
                                @if ($reserva->pagada)
                                    <button wire:click="asignarAsistente({{$reserva->id}})"
                                            class="margenAbajo btn btn-warning"
                                            title="Asignar Entrada">
                                        Asignar
                                    </button>
                                @else
                                    NO
                                @endif
                            @endif
                        @else
                                    {{$reserva->cliente_id === Auth()->User()->id ? $reserva->cliente->name . ' (' . $reserva->cliente->email . ')' : 'ERROR'}}
                        @endif    
            </p>
            @if (!$reserva->reserva_main_id)
                <p class="py-2">
                    @if ($reserva->ruta_comprobante)
                        @if ($reserva->pagada)
                            <strong class="alert alert-success">Comprobante Revisado</strong>
                        @else
                            <strong class="alert alert-warning">Comprobante en Revisión</strong>
                        @endif
                    @else
                        <button wire:click="upFileDeposito({{ $reserva->id }})"
                                title="Subir archivo deposito"
                                class="margenAbajo btn btn-secondary"">
                            CARGAR COMPROBANTE
                        </button>
                        <button class="btn btn-warning""
                                wire:click="cbuAlias({{ $reserva->evento->id }})"
                                title="Ver datos deposito">
                            CBU ALIAS
                        </button>
                    @endif
                </p>
                <p>
                    Total: ${{ number_format($reserva->tot_pagado, 2, ',', '.') }}
                </p>
            @endif
            <hr>
            <table class="table table-sm table-bordered table-hover aling-center">
                <thead class="thead-light aling-center">
                    <th class="text-center">Adicional</th>
                    <th class="text-center">Usado</th>
                    <th class="text-center">Check por</th>
                    <th class="text-center">Hora check</th>
                </thead>
                <tbody>
                    @foreach ($reserva->adicionales_cache as $item)
                        <tr>
                            <td class="text-center" scope="row">{{$item->adicional->nombre}}</td>
                            <td class="text-center">{{$item->usada ? 'SI' : 'NO'}}</td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
        <!-- Modals -->
        <section class="modal fade" id="cbuAliasModal" tabindex="-1">
            <livewire:ReservasCbuAliasModal :evento_id="$evento_id" />
        </section>
        <section class="modal fade" id="editModal" tabindex="-1">
            <livewire:ReservasUpFileDepositoModal :reserva_id="$reserva_id" />
        </section>
        <section class="modal fade" id="asignarModal" tabindex="-1">
            <livewire:ReservasAsingGuest :reserva_id="$reserva_id" />
        </section>
    @else
            <livewire:UnauthorizedPage/>     
    @endcan
</div>
@script
    <script>
        const myModalsCbuAlias = new bootstrap.Modal('#cbuAliasModal');
        const myModalsAsignar = new bootstrap.Modal('#asignarModal');
        const myModalsEdit = new bootstrap.Modal('#editModal');
        Livewire.on('cerrarModal', (datas) => {
            myModalsCbuAlias.hide();
            myModalsEdit.hide();
            myModalsAsignar.hide();
        });
        Livewire.on('showcbuAliasModal', () => {
            myModalsCbuAlias.show();
        });
        Livewire.on('showEditModal', () => {
            myModalsEdit.show();
        });
        Livewire.on('showAsignarModal', () => {
            myModalsAsignar.show();
        });
    </script>
@endscript

