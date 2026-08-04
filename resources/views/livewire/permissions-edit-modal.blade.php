<div>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModal">Agregar/quitar roles a: <strong>{{ $permission->name ?? ''}}</strong> </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
            </div>
            <form wire:submit="update">
                <div class="modal-body">
                {{--  --}}    
                    <table class="table table-sm table-bordered table-hover">
                        <caption>Permiso: <strong>{{ $permission->name ?? ''}}</strong></caption>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"> Nombre </th>
                                <th scope="col"> Seleccionado </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>
                                        <input type="checkbox" value="{{$role->name}}" wire:model="checkboxes">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>        
                    {{--  --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </form>
        </div>
    
</div>
