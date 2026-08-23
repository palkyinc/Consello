<div>
    <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                </div>
                <form wire:submit="update">
                    <div class="modal-body">
                           <div class="container">
                                <div class="row justify-content-center m-5">
                                    <div class="card" style="width: 30rem;">
                                        <div class="card-body">
                                            <h5 class="card-title">Datos Deposito Bancario</h5>
                                            <p class="card-text border p-2">{!! nl2br(e($descripcion_transf)) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="closeModal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
</div>