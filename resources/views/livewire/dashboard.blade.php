<div>
    @can('permissions_index')
        <h1> Dashboard. </h1>
    @else
            <livewire:UnauthorizedPage/>
    @endcan
</div>
