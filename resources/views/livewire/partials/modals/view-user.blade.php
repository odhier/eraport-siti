<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">View {{ $subMenu }}</h4>
                <button type="button" class="close" wire:click="emptyUserForm" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        <div class="modal-body ">
            <div class="container p-3">
                <div class="row">
                    <div class="col text-center">
                        @if ($user["picture"])

                        <div class="pict mb-2" style="background-image: url('{{ $user["picture"]->temporaryUrl() }}'); height: 150px; width:150px;border-radius: 15px;
                            background-position: center;
                            background-repeat: no-repeat;
                            background-size: cover;">
                        </div>
                        @else
                        @if($user['current_picture'])
                        <div class="pict mb-2" style="background-image: url('{{ asset('storage/'.$user["current_picture"]) }}'); height: 150px; width:150px;border-radius: 15px;
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: cover;">
                    </div>
                    @else
                    <div class="pict mb-2" style="background-image: url('https://ui-avatars.com/api/?name={{$user['name']}}&background=0D8ABC&color=fff&size=150'); height: 150px; width:150px;border-radius: 15px;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;">
                </div>
                @endif
                @endif
            </div>
            <div class="col-9">
                <div class="row">
                    <div class="col-6">User ID</div>
                    <div class="col-6 font-weight-bold">{{$user['id']}}</div>
                </div>
                <div class="row">
                    <div class="col-6">Nama</div>
                    <div class="col-6 font-weight-bold">{{$user['name']}}</div>
                </div>
                <div class="row">
                    <div class="col-6">Email</div>
                    <div class="col-6 font-weight-bold">{{$user['email']}}</div>
                </div>
                <div class="row">
                    <div class="col-6">NIP</div>
                    <div class="col-6 font-weight-bold">{{$user['NIP']}}</div>
                </div>
                <div class="row">
                    <div class="col-6">Role</div>

                <div class="col-6 font-weight-bold">{{$user['role_name']}}</div>
                </div>
                <div class="row">
                    <div class="col-6">Is Active</div>
                    @if($user['is_active'])
                        <div class="col-6 font-weight-bold text-success">Active</div>
                    @else
                        <div class="col-6 font-weight-bold text-danger">Non Active</div>
                    @endif

                </div>
            </div>
        </div>
            </div>
    </div>
</div>
</div>
</div>

