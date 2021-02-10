
<div class="row">
    @push('pagetitle', 'Admin Teacher')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
        <h2>{{$subMenu}}</h2>

            <livewire:admin-teacher-course-table searchable="users.name, classes.tingkat, classes.name, courses.name" hideable="select" editable deletable />
            @include('livewire.partials.modals.admin.create-teachercourse')

             @include('livewire.partials.modals.admin.delete-teachercourse')
            @include("livewire.partials.modals.admin.edit-teachercourse")


        </div>
        <footer class="w-100 position-relative row">
            <livewire:partials.footer>
        </footer>
    </div>
</div>

