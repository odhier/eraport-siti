
<div class="row">
    @push('pagetitle', 'Admin')
    <div class="col-2 sub-menu">
        {{-- <livewire:partials.menu-class :post="$menu"> --}}
        @livewire('partials.menu-class', ['menu' => $menu, 'tahun_id' => $tahun_id])
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">


        @if(empty($class_detail))
                @if(!$class_id)
                    <h2>{{__('Silahkan Pilih Kelas')}}</h2>
                @else
                    <h2>{{__('Mohon maaf Kelas tidak ditemukan')}}</h2><span>Silahkan hubungi admin</span>
                @endif
            @else
            @if(($class_detail->teacher_id != Auth::user()->id) && (Auth::user()->role_id == 3))
            <h2>{{__('Mohon maaf Kelas tidak ditemukan')}}</h2><span>Silahkan hubungi admin</span>
        @else
            <h2>{{strtoupper($class_detail->class->tingkat)}} - {{strtoupper($class_detail->class->name)}}</h2>
            {{$class_detail->tahun_ajaran->tahun_ajaran}}
            @livewire('class-table', ['class' => $class_detail])

            @include("livewire.partials.modals.admin.edit-nilai-ki")
            @include("livewire.partials.modals.admin.edit-nilai-absensi")

        @endif
        @endif
        </div>
        <footer class="w-100 position-relative row">
            <livewire:partials.footer>
        </footer>
    </div>
</div>


