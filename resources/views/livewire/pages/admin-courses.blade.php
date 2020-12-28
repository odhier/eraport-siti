
<div class="row">
    @push('pagetitle', 'Admin')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
        <h2>{{$subMenu}}</h2>

            <livewire:admin-courses-table searchable="name, kode" hideable="select" editable deletable />
            @include('livewire.partials.modals.admin.create-course')
            @include("livewire.partials.modals.admin.edit-course")
            @include("livewire.partials.modals.admin.view-course")
            @include('livewire.partials.modals.admin.delete-course')
        </div>
        <footer class="w-100">
            <livewire:partials.footer>
        </footer>
    </div>
</div>

