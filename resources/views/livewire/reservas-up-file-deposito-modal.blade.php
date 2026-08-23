<div>
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cargando Comprobante...</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                </div>
                <form wire:submit="update">
                    <div class="modal-body">
                       <div class="form-row">
                            <div class="form-group col-md-12 p-1">
                                <label for="archivo">Subir: </label>
                                @if (isset($reserva->ruta_comprobante) && $reserva->ruta_comprobante)
                                    <p>Comprobante ya fue cargado. Muchas Gracias!</p>
                                @else
                                    @if ($reserva)
                                        <label for="archivo" class="form-label">Adjuntar Archivo</label>
                                        <input type="file" id="archivo" class="form-control @error('archivo') is-invalid @enderror" wire:model="archivo">
                                        
                                        <!-- Indicador de carga de Livewire -->
                                        <div wire:loading wire:target="archivo" class="form-text text-info mt-1">
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Cargando archivo...
                                        </div>

                                        @error('archivo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
</div>