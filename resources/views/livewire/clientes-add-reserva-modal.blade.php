<div>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reserva de Entradas para: </h5>
                <h3 class="modal-title"> {{$evento->nombre ?? ''}}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
            </div>
            <form wire:submit="save">
                <div class="modal-body">
                    <div class="form-row g-3 d-flex align-items-center justify-content-center">
                        <div class="form-group col-md-4 d-flex align-items-center justify-content-center">
                            <label for="cant_entradas">Entradas:</label>
                        </div>
                        <div class="col-md-2">
                            <input  type="number" 
                                    name="cant_entradas"
                                    id="cant_entradas"
                                    wire:model.live="cant_entradas"
                                    class="form-control"
                                    min="1">
                            <div>
                                @error('cant_entradas') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- MENSAJES --}}
                        </div>
                    </div>
                    @foreach ($adicionales as $adi)
                    <div class="form-row g-3 d-flex align-items-center justify-content-center mt-3">
                        <div class="form-group col-md-4 d-flex align-items-center justify-content-center">
                            <label for="">{{$adi->nombre}}</label>
                        </div>
                        <div class="form-group col-md-2">
                            @if ($adi->precio === 0)
                                <label for="">{{$adi->cantidad}}</label>
                            @else
                                <input  type="number" 
                                        name="seleccion_adicionales.{{$adi->id}}"
                                        id="cant_entradas"
                                        wire:model.live="seleccion_adicionales.{{$adi->id}}"
                                        class="form-control text-center @error('seleccion_adicionales.' . $adi->id) is-invalid @enderror"
                                        min="0" 
                                        max="10">
                                        <div>
                                            @error('seleccion_adicionales.' .$adi->id)
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                            @endif
                        </div>
                        <div class="form-group col-md-6 d-flex aƒlign-items-center justify-content-center">
                            @if ($adi->precio === 0)
                                <p class="form-text">
                                    INCLUIDO
                                </p>
                            @else
                                    <span class="fs-5 fw-bolder">
                                        x Entrada | ${{ number_format($adi->precio, 2, ',', '.') }}
                                    </span>
                            @endif
                        </div>
                    </div>    
                    @endforeach
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <p class="form-text p-4">Total a Pagar:
                            <span class="fs-4 fw-bolder text-danger">
                                ${{ number_format($this->calculoTotal(false), 2, ',', '.') }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="modal-body">
                    <p>{{$this->calculoTotal(true)}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Reservar</button>
                </div>
            </form>
        </div>
    </div>
</div>
