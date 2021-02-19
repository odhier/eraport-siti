<div class="relative" id="teacher-field">
    <div class="form-group">
        <label for="InputGuru">Guru<span class="text-danger">*</span></label>

    <input
        placeholder="Cari Guru..."
        wire:model="query"
        wire:keydown.escape="_reset"
        wire:keydown.tab="tabPressed"
        wire:keydown.arrow-up="decrementHighlight"
        wire:keydown.arrow-down="incrementHighlight"
        wire:keydown.enter="selectContact"
        wire:keydown.backspace="resetHighlight"
        type="name" class="form-control" id="InputGuru"
    />


    @if(!empty($query))
        <div class="fixed top-0 right-0 bottom-0 left-0 blocker qw-teacher" wire:click="_reset"></div>

        <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg p-3 result-student-search qw-teacher">
            @if(!empty($teachers))
                @foreach($teachers as $i => $teacher)
                    <a wire:click="selectContact({{$i}})"
                        class="list-item {{ $highlightIndex === $i ? 'highlight' : '' }}"
                    >{{ $teacher['name'] }}</a>
                @endforeach
            @else
                <div class="list-item">No results!</div>
            @endif
        </div>
    @endif
    @push('scripts-bottom')
    <script>
        document.addEventListener('DOMContentLoaded', function(event) {
        $("#teacher-field").focusout(function(){
            $(".qw-teacher").delay(500).hide(0);
        })
        });
    </script>
    @endpush

    </div>
</div>
