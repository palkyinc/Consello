<div>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Asignando Asistente...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
            </div>
            <form wire:submit="update">
                <div class="modal-body">
                    @if (!$estaRegistrado)
                        <div class="form-row">
                            <div class="form-group col-md-12 p-1">
                                <label for="name">Nombre y Apellido: </label>
                                <input type="name" name="name" wire:model.blur="name"  class="form-control @error('name') is-invalid @enderror">
                                <div>
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="form-group col-md-12 p-1">
                            <label for="email">Email: </label>
                            <input type="email" name="email" wire:model.blur="email"  class="form-control @error('email') is-invalid @enderror">
                            <div>
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
