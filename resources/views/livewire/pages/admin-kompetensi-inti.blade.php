
<div class="row">
    @push('pagetitle', 'Admin Teacher')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
            <h2>{{$subMenu}}</h2>

            <livewire:admin-kompetensi-inti-table searchable="name,kode" hideable="select" editable deletable />
            @include('livewire.partials.modals.admin.create-kompetensi-inti')

            @include("livewire.partials.modals.admin.edit-kompetensi-inti")
            @include("livewire.partials.modals.admin.delete-kompetensi-inti")



        </div>
        <footer class="w-100">
            <livewire:partials.footer>
        </footer>
    </div>


</div>

