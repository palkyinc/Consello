<div>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Adicional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
            </div>
            <form wire:submit="update">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="cantidad">Cantidad: </label>
                            <input type="text" name="cantidad" wire:model.blur="cantidad"  class="form-control @error('cantidad') is-invalid @enderror">
                            <div>
                                @error('cantidad') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre">Nombre: </label>
                            <input type="text" name="nombre" wire:model.blur="nombre"  class="form-control @error('nombre') is-invalid @enderror">
                            <div>
                                @error('nombre') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="precio">Precio: </label>
                            <input type="text" name="precio" wire:model.blur="precio"  class="form-control @error('precio') is-invalid @enderror">
                            <div>
                                @error('precio') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
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
