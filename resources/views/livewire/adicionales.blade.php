<div>
    @can('adicionales_index')
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
        
        <form class="form-inline mx-6 margin-10">
            <div class="container text-center">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mx-2">ABM de Adicionales | Evento: {{ $evento->nombre }}</h2>
                    </div>
                    <div class="col-5 d-flex align-items-center">
                        <label for="nombre" class="mx-3">Nombre</label>
                        <input type="text" name="nombre" wire:model.live="nombre" class="form-control mx-3" @error('nombre') is-invalid @enderror">
                    </div>
                </div>
            </div>
        </form>
                
        <div class="table-responsive text-center">
                        
            <table class="table table-sm table-bordered table-hover">
                <caption>Listado de Adicionaless</caption>
                <thead class="thead-light">
                    <tr>
                        <th scope="col"> Cantidad </th>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> Precio </th>
                        <th scope="col"> Creador </th>
                        <th scope="col" colspan="2">
                            @can('adicionales_create')
                                <button wire:click="create"
                                    type="button"
                                    class="btn btn-primary">
                                    Agregar
                                </button>
                                <a href="/eventos" class="btn btn-secondary">
                                    Volver a Eventos
                                </a>
                            @else
                                Acciones
                            @endcan
                        </th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($adicionales as $adicional)
                        <tr class="">
                            <td>{{$adicional->cantidad}}</td>
                            <td  scope="row">{{$adicional->nombre}}</td>
                            <td  scope="row">{{$adicional->precio}}</td>
                            <td>{{App\Models\User::find($adicional->creador_id)->name}}</td>
                            <td>
                                @can('adicionales_edit')
                                    <button wire:click="edit({{ $adicional->id }})"
                                        class="margenAbajo btn btn-outline-secundary"
                                        title="Editar">
                                        <img src="{{url('app-icons/314724_document_edit_icon.svg')}}" alt="imagen de lapiz editor" height="20px">
                                    </button>
                                @else
                                        Sin Permisos Editar
                                @endcan
                                @can('adicionales_create')
                                    <button wire:click="delete({{ $adicional->id }})"
                                        wire:confirm="Eliminiras Adicional ¿Estás seguro?"
                                        title="Eliminar Evento"
                                        class="margenAbajo btn btn-outline-secundary">
                                        <img src="{{url('app-icons/trash_delete_bin_remove_icon.svg')}}" alt="delete basket" height="20px">
                                    </button>
                                @endcan
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $adicionales->links() }}

        <!-- Modals -->
        <section class="modal fade" id="addModal" tabindex="-1">
            <livewire:AdicionalesAddModal :evento_id="$evento->id" />
        </section>
        <section class="modal fade" id="editModal" tabindex="-1">
            <livewire:AdicionalesEditModal :adicional_id="$adicional_id" />
        </section>
    @else
            <livewire:UnauthorizedPage/>
    @endcan
</div>

@script
    <script>
        const myModalsAdd = new bootstrap.Modal('#addModal');
        const myModalsEdit = new bootstrap.Modal('#editModal');
        Livewire.on('cerrarModal', (datas) => {
            myModalsAdd.hide();
            myModalsEdit.hide();
        });
        Livewire.on('showAddModal', () => {
            myModalsAdd.show();
        });
        Livewire.on('showEditModal', () => {
            myModalsEdit.show();
        });
    </script>
@endscript
