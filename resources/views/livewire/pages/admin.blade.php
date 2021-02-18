
<div class="row">
    @push('pagetitle', 'Admin')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">


        <h2>{{$subMenu}}</h2>

             {{-- <livewire:datatable model="App\Models\User" exclude="created_at, updated_at, picture, user_type" searchable="name"/>
            --}}
            <livewire:users-table searchable="users.name, email" hideable="select" editable />

            @include("livewire.partials.modals.create-user" , ['subMenu' => $subMenu])
            @include("livewire.partials.modals.edit-user" , ['subMenu' => $subMenu])
            @include("livewire.partials.modals.view-user" , ['subMenu' => $subMenu])
            @include("livewire.partials.modals.edit-paraf" , ['subMenu' => $subMenu])
            @include('livewire.partials.modals.delete-user')
        </div>
        <footer class="w-100 position-relative row">
            <livewire:partials.footer>
        </footer>
    </div>
</div>


