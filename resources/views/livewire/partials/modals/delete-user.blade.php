<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Data yang sudah dihapus tidak dapat dipulihkan kembali.</p>
                Yakin ingin menghapus user ini?

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <a wire:click="tes">Delete</a>
                <button wire:click="$emitTo('users-table','handleDelete')" class="btn btn-danger" data-dismiss="modal">Hapus</button>
            </div>
        </div>
    </div>
</div>
