
<div class="flex space-x-1 justify-around">
@if($picture)
<div class="pict mb-2" style="background-image: url('{{asset('storage/'.$picture)}}'); height: 30px; width:30px;border-radius: 5px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;">
</div>
@else
<div class="pict mb-2" style="background-image: url('https://ui-avatars.com/api/?name={{$name}}&background=0D8ABC&color=fff&size=150'); height: 30px; width:30px;border-radius: 5px;
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
</div>
@endif
</div>
