<div>
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Comprobante para revisar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>ID:{{$reserva_id ?? ''}}</p>
            <p>Comprador: {{$comprador}}</p>
            <p>Total: ${{$reserva->tot_pagado ?? ''}}</p>
            <p>Comprobante:
                <a href="{{ asset('storage/' . ($reserva->ruta_comprobante ?? '')) }}" target="_blank">Ver archivo</a>
            </p>
            <hr>
            <p>Reservas: {{$cantidadReservadas ?? ''}}</p>
            <h5><strong>Listar adicionales</strong></h5>
            @foreach ($adicionales_listado as $key => $item)
                <p>{{$key}} : {{$item}}</p>
            @endforeach
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" wire:click="closeModal">Cerrar</button>
            <button type="button" class="btn btn-primary" wire:click="aprobar">Aprobar</button>
        </div>
        </div>
    </div>
</div>
