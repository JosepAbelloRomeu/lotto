<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
        body {
            font-family: 'Oswald', sans-serif;
        }
        .ticket {
            margin-top: 0;
            margin-bottom: 50px;
            background: #FFF;
            padding: 5px 13px;
            border: 1px solid #d3c8c8;
        }
        .match-row {
            display: table;
            width: 98%;
            margin: 0 auto;
            table-layout: fixed;
            overflow: hidden;
            border-collapse: collapse;
            font-size: 0;
        }
        .match-row .row-cell {
            font-size: 12px;
            opacity: .9;
            filter: alpha(opacity=9);
            position: relative;
            font-family: "oswaldFontLight", Arial, sans-serif;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            padding: 5px 0;
        }
        .match-row .row-cell {
            display: table-cell;
            border: 0;
        }
        .match-row .row-cell5 {
            width: 50px;
            display: table-cell;
            text-align: center;
            font-size: 12px;
            opacity: .9;
            filter: alpha(opacity=9);
            white-space: nowrap;
            text-align: center;
        }
        .content-ticket {
            font-size: 0;
            display: table-row;
            width: 98%;
            position: relative;
            margin: 0 auto;
            border-collapse: collapse;
            border: 0;
        }
        .bg-name {
            display: inline-block;
            background: white;
            position: relative;
            text-transform: uppercase;
        }
        .ticket .ellipsis-bottom-online-topp {
            bottom: 6px;
        }
        .ellipsis-bottom-online-topp {
            display: block;
            position: absolute;
            font-size: 12px;
            left: 5px;
            width: 98%;
            overflow: hidden;
            height: 1em;
            bottom: 2px;
        }
        .cell-num {
            display: table-cell;
            text-align: center;
            white-space: nowrap;
            width: 2em;
            font-size: 12px;
            text-align: left;
            opacity: .9;
            filter: alpha(opacity=9);
        }
        .num-line {
            margin-right: -6px;
            background: white;
            position: relative;
            width: 60%;
            text-align: right;
            border: 0;
        }
        .match-row .cell-results {
            display: table-cell;
            text-align: center;
            white-space: nowrap;
            width: 80px;
            margin: 0 auto;
        }
        .match-row .results-boxes {
            background-color: #ff9990;
            white-space: nowrap;
            font-size: 13px;
        }
        .match-row .results-boxes .results-boxes-home {
            display: inline-block;
            vertical-align: middle;
            position: relative;
            width: 20px;
            height: 19px;
            margin-top: 1px;
        }
        .pink {
            color: #ff9990;
        }
        .result-box {
            color: #ff9990;
            vertical-align: middle;
            font-size: 13px;
            text-transform: uppercase;
            opacity: .9;
            filter: alpha(opacity=9);
            display: block;
            z-index: 1;
        }
        .result-box.success {
            color: #70b14a !important;
            font-weight: bold;
        }
        .result-box.fail {
            color: #000 !important;
            font-weight: bold;
        }
        .bg-white {
            background-color: #FFF;
        }
        .pink-line {
            border: 0;
            height: 1px;
            background-color: #ff9990;
            margin: 0;
        }
        .pink-line-double {
            border: 0;
            width: 100%;
            height: 3px;
            background-color: #ff9990;
            margin: 0;
        }
        .title-list {
            font-size: 13px;
            margin-right: 25px;
            text-align: right;
            text-transform: uppercase;
            padding-bottom: 10px;
        }
        .footer-txt {
            width: 100%;
            font-size: 0;
        }
    </style>
</head>
<body>
    <section class="ticket">
        <hr class="pink-line-double">
        @foreach ($matches as $match)
            @php
                $prevision = Helper::getPrevision($match->local, $match->visitor);
                $isHit = $prevision == $match->result;
                if ($isHit) {
                    $acumulable++;
                }
            @endphp

            @if($loop->iteration == 5 || $loop->iteration == 9 || $loop->iteration == 12 || $loop->iteration == 15)
                <hr class="pink-line">
            @endif
            <div class="match-row">
                <article class="content-ticket">
                    <div class="row-cell">
                        <div class="ellip ellipsis-bottom-online-topp">. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .  . . . . . . . . . . . . . . .  . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . </div>
                        <div class="bg-name">{{ $match->local }} - {{ $match->visitor }}</div>
                    </div>
                    <div class="cell-num">
                        <div class="num-line">{{ $loop->iteration }}</div>
                    </div>
                    <div class="cell-results results-boxes item0">
                        <div class="results-boxes-home bg-white" data-match="1" data-result="1">
                            <div class="result-box {{ $prevision == 1 ? ($prevision == $match->result ? 'success' : 'fail') : '' }}"><span id="caixa_1">1</span></div>
                        </div>
                        <div class="results-boxes-home bg-white" data-match="1" data-result="x">
                            <div class="result-box {{ $prevision == 'X' ? ($prevision == $match->result ? 'success' : 'fail') : '' }}"><span id="caixa_x" class="uppercase">X</span></div>
                        </div>
                        <div class="results-boxes-home bg-white" data-match="1" data-result="2">
                            <div class="result-box {{ $prevision == 2 ? ($prevision == $match->result ? 'success' : 'fail') : '' }}"><span id="caixa_2">2</span></div>
                        </div>
                    </div>
                    <div class="row-cell5 red">{{ $match->result }}</div>
                </article>
            </div>
        @endforeach
        <hr class="pink-line-double">
        <article class="footer-txt">
            <div class="title-list pink">{{ $acumulable }} ACIERTOS</div>
        </article>
    </section>
</body>
</html>
