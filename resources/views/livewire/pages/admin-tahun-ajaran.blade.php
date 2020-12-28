
<div class="row">
    @push('pagetitle', 'Admin')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
        <h2>{{$subMenu}}</h2>

            <livewire:admin-tahun-ajaran-table searchable="tahun_ajaran" hideable="select" editable deletable />
            @include('livewire.partials.modals.admin.create-tahun-ajaran')
            @include('livewire.partials.modals.admin.delete-tahun-ajaran')
            @include("livewire.partials.modals.admin.view-tahun-ajaran")
            @include("livewire.partials.modals.admin.edit-tahun-ajaran")


        </div>
        <footer class="w-100">
            <livewire:partials.footer>
        </footer>
    </div>
</div>

