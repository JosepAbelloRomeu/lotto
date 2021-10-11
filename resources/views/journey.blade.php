@extends('main')

@section('content')

    <div class="main mt-16">
        <div class="wrapper">
            <section class="ticket container mx-auto header relative mt-8">

                <article class="header-ticket">
                    <h2 class="title-ticket blue">
                        Jornada <span class="js-num-jornada">{{ $matches->working_day }}</span>
                        <span class="js-num-temporada">TEMPORADA 2022</span>
                    </h2>
                </article>
                
                <hr class="pink-line-double">
                @foreach ($matches->historics as $match)
                    @php
                        $prevision = Helper::getBet($match->local, $match->visitor);
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
                            <div class="row-cell3 bg-lightpink item1">
                                <span class="value">{{ Helper::getPercentage($match->local, $match->visitor, 'win') }}</span>
                                <span class="value">{{ Helper::getPercentage($match->local, $match->visitor, 'tie') }}</span>
                                <span class="value">{{ Helper::getPercentage($match->local, $match->visitor, 'lose') }}</span>
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
        </div>
    </div>

@endsection
