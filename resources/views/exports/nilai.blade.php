
<table border="1" style="border-collapse: collapse;border:1px solid #888888">
    <thead>
        <tr>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">No</th>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">SC_ID</th>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">Nama</th>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">KD_ID</th>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">KD</th>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">Harian</th>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">UTS</th>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">UAS</th>
            <th style="font-weight:bold;text-align:center;vertical-align:middle;background-color:#cccccc;height: 30px;border: 1px solid #888888">NA KD</th>
        </tr>
    </thead>
    <tbody>
        @php $i=1;$row=1 @endphp

        @foreach ($student_nilai as $in => $sNilai)
            <tr >
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc" rowspan="{{isset($sNilai->nilai[$ki])?count($sNilai->nilai[$ki]):'1'}}">{{$i}}</td>
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc" rowspan="{{isset($sNilai->nilai[$ki])?count($sNilai->nilai[$ki]):'1'}}">{{$sNilai->id}}</td>
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc" rowspan="{{isset($sNilai->nilai[$ki])?count($sNilai->nilai[$ki]):'1'}}">{{$sNilai->name}}</td>
                @if(isset($sNilai->nilai[$ki]))
                @foreach ($sNilai->nilai[$ki] as $index => $vnilai)
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc"  >{{$vnilai->id}}</td>
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc"  >{{$ki}}.{{$index+1}}</td>
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc"  >{{$vnilai->NH?$vnilai->NH:0}}</td>
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc"  >{{$vnilai->NUTS?$vnilai->NUTS:0}}</td>
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc"  >{{$vnilai->NUAS?$vnilai->NUAS:0}}</td>
                <td style="background-color:{{$in % 2!=0?'#f6f8fa':'white'}};border:1px solid #cccccc" >=((F{{$row+1}}*2)+G{{$row+1}}+H{{$row+1}})/4</td>

                @php $row++; @endphp
            </tr>
                @if($index != count($sNilai->nilai[$ki])-1)
            <tr>
                @endif
                @endforeach
                @endif
            @php $i++; @endphp
        @endforeach
    </tbody>
    <script>
    document.ready(function(){
        window.close();
    })
    </script>
</table>
