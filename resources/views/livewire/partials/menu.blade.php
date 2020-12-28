<div class="px-3">

<h4>{{$post["_page"]}} Menu</h4>

@if(isset($post['_pilihTahun']) && $post['_pilihTahun'])
<select id="inputState" class="form-control" wire:model="tahun" wire:change="changeTahun()" style="width: 100%">
    <option value="all" selected>Semua</option>
    @foreach ($allTahun as $tahun)
    <option value="{{$tahun['id']}}" wire:key="{{$tahun['id']}}">{{$tahun['tahun_ajaran']}}</option>
    @endforeach
</select>
@endif
<hr/>
<ul>
    @php {{$i=1;}} @endphp
    @foreach ($post["_menus"] as $menus)
    @foreach ($menus as $menu)
        <li>
        <a href="{{ (isset($menu["_route"]))?route($menu["_route"]):$menu['_link']}}">{{__($menu["_text"])}}</a>
        </li>

    @endforeach

    @if($i < count($post["_menus"]))
    <hr/>
    @endif

    @php {{$i++;}} @endphp
    @endforeach
    @if(isset($post['_msg']))
    <p>{{$post['_msg']}}</p>
    @endif


</ul>
</div>
