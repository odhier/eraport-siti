
<div class="row">
    @push('pagetitle', 'Admin')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
        <h2>{{$subMenu}}</h2>

            <livewire:admin-students-table searchable="name, nisn, nis" editable deletable />
            @include("livewire.partials.modals.admin.import-students")
            @include('livewire.partials.modals.admin.create-student')
            @include("livewire.partials.modals.admin.edit-student")
            @include("livewire.partials.modals.admin.view-student")
            @include('livewire.partials.modals.admin.delete-student')
        </div>
        <footer class="w-100">
            <livewire:partials.footer>
        </footer>
    </div>
</div>

