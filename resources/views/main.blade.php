<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Lotto</title>

    <style>
        body {
            font-family: 'Oswald', sans-serif;
        }
        .ticket {
            margin-top: 0;
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
        .match-row .row-cell3 {
            width: 100px;
            font-size: 12px;
            opacity: .9;
            filter: alpha(opacity=9);
            white-space: nowrap;
            font-family: 'Oswald', sans-serif;
            font-weight: 300;
            text-align: center;
        }
        .match-row .row-cell1, .content-ticket .row-cell2, .content-ticket .row-cell3, .content-ticket .row-cell4, .content-ticket .row-cell5 {
            display: table-cell;
            border: 0;
        }
        .bg-lightpink {
            background-color: #ffe0dd;
        }
        .value {
            display: inline-block;
            width: 2.2em;
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
            line-height: 19px;
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
            margin-right: 5px;
            text-align: right;
            text-transform: uppercase;
            padding-bottom: 10px;
        }
        .footer-txt {
            width: 100%;
            font-size: 0;
            margin-top: 5px;
        }
        .wrapper {
            max-width: 1021px;
            margin: 0 auto;
            padding: 10px;
            box-sizing: border-box;
            font-family: 'Oswald', sans-serif;
            font-size: 0;
            background-color: #f6f3f3;
            line-height: 1.2;
            position: relative;
        }
        .header-ticket {
            width: 100%;
            text-transform: uppercase;
            font-size: 0;
        }
        .header-ticket .title-ticket {
            width: 25%;
            font-size: 22px;
            display: inline-block;
            vertical-align: middle;
            margin: 10px;
            font-family: 'Oswald', sans-serif;
            color: #00245c;
        }
        .js-num-temporada {
            font-size: 14px;
            font-weight: normal;
            margin-left: 10px;
        }
    </style>

</head>

<body class="text-blueGray-700 antialiased">

    @include('partials.header')

    <div id="__next">

        <nav class="fixed z-50 w-full bg-white top-0 flex flex-wrap items-center justify-between px-2 py-3 shadow-lg">
            <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
                <div class="w-full relative flex justify-between lg:w-auto lg:static lg:block lg:justify-start"><a
                        class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-blueGray-700"
                        href="{{ route('home') }}">Lotto</a><button
                        class="cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none"
                        type="button"><i class="fas fa-bars"></i></button></div>
                <div class="lg:flex flex-grow items-center hidden" id="example-navbar-danger">
                    <ul class="flex flex-col lg:flex-row list-none lg:ml-auto">
                        <li class="nav-item"><a
                                class="px-3 py-2 flex items-center text-xs uppercase font-bold text-blueGray-700 hover:text-blueGray-500"
                                href="{{ route('hits') }}"><i
                                    class="far fa-file-alt text-lg leading-lg text-blueGray-400"></i><span
                                    class="ml-2">Hits</span></a></li>
                        <li class="nav-item"><a
                                class="download-button px-3 py-2 flex items-center text-xs uppercase font-bold text-blueGray-700 hover:text-blueGray-500"
                                href="{{ route('result') }}"><i
                                    class="fas fa-arrow-alt-circle-down text-lg leading-lg text-blueGray-400"></i><span
                                    class="ml-2">Result</span></a></li>
                        <li class="nav-item"><a
                                href="{{ route('generate') }}"
                                class="download-button px-3 py-2 flex items-center text-xs uppercase font-bold text-blueGray-700 hover:text-blueGray-500"><i
                                    class="fab fa-sketch text-lg leading-lg text-blueGray-400"></i><span
                                    class="ml-2">Generator</span></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        @yield('content')
            
    </div>

    @include('partials.footer')

    @yield('scripts')

</body>

</html>
