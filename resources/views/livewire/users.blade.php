<div>
    @can('users_index')
        @if (session('errors'))
                @foreach (session('errors') as $messages)
                    @foreach ($messages as $message)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <p><strong>{{ $message }}</strong></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endforeach
            @endif
            @if (session('warnings'))
                @foreach (session('warnings') as $messages)
                    @foreach ($messages as $message)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <p><strong>{{ $message }}</strong></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endforeach
            @endif
            @if (session('success'))
                @foreach (session('success') as $messages)
                    @foreach ($messages as $message)
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <p><strong>{{ $message }}</strong></p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endforeach
            @endif
        
        <form class="form-inline mx-6 margin-10">
            <div class="container text-center">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mx-2">Administración de Usuarios</h2>
                    </div>
                    <div class="col-5 d-flex align-items-center">
                        <label for="nombre" class="mx-3">Email</label>
                        <input type="text" name="email" wire:model.live="email" class="form-control mx-3" @error('email') is-invalid @enderror">
                    </div>
                </div>
            </div>
        </form>
                
        <div class="table-responsive text-center">
                        
            <table class="table table-sm table-bordered table-hover">
                <caption>Listado de Usuarios</caption>
                <thead class="thead-light">
                    <tr>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> Email </th>
                        <th scope="col"> Email Verificado</th>
                        <th scope="col"> Rol </th>
                        <th scope="col"> Creado </th>
                        <th scope="col" colspan="2">
                            @can('users_create')
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                    Agregar
                                </button>
                            @else
                                Acciones
                            @endcan
                        </th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($users as $User)
                    <tr class="{{ $User->disabled ? 'table-danger' : '' }}">
                        
                        <td  scope="row">{{$User->name}}</td>
                        <td>{{$User->email}}</td>
                        <td>{{$User->email_verified_at}}</td>
                        <td>
                            @foreach ($User->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </td>
                        <td>{{$User->created_at}}</td>
                        <td>
                            @can('users_edit')
                                <button wire:click="edit({{ $User->id }})"
                                    class="margenAbajo btn btn-outline-secundary"
                                    title="Editar">
                                    <img src="icons/314724_document_edit_icon.svg" alt="imagen de lapiz editor" height="20px">
                                </button>
                                <button wire:click="editRolToUser({{ $User->id }})"
                                    class="margenAbajo btn btn-outline-secundary"
                                    title="Editar Roles">
                                    <img src="icons/9161347_log_out_input_access_security_icon.svg" alt="imagen de Cambio de Roles" height="20px">
                                </button>
                                @if ($User->disabled)
                                    <button wire:click="enable({{ $User->id }})" 
                                            wire:confirm="¿Está seguro que Habilita ests usuario?"
                                            class="margenAbajo btn btn-outline-secundary" 
                                            title="Habilitar">
                                        <img src="icons/accept_approve_check_green_ok_icon.svg" alt="enable icon" height="20px">
                                    </button>
                                @else
                                    <button wire:click="disable({{ $User->id }})"
                                            wire:confirm="¿Está seguro que Deshabilita ests usuario?"
                                            class="margenAbajo btn btn-outline-secundary"
                                            title="Deshabilitar">
                                        <img src="icons/cross_delete_remove_cancel_icon.svg" alt="delete basket" height="20px">
                                    </button>
                                @endif
                            @else
                                    Sin Permisos
                            @endcan
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->links() }}

        <!-- Modals -->
        <section class="modal fade" id="addModal" tabindex="-1">
            @livewire( UserAddModal::Class )
        </section>
        <section class="modal fade" id="editModal" tabindex="-1">
            <livewire:UserEditModal :user_id="$user_id" />
        </section>
        <section class="modal fade" id="editRolToUserModal" tabindex="-1">
            <livewire:UserEditRolToUserModal :user_id="$user_id" />
        </section>
    @else
            <livewire:UnauthorizedPage/>
    @endcan
</div>

@script
    <script>
        const myModalsAdd = new bootstrap.Modal('#addModal');
        const myModalsEdit = new bootstrap.Modal('#editModal');
        const myModalsEditRolToUser = new bootstrap.Modal('#editRolToUserModal');
        Livewire.on('cerrarModal', (datas) => {
            myModalsAdd.hide();
            myModalsEdit.hide();
            myModalsEditRolToUser.hide();
        });
        Livewire.on('showAddModal', () => {
            myModalsAdd.show();
        });
        Livewire.on('showEditModal', () => {
            myModalsEdit.show();
        });
        Livewire.on('showEditRolToUserModal', () => {
            myModalsEditRolToUser.show();
        });
    </script>
@endscript