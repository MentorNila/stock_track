<h5 style=" width: 100%;
   text-align: center;
   border-bottom: 1px solid #000;
   line-height: 0.1em;
   margin: 10px 0 20px; "><span style="background:#fff;
    padding:0 10px; ">Tag properties</span></h5>

<table class="table" style="color: #545454;">
    <thead>
    <tr>
        <th scope="col">Property</th>
        <th scope="col">Value</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tags as $name => $value)
        @if(isset($value) && $value !== '')
            <tr>
                <td><p>{{ucwords($name)}}</p></td>
                <td><p style="word-break: break-all;">{{$value}}</p></td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
