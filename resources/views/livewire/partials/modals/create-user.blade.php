<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Create {{ $subMenu }}</h4>
                <button type="button" class="close" wire:click="emptyUserForm" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <form wire:submit.prevent="create" class="form-modal">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="inputName">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="name" class="form-control" id="inputName" placeholder="Masukkan Nama Lengkap" wire:model="user.name">
                                @if(isset($validation_errors["name"]))
                                @foreach($validation_errors["name"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="InputEmail">Email address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" wire:model="user.email" placeholder="Masukkan Alamat Email">
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
                                <label for="InputPassword1">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="InputPassword1" placeholder="Password (minimal 8 karakter)" wire:model="user.password">
                                @if(isset($validation_errors["password"]))
                                @foreach($validation_errors["password"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="InpitPassword2">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="InpitPassword2" placeholder="Konfirmasi Password" wire:model="user.confirm_password">
                                @if(isset($validation_errors["confirm_password"]))
                                @foreach($validation_errors["confirm_password"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="InputNIP">NIP</label>
                                <input type="text" class="form-control" id="InputNIP" placeholder="Masukkan NIP" wire:model="user.NIP">
                                @if(isset($validation_errors["NIP"]))
                                @foreach($validation_errors["NIP"] as $k => $v)
                                <label for="" class="text-danger">{{ $v }}</label>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="inputState">Role<span class="text-danger">*</span></label>
                                <select id="inputState" class="form-control" wire:model="user.user_type">
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
                                            <div class="pict mb-2" style="background-image: url('https://ui-avatars.com/api/?name={{$user['name']}}&background=0D8ABC&color=fff&size=150'); height: 150px; width:150px;border-radius: 15px;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            background-size: cover;">
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="container d-flex flex-column mx-3">
                                                <button class="btn s-btn-primary mb-3"  onclick="event.preventDefault();
                                                document.getElementById('InputPhoto').click();">Upload Image</button>
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
                        <input type="file" name="InputPhoto" id="InputPhoto" hidden wire:model="user.picture" class='form-control' accept="image/x-png,image/jpeg">

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
                    <div class="col-6 d-flex align-items-center">
                        <input type="checkbox" class="toggle" checked id="inputMore" wire:model="inputMore">
                        <label for="inputMore" class="my-auto ml-3">Jangan tutup form setelah selesai</label>
                    </div>
                    <div class="col-6 text-right ">
                        <button wire:click="emptyUserForm" data-dismiss="modal" class="btn btn-default my-3">Cancel</button>
                        <button type="button" wire:click="save" class="btn s-btn-primary my-3 btn-modal-save">Submit</button>


                    </div>
                </div>
            </div>

        </div>


    </form>




</div>
</div>
</div>
</div>

