<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript" src="{{ URL::asset('js/scripts.js') }}"></script>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="row fases-tables text-center" >
    <div class="col-sm-6" style="float: left;">
    <a href="index.php">Home</a>
        </div>
    <br>
    <br>
    <br>
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
    <div class="col-sm-6" style="float: left;">
        <table id="resultAjax">
            <thead>
            <tr>
                <th colspan="3"><a href="javascript:;" onclick="ajaxList()">Click here for more Ajax Agents lits</a></th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
</body>
</html>

