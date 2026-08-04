<div>
    {{-- Edit Modal --}}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModal">Editando Usuario ID: {{$user->id ?? ''}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal" aria-label="Close"></button>
            </div>
            <form wire:submit="update">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6 p-2">
                            <label for="name">Nombre: </label>
                            <input type="text" wire:model.blur="name" maxlength="255"  class="form-control @error('name') is-invalid @enderror">
                            <div>
                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="form-group col-md-8 p-2">
                            <label for="email">Correo Electrónico: </label>
                            <input type="email" wire:model.blur="email" class="form-control @error('email') is-invalid @enderror">
                            <div>
                                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
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
