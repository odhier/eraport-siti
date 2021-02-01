<div class="px-3">

    <h4>{{$menu["_page"]}} Menu</h4>

    @if(isset($menu['_pilihTahun']) && $menu['_pilihTahun'])
    <select id="inputState" class="form-control" wire:model="tahun" onchange="javascript:handleSelect(this)" style="width: 100%">
        <option value="all" selected>Semua</option>
        @foreach ($allTahun as $tahun)
        <option value="{{$tahun['id']}}" wire:key="{{$tahun['id']}}">{{$tahun['tahun_ajaran']}}</option>
        @endforeach
    </select>
    @endif
    <hr/>
    <ul>
        @php {{$i=1;}} @endphp
        @foreach ($menu["_menus"] as $menus)
        @foreach ($menus as $m)
            <li>
            <a href="{{ (isset($m["_route"]))?route($m["_route"]):$m['_link']}}">{{__($m["_text"])}}</a>
            </li>
        @endforeach
        @if($i < count($menu["_menus"]))
        <hr/>
        @endif

        @php {{$i++;}} @endphp
        @endforeach
        @if(isset($menu['_msg']))
        <p>{{$menu['_msg']}}</p>
        @endif


    </ul>
    <a href="" id="linkTahun"></a>
    <script type="text/javascript">
        function handleSelect(elm)
        {
            var link = document.getElementById("linkTahun");
            link.setAttribute("href", "/class/"+elm.value);
            link.click();

        }
      </script>
    </div>
