<div>
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                </div>
                <form wire:submit="save">
                    <div class="modal-body">
                       <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Nombre: </label>
                                <input type="text" name="name" wire:model.blur="name"  class="form-control @error('name') is-invalid @enderror">
                                <div>
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="email">Correo Electrónico: </label>
                                <input type="text" name="email" wire:model.blur="email" class="form-control @error('email') is-invalid @enderror">
                                <div>
                                    @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Contraseña: </label>
                                <input type="password" name="password" id="password" wire:model="password" class="form-control @error('password') is-invalid @enderror">
                                <div>
                                    @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password_confirmation">Confirmar Contraseña: </label>
                                <input type="password" id="password_confirmation" name="password_confirmation" wire:model.blur="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror">
                                <div>
                                    @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
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
