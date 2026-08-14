<div>
    @can('eventos_index')
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
                        <h2 class="mx-2">Administración de Eventos</h2>
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
                <caption>Listado de Eventos</caption>
                <thead class="thead-light">
                    <tr>
                        <th scope="col"> Nombre </th>
                        <th scope="col"> Fecha </th>
                        <th scope="col"> Creador </th>
                        <th scope="col" colspan="2">
                            @can('eventos_create')
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
                    @foreach ($eventos as $evento)
                    <tr class="">
                        
                        <td  scope="row">{{$evento->nombre}}</td>
                        <td>{{\Carbon\Carbon::parse($evento->fecha)->format('D d/M/Y')}}</td>
                        <td>{{App\Models\User::find($evento->creador_id)->name}}</td>
                        <td>
                            @can('eventos_edit')
                                <button wire:click="edit({{ $evento->id }})"
                                    class="margenAbajo btn btn-outline-secundary"
                                    title="Editar">
                                    <img src="icons/314724_document_edit_icon.svg" alt="imagen de lapiz editor" height="20px">
                                </button>
                            @else
                                    Sin Permisos Editar
                            @endcan
                            @can('eventos_create')
                                <button wire:click="delete({{ $evento->id }})"
                                    wire:confirm="Eliminiras Reservas y Adicionales relacionado con el Evento ¿Estás seguro?"
                                    title="Eliminar Evento"
                                    class="margenAbajo btn btn-outline-secundary">
                                    <img src="icons/trash_delete_bin_remove_icon.svg" alt="delete basket" height="20px">
                                </button>
                            @endcan
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $eventos->links() }}

        <!-- Modals -->
        <section class="modal fade" id="addModal" tabindex="-1">
            @livewire( EventosAddModal::Class )
        </section>
        <section class="modal fade" id="editModal" tabindex="-1">
            <livewire:EventosEditModal :evento_id="$evento_id" />
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
