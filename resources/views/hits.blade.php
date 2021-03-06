@extends('main')

@section('content')
    <section class="container mx-auto header relative pt-16 flex h-screen mt-5" style="max-height:860px">
        <table>
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">Fecha</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">ID Jornada</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left" colspan="15">getBet Row *</th>
                    <th class="px-6 py-2"></th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left" colspan="15">getPrevision Row **</th>
                    <th class="px-6 py-2"></th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left" colspan="15">Fixed Prevision ***</th>
                    <th class="px-6 py-2"></th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">*</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">**</th>
                    <th class="px-6 py-2 text-xs text-gray-500 text-left">***</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($workingDays as $workingDay)
                    @php $acumulable = 0; $acumulable2 = 0; $acumulable3 = 0; @endphp
                    <tr class="whitespace-nowrap">
                        <td class="px-6 py-2 text-sm text-gray-500">{{ $workingDay->league_date }}</td>
                        <td class="px-6 py-2 text-sm text-gray-500"><a class="underline" href="{{ route('journey', $workingDay->_id) }}">{{ $workingDay->_id }}</a></td>
                        @foreach ($workingDay->historics as $key => $partido)
                            @php $prevision = Helper::getBet($partido->local, $partido->visitor, true, $key); $isHit = $prevision == $partido->result; if ($isHit) { $acumulable++; } if ($prevision == $partido->resultWithGoals) { $acumulable++; } @endphp
                            @if($partido->resultWithGoals)
                                <td class="font-bold {{ $prevision == $partido->resultWithGoals ? 'text-blue-900' : 'text-red-300' }}">({{ $partido->resultWithGoals }})</td>
                            @else
                                <td class="font-bold {{ $prevision == $partido->result ? 'text-blue-900' : 'text-red-300' }}">{{ $partido->result }}</td>
                            @endif
                        @endforeach
                        <td class="px-6 py-2 text-sm text-gray-500"></td>
                        @foreach ($workingDay->historics as $key => $partido)
                            @php if ($key > 7) { $moreThanSix = true; } else { $moreThanSix = false; }
                                $prevision = Helper::getPrevision($partido->local, $partido->visitor, 1, $moreThanSix); 
                                $isHit = $prevision == $partido->result; if ($isHit) { $acumulable2++; } 
                            @endphp
                            @if($partido->resultWithGoals)
                                <td class="font-bold {{ $prevision == $partido->resultWithGoals ? 'text-blue-900' : 'text-red-300' }}">{{ $partido->resultWithGoals }}</td>
                            @else
                                <td class="font-bold {{ $prevision == $partido->result ? 'text-blue-900' : 'text-red-300' }}">{{ $partido->result }}</td>
                            @endif
                        @endforeach
                        <td class="px-6 py-2 text-sm text-gray-500"></td>
                        @foreach ($workingDay->historics as $key => $partido)
                            @php $prevision = Helper::fixedBet($key); $isHit = $prevision == $partido->result; if ($isHit) { $acumulable3++; } if ($prevision == $partido->resultWithGoals) { $acumulable3++; } @endphp
                            @if($partido->resultWithGoals)
                                <td class="font-bold {{ $prevision == $partido->resultWithGoals ? 'text-blue-900' : 'text-red-300' }}">({{ $partido->resultWithGoals }})</td>
                            @else
                                <td class="font-bold {{ $prevision == $partido->result ? 'text-blue-900' : 'text-red-300' }}">{{ $partido->result }}</td>
                            @endif
                        @endforeach
                        <td class="px-6 py-2 text-sm text-gray-500"></td>
                        <td class="px-6 py-2 text-sm {{ $acumulable >= 10 ? 'text-blue-900 font-bold' : 'text-gray-400' }}">{{ $acumulable }}</td>
                        <td class="px-6 py-2 text-sm {{ $acumulable2 >= 10 ? 'text-blue-900 font-bold' : 'text-gray-400' }}">{{ $acumulable2 }}</td>
                        <td class="px-6 py-2 text-sm {{ $acumulable3 >= 10 ? 'text-blue-900 font-bold' : 'text-gray-400' }}">{{ $acumulable3 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection