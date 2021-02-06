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
                    <div class="col text-center" wire:loading>
                        <div class="relative group text-primary-500" style="padding-top: 70%">
                            <div class="absolute top-0 left-0 h-full w-full" style="height: 150px;
                            width: 150px;
                            border-radius: 15px;"><span class="skeleton-box group-hover:scale-110 transition-transform transform-center block h-full"></span></div></div>
                    </div>
                    <div class="col text-center" wire:loading.remove>

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
            <div class="col-9" wire:loading>
                <div class="flex flex-col flex-grow w-100">
                    <div class="text-left relative flex-grow w-100">
                      <h3 class="text-lg font-bold text-gray-darkest mr-10">
                        <span class="skeleton-box h-5 w-1/6 inline-block"></span>
                        <span class="skeleton-box h-5 w-1/2 inline-block"></span>
                        <span class="skeleton-box h-5 w-2/4 inline-block"></span>
                        <span class="skeleton-box h-5 w-2/5 inline-block"></span>
                        <span class="skeleton-box h-5 w-full inline-block"></span>
                        <span class="skeleton-box h-5 w-1/2 inline-block"></span>
                        <span class="skeleton-box h-5 w-2/4 inline-block"></span>
                        <span class="skeleton-box h-5 w-2/5 inline-block"></span>
                        <span class="skeleton-box h-5 w-1/6 inline-block"></span>
                      </h3>
                    </div>
                </div>
            </div>
            <div class="col-9" wire:loading.remove>
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

