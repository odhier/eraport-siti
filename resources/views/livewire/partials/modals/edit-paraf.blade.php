<div wire:ignore.self x-on:close-modal.window="on = false" class="modal fade bd-example-modal-lg" id="parafModal" tabindex="-1" role="dialog" aria-labelledby="createUsersModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Paraf {{ $subMenu }}</h4>
                <button type="button" wire:click="emptyUserForm" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" wire:loading>
                <div class="relative group text-primary-500" style="padding-top: 70%">
                    <div class="absolute top-0 left-0 h-full w-full" style="height: 150px;
                    width: 150px;
                    border-radius: 15px;"><span class="skeleton-box group-hover:scale-110 transition-transform transform-center block h-full"></span></div></div>
            </div>
            <div class="modal-body" wire:loading.remove>

                <form wire:submit.prevent="update">
                    <div class="row">

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <table>
                                    <tr valign="top">
                                        <td>
                                            @if ($user["picture_paraf"])

                                            <div class="pict mb-2" style="background-image: url('{{ $user["picture_paraf"]->temporaryUrl() }}'); height: 150px; width:150px;border-radius: 15px;
                                                background-position: center;
                                                background-repeat: no-repeat;
                                                background-size: cover;">
                                            </div>
                                            @else
                                            @if($user['current_picture_paraf'])
                                            <div class="pict mb-2" style="background-image: url('{{ asset('storage/'.$user["current_picture_paraf"]) }}'); height: 150px; width:150px;border-radius: 15px;
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
                                                document.getElementById('InputEditPhotoParaf').click();">Upload Image</button>
                                                <button type="button" wire:click="clearPictureParaf" class="btn btn-secondary">Remove Image</button>
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
                        <input type="file" name="InputPhotoParaf" id="InputEditPhotoParaf" hidden wire:model="user.picture_paraf" class='form-control' accept="image/x-png,image/jpeg">

                        <!-- Progress Bar -->
                        <div x-show="isUploading">
                            <progress max="100" x-bind:value="progress"></progress>
                        </div>
                    </div>
                    @if(isset($validation_errors["picture_paraf"]))
                    @foreach($validation_errors["picture_paraf"] as $k => $v)
                    <label for="" class="text-danger">{{ $v }}</label>
                    @endforeach
                    @endif


                </div>
            </div>
            <div class="s-modal-footer w-100">
                <div class="row d-flex align-items-center">

                    <div class="col-12 text-right ">
                        <button wire:click="emptyUserForm" data-dismiss="modal" id="close-btn-modal" class="btn btn-default my-3">Cancel</button>
                        <div wire:target="_updateParaf" wire:loading >
                            <button type="button" class="btn s-btn-primary my-3 btn-modal-save" disabled>Saving...</button>
                        </div>
                        <button type="button" wire:target="_updateParaf" wire:click="_updateParaf" class="btn s-btn-primary my-3 btn-modal-save" wire:loading.remove>Submit</button>


                    </div>
                </div>
              </div>

        </div>


    </form>




</div>
</div>
</div>
</div>

