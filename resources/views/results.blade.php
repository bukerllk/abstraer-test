<div class="row fases-tables text-center" >
    <div class="col-sm-6" style="float: left;">
        <table>
            <thead>
            <tr>
                <th colspan="3">Agent 1</th>
            </tr>
            </thead>
            <tbody>
            @foreach($agent1 as $agent)
                <tr align="center" style="background-color: #d5d5d5">
                    <td width="33%">Agent One</td>
                    <td width="34%" class="color">{{$agent['name']}}</td>
                    <td width="33%">{{$agent['zip_code']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-sm-6" style="float: left;">
        <table>
            <thead>
            <tr>
                <th colspan="3">Agent 2</th>
            </tr>
            </thead>
            <tbody>
            @foreach($agent2 as $agent)
                <tr align="center" style="background-color: #d5d5d5">
                    <td width="33%">Agent Two</td>
                    <td width="34%" class="color">{{$agent['name']}}</td>
                    <td width="33%">{{$agent['zip_code']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

