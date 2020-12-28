
<div class="row mr-0">
    @push('pagetitle', 'Admin')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
        <h2>{{$subMenu}}</h2>

            <livewire:admin-student-class-table searchable="students.name, classes.tingkat, classes.name" hideable="select" editable deletable />
            @include('livewire.partials.modals.admin.create-studentclass')

             @include('livewire.partials.modals.admin.delete-studentclass')
            @include("livewire.partials.modals.admin.edit-studentclass")


        </div>
        <footer class="w-100">
            <livewire:partials.footer>
        </footer>
    </div>
</div>

