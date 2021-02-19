<div class="relative" id="class-field">
    <div class="form-group">
        <label for="InputKelas">Kelas<span class="text-danger">*</span></label>

    <input
        placeholder="Cari Kelas..."
        wire:model="query"
        wire:keydown.escape="_reset"
        wire:keydown.tab="tabPressed"
        wire:keydown.arrow-up="decrementHighlight"
        wire:keydown.arrow-down="incrementHighlight"
        wire:keydown.enter="selectContact"
        wire:keydown.backspace="resetHighlight"
        type="name" class="form-control" id="InputKelas"
    />


    @if(!empty($query))
        <div class="fixed top-0 right-0 bottom-0 left-0 blocker qw-class" wire:click="_reset"></div>

        <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg p-3 result-student-search qw-class">
            @if(!empty($classes))
                @foreach($classes as $i => $class)
                    <a wire:click="selectContact({{$i}})"
                        class="list-item {{ $highlightIndex === $i ? 'highlight' : '' }}"
                    >{{ "Kelas ".$class['tingkat']." (". $class['name'].")" }}</a>
                @endforeach
            @else
                <div class="list-item">No results!</div>
            @endif
        </div>
    @endif

    @push('scripts-bottom')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
        $("#class-field").focusout(function(){
            $(".qw-class").delay(500).hide(0);
        })
        });
    </script>
    @endpush
    </div>
</div>
