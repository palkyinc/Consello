<div>
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Argegar/Quitar Permisos a Rol: {{$role_id}}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal" aria-label="Close"></button>
        </div>
        <form wire:submit="update">
            <div class="modal-body">
            {{--  --}}    
                <div class="alert bg-body-tertiary border col-8 mx-auto p-4">
                    <table class="table table-sm table-bordered table-hover">
                        <caption>Cantidad de permisos: {{count($permissions)}}</caption>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"> Nombre </th>
                                <th scope="col"> Seleccionado </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{$permission->name}}</td>
                                    <td>
                                        <input type="checkbox" value="{{$permission->name}}" wire:model="checkboxes">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            {{--  --}}            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  wire:click="closeModal" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        </div>
    </div>
</div>
