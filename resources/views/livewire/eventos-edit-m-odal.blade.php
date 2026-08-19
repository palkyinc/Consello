<div>
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                </div>
                <form wire:submit="update">
                    <div class="modal-body">
                       <div class="form-row">
                            <div class="form-group col-md-12 p-1">
                                <label for="name">Nombre: </label>
                                <input type="text" name="nombre" wire:model.blur="nombre"  class="form-control @error('nombre') is-invalid @enderror">
                                <div>
                                    @error('nombre') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 p-1">
                                <label for="fecha">Fecha: </label>
                                <input  type="date" 
                                        name="fecha"
                                        wire:model.blur="fecha"
                                        value="{{ $fecha ? \Carbon\Carbon::parse($fecha)->format('Y-m-d') : '' }}"
                                        class="form-control @error('fecha') is-invalid @enderror">
                                <div>
                                    @error('fecha') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 p-1">
                                <label for="precio">Precio: </label>
                                <input type="text" name="precio" wire:model.blur="precio"  class="form-control @error('precio') is-invalid @enderror">
                                <div>
                                    @error('precio') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6 p-1">
                                <label for="aforo">Aforo: </label>
                                <input type="text" name="aforo" wire:model.blur="aforo"  class="form-control @error('aforo') is-invalid @enderror">
                                <div>
                                    @error('aforo') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-12 p-1">
                                <label for="descripcion">Descripción: </label>
                                <textarea name="descripcion" id="" rows="10" wire:model.blur="descripcion" class="form-control @error('descripcion') is-invalid @enderror"></textarea>
                                <div>
                                    @error('descripcion') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-12 p-1">
                                <label for="descripcion_transf">Descripción de la Transferencia: </label>
                                <textarea name="descripcion_transf" id="" rows="10" wire:model.blur="descripcion_transf" class="form-control @error('descripcion_transf') is-invalid @enderror"></textarea>
                                <div>
                                    @error('descripcion_transf') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-12 p-1">
                                <label for="archivo">Flyer: </label>
                                @if ($evento && $evento->ruta_archivo)
                                    <p>Archivo actual: <a href="{{ asset('storage/' . $evento->ruta_archivo) }}" target="_blank">Ver archivo</a></p>
                                    <button 
                                        type="button"
                                        class="btn btn-danger"
                                        wire:click="deleteFile"
                                        wire:confirm="¿Estás seguro de que quieres borrar el archivo?"
                                        >
                                        Borrar Archivo</button>
                                @else
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
                            </div>
                            <div class="form-group col-md-6 p-2">
                                <input type="checkbox" 
                                    id="activo" 
                                    class="form-check-input" 
                                    wire:model="activo">
                                <label class="form-check-label fw-bold" for="activo">
                                    Evento Activo
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Modificar</button>
                    </div>
                </form>
            </div>
        </div>
</div>