<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="editModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Edit {{ $subMenu }}</h4>
                <button type="button" wire:click="emptyUserForm" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" wire:loading>
                <h5 class="animate-bounce">Loading Data...</h5>
                <div class="animate-pulse flex space-x-4">

                    <div class="flex-1 space-y-4 py-1">
                      <div class="h-4 bg-gray-400 rounded w-3/4"></div>
                      <div class="space-y-2">
                        <div class="h-4 bg-gray-400 rounded"></div>
                        <div class="h-4 bg-gray-400 rounded w-5/6"></div>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="modal-body" wire:loading.remove>

                <form wire:submit.prevent="update">
                    <div class="row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="inputEditName">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="name" class="form-control" id="inputEditName" placeholder="Masukkan Nama Lengkap" wire:model.defer="user.name">
                                @if(isset($validation_errors["name"]))
                                @foreach($validation_errors["name"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="InputEmailEmail">Email address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="InputEmailEmail" aria-describedby="emailHelp" wire:model.defer="user.email" placeholder="Masukkan Alamat Email">
                                @if(isset($validation_errors["email"]))
                                @foreach($validation_errors["email"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>

                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="InputEditNIP">NIP</label>
                                <input type="text" class="form-control" id="InputEditNIP" placeholder="Masukkan NIP" wire:model.defer="user.NIP">
                                @if(isset($validation_errors["NIP"]))
                                @foreach($validation_errors["NIP"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="inputEditRole">Role<span class="text-danger">*</span></label>
                                <select id="inputEditRole" class="form-control" wire:model.defer="user.user_type" wire:change="$set('changeRole', true)">
                                    @foreach ($allRoles as $role => $name)
                                        <option value="{{$role}}" wire:key="{{$role}}">{{$name}}</option>
                                    @endforeach
                                </select>
                                @if(isset($validation_errors["user_type"]))
                                @foreach($validation_errors["user_type"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                Photo:
                                <table>
                                    <tr valign="top">
                                        <td>
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
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="container d-flex flex-column mx-3">
                                                <button class="btn s-btn-primary mb-3"  onclick="event.preventDefault();
                                                document.getElementById('InputEditPhoto').click();">Upload Image</button>
                                                <button type="button" wire:click="clearPicture" class="btn btn-secondary">Remove Image</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="col-12">
                        <div
                        x-data="{ isUploading: false, progress: 0 }"
                        x-on:livewire-upload-start="isUploading = true"
                        x-on:livewire-upload-finish="isUploading = false"
                        x-on:livewire-upload-error="isUploading = false"
                        x-on:livewire-upload-progress="progress = $event.detail.progress"
                        >
                        <input type="file" name="InputPhoto" id="InputEditPhoto" hidden wire:model="user.picture" class='form-control' accept="image/x-png,image/jpeg">

                        <!-- Progress Bar -->
                        <div x-show="isUploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>
                    @if(isset($validation_errors["picture"]))
                    @foreach($validation_errors["picture"] as $k => $v)
                    <label for="" class="text-danger">{{ $v }}</label>
                    @endforeach
                    @endif


                </div>
            </div>
            <div class="s-modal-footer w-100">
                <div class="row d-flex align-items-center">

                    <div class="col-12 text-right ">
                        <button wire:click="emptyUserForm" data-dismiss="modal" id="close-btn-modal" class="btn btn-default my-3">Cancel</button>
                        <div wire:target="_update" wire:loading >
                            <button type="button" class="btn s-btn-primary my-3 btn-modal-save" disabled>Saving...</button>
                        </div>
                        <button type="button" wire:target="_update" wire:click="_update" class="btn s-btn-primary my-3 btn-modal-save" wire:loading.remove>Submit</button>


                    </div>
                </div>
              </div>

        </div>


    </form>




</div>
</div>
</div>
</div>

