<div class="container">
    @push('pagetitle', 'Dashboard')
    <div class="row">
        <div class="col-6">
            <livewire:datatable model="App\Models\Student"  include="id, name, nisn" searchable="name"/>
        </div>

    </div>



</div>

