
<div class="row">
    @push('pagetitle', 'Admin')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
        <h2>{{$subMenu}}</h2>

            <livewire:admin-classes-table searchable="name, tingkat" hideable="select" editable deletable />
            @include('livewire.partials.modals.admin.create-class')
            @include('livewire.partials.modals.admin.delete-class')
            @include("livewire.partials.modals.admin.view-class")
            @include("livewire.partials.modals.admin.edit-class")


        </div>
        <footer class="w-100">
            <livewire:partials.footer>
        </footer>
    </div>
</div>

