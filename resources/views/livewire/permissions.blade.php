<div>
    @can('permissions_index')
        <!-- Flash Messages -->
        @if (session('status'))
            @foreach (session('status') as $key => $messages)
                @foreach ($messages as $message)
                    <div class="alert alert-{{$key}} alert-dismissible fade show" role="alert">
                        <p><strong>{{ $message }}</strong></p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endforeach
        @endif
        <!-- Searching box -->
        <form class="form-inline mx-6 margin-10">
            <div class="container text-center">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mx-2">Administración de Permisos</h2>
                    </div>
                    <div class="col-5 d-flex align-items-center">
                        <label for="nombre" class="mx-3">Buscar por nombre:</label>
                        <input type="text" name="nombre" class="form-control mx-3" wire:model.live="nombre" >
                    </div>
                    <div class="col">
                    </div>
                </div>
            </div>
        </form>
        <!-- Table data -->
        <div class="table-responsive text-center">
            <table class="table table-sm table-bordered table-hover">
                <caption>Listado de Permisos</caption>
                <thead class="thead-light">
                    <tr>
                        <th scope="col"> Id </th>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> Creado </th>
                        <th scope="col" colspan="2">
                            @can('permissions_create')
                                <button type="button" class="btn btn-primary" wire:click="factoryPermissions">
                                    Factory
                                </button>
                            @else
                                Acciones
                            @endcan
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            
                        <th scope="row"> {{$permission->id}}</th>
                        <td>{{$permission->name}}</td>
                        <td>{{$permission->created_at}}</td>
                        <td>
                            @can('permissions_edit')
                            {{-- <a href="/modificarpermission/{{ $permission->id }}" class="margenAbajo btn" title="Editar">
                                <img src="icons/314724_document_edit_icon.svg" alt="imagen de lapiz editor" height="20px" class="">
                            </a> --}}
                            <Button wire:click="editPermissionsToRole({{ $permission->id }})" class="margenAbajo btn" title="Agregar/Quitar a Rol">
                                <img src="icons/9161347_log_out_input_access_security_icon.svg" alt="imagen de Cambio de Roles" height="20px">
                            </Button>
                            @else
                                Sin Permisos
                            @endcan
                        </td>
                        
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $permissions->links() }}
        </div>

        <!-- Modals -->
        <section class="modal fade" id="editModal" tabindex="-1">
            <livewire:PermissionsEditModal :permission_id="$permission_id" />
        </section>

    @else
            <livewire:UnauthorizedPage/>
    @endcan
</div>

@script
    <script>
        const myModalsEdit = new bootstrap.Modal('#editModal');
            Livewire.on('cerrarModal', (datas) => {
                myModalsEdit.hide();
            });
            Livewire.on('showEditModal', () => {
                myModalsEdit.show();
            });
    </script>
@endscript