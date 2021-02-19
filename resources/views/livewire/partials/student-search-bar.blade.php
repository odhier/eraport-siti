<div class="relative" id="student-field">
    <div class="form-group">
        <label for="InputSiswa">Siswa<span class="text-danger">*</span></label>

    <input
        placeholder="Cari Siswa..."
        wire:model="query"
        wire:keydown.escape="_reset"
        wire:keydown.tab="tabPressed"
        wire:keydown.arrow-up="decrementHighlight"
        wire:keydown.arrow-down="incrementHighlight"
        wire:keydown.enter="selectContact"
        wire:keydown.backspace="resetHighlight"
        type="name" class="form-control" id="InputSiswa"
    />


    @if(!empty($query))
        <div class="fixed top-0 right-0 bottom-0 left-0 blocker qw-student" wire:click="_reset"></div>

        <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg p-3 result-student-search qw-student">
            @if(!empty($students))
                @foreach($students as $i => $student)
                    <a wire:click="selectContact({{$i}})"
                        class="list-item {{ $highlightIndex === $i ? 'highlight' : '' }}"
                    >{{ $student['name'] }}</a>
                @endforeach
            @else
                <div class="list-item">No results!</div>
            @endif
        </div>
    @endif
    @push('scripts-bottom')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
        $("#student-field").focusout(function(){
            $(".qw-student").delay(500).hide(0);
        })
        });
    </script>
    @endpush

    </div>
</div>
