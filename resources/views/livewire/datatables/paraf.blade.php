<div class="flex space-y-1 justify-around d-flex flex-column text-center">
@if($paraf)
<div class="pict mx-auto" style="background-image: url('{{asset('storage/'.$paraf)}}'); height: 30px; width:30px;border-radius: 5px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;">
</div>

@endif
<a data-toggle="modal" data-target="#parafModal" wire:click="$emitTo('pages.admin','editForm', '{{$id}}')" class="text-blue-500 hover:text-blue-600 cursor-pointer" >Upload Paraf</a>
</div>
