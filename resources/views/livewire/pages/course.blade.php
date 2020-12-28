
<div class="row">
    @push('pagetitle', 'Admin')
    <div class="col-2 sub-menu">
        <livewire:partials.menu :post="$menu">
    </div>
    <div class="col-10 main-content position-relative">
        <div class="container">
            @if(empty($course))
                @if($course_code == null)
                    <h2>{{__('Silahkan Pilih Mata Pelajaran')}}</h2>
                @else
                    <h2>Mohon maaf mata pelajaran tidak ditemukan</h2><small>Silahkan hubungi admin </small>
                @endif
            @else
            <h2>{{strtoupper($course['course']['name'])}}</h2>
            {{$class_name}}
            {{($tahun)?$tahun->tahun_ajaran:""}}
            @livewire('course-table', ['kode' => $course['course']['kode'],'class' => $class, 'tahun' => $tahun, 'selected_semester' => $selected_semester])

            @include("livewire.partials.modals.admin.edit-nilai")

        </div>
        @endif
        <footer class="w-100">
            <livewire:partials.footer>
        </footer>
    </div>
</div>


