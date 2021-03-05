<div class="modal-dialog modal-lg">
<div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Galaxy Forma</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
            <div class="modal-body">
                {{$angka}}
                <button wire:click="increment">+</button>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click="submit">Submit</button>
            </div>
    </div>
</div>
