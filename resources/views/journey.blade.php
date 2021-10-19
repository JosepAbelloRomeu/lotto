@extends('main')

@section('content')

    <div class="main py-14 lg:py-32">
        <div class="wrapper">
            <section class="ticket container mx-auto header relative mt-8">

                <article class="header-ticket">
                    <h2 class="title-ticket blue">
                        Jornada <span class="js-num-jornada">{{ $matches->working_day }}</span>
                        <span class="js-num-temporada">TEMPORADA 2022</span>
                    </h2>
                </article>
                
                <hr class="pink-line-double">
                @foreach ($matches->historics as $key => $match)
                    @php
                        $prevision = Helper::getBet($match->local, $match->visitor, true, $key);
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
                                @if($loop->iteration != 15)<div class="ellip ellipsis-bottom-online-topp">. . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .  . . . . . . . . . . . . . . .  . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . </div>@endif
                                <div class="bg-name">
                                    @if($loop->iteration == 15)
                                        <span>{{ $match->local }}</span>
                                        <span class="table mt-2">{{ $match->visitor }}</span>
                                    @else
                                        {{ $match->local }} - {{ $match->visitor }}
                                    @endif
                                </div>
                            </div>
                            <div class="cell-num">
                                <div class="num-line">{{ $loop->iteration }}</div>
                            </div>
                            <div class="cell-results results-boxes item0" style="{{ $loop->iteration == 15 ? 'width: 100px' : '' }}">
                                @if($loop->iteration == 15)
                                    <div class="results-boxes-home bg-white" data-match="0" data-result="0">
                                        <div class="result-box {{ substr($prevision, 0, 1) == 0 ? (substr($prevision, 0, 1) == substr($match->resultWithGoals, 0, 1) ? 'success' : 'fail') : '' }}"><span id="caixa_0">0</span></div>
                                    </div>
                                    <div class="results-boxes-home bg-white" data-match="1" data-result="1">
                                        <div class="result-box {{ substr($prevision, 0, 1) == 1 ? (substr($prevision, 0, 1) == substr($match->resultWithGoals, 0, 1) ? 'success' : 'fail') : '' }}"><span id="caixa_1">1</span></div>
                                    </div>
                                    <div class="results-boxes-home bg-white" data-match="2" data-result="2">
                                        <div class="result-box {{ substr($prevision, 0, 1) == 2 ? (substr($prevision, 0, 1) == substr($match->resultWithGoals, 0, 1) ? 'success' : 'fail') : '' }}"><span id="caixa_2">2</span></div>
                                    </div>
                                    <div class="results-boxes-home bg-white" data-match="M" data-result="M">
                                        <div class="result-box {{ substr($prevision, 0, 1) == 'M' ? (substr($prevision, 0, 1) == substr($match->resultWithGoals, 0, 1) ? 'success' : 'fail') : '' }}"><span id="caixa_M">M</span></div>
                                    </div>
                                    <br>
                                    <div class="results-boxes-home bg-white" data-match="0" data-result="0">
                                        <div class="result-box {{ substr($prevision, -1) == 0 ? (substr($prevision, 0, 1) == substr($match->resultWithGoals, 0, 1) ? 'success' : 'fail') : '' }}"><span id="caixa_0">0</span></div>
                                    </div>
                                    <div class="results-boxes-home bg-white" data-match="1" data-result="1">
                                        <div class="result-box {{ substr($prevision, -1) == 1 ? (substr($prevision, 0, 1) == substr($match->resultWithGoals, 0, 1) ? 'success' : 'fail') : '' }}"><span id="caixa_1">1</span></div>
                                    </div>
                                    <div class="results-boxes-home bg-white" data-match="2" data-result="2">
                                        <div class="result-box {{ substr($prevision, -1) == 2 ? (substr($prevision, 0, 1) == substr($match->resultWithGoals, 0, 1) ? 'success' : 'fail') : '' }}"><span id="caixa_2">2</span></div>
                                    </div>
                                    <div class="results-boxes-home bg-white" data-match="M" data-result="M">
                                        <div class="result-box {{ substr($prevision, -1) == 'M' ? (substr($prevision, 0, 1) == substr($match->resultWithGoals, 0, 1) ? 'success' : 'fail') : '' }}"><span id="caixa_M">M</span></div>
                                    </div>
                                @else
                                    <div class="results-boxes-home bg-white" data-match="1" data-result="1">
                                        <div class="result-box {{ $prevision == 1 ? ($prevision == $match->result ? 'success' : 'fail') : '' }}"><span id="caixa_1">1</span></div>
                                    </div>
                                    <div class="results-boxes-home bg-white" data-match="1" data-result="x">
                                        <div class="result-box {{ $prevision == 'X' ? ($prevision == $match->result ? 'success' : 'fail') : '' }}"><span id="caixa_x" class="uppercase">X</span></div>
                                    </div>
                                    <div class="results-boxes-home bg-white" data-match="1" data-result="2">
                                        <div class="result-box {{ $prevision == 2 ? ($prevision == $match->result ? 'success' : 'fail') : '' }}"><span id="caixa_2">2</span></div>
                                    </div>
                                @endif
                            </div>
                            <div class="row-cell3 bg-lightpink item1">
                                <span class="value">{{ Helper::getPercentage($match->local, $match->visitor, 'win') }}</span>
                                <span class="value">{{ Helper::getPercentage($match->local, $match->visitor, 'tie') }}</span>
                                <span class="value">{{ Helper::getPercentage($match->local, $match->visitor, 'lose') }}</span>
                            </div>
                            <div class="row-cell5 red">
                                @if($match->resultWithGoals)
                                    <span class="block mb-2">{{ substr($match->resultWithGoals, 0, 1) }}</span>
                                    <span>{{ substr($match->resultWithGoals, -1) }}</span>
                                @else
                                    {{ $match->result }}
                                @endif
                            </div>
                        </article>
                    </div>
                @endforeach

                <hr class="pink-line-double">

                <article class="footer-txt">
                    <div class="title-list pink">{{ $acumulable }} ACIERTOS</div>
                </article>
            </section>
        </div>
    </div>

@endsection
