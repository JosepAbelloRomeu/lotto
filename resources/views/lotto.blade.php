<html>

    <body>
        <table>
            @foreach ($counted as $indexCounted => $counted)
                <tr>
                    <td>{{ $indexCounted }}</td>
                    <td>{{ $counted }}</td>
                </tr>
            @endforeach
        </table>
        <br>
        <table>
            @foreach ($results as $result)
                <tr>
                    @foreach ($result['numbers'] as $number)
                        <td @if ($number['color'] !== null)style="color: {{ $number['color'] }}"@endif>{{ $number['number'] }}</td>

                    @endforeach
                    @isset($result['shuffledNumbers'])
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        @foreach ($result['shuffledNumbers'] as $shuffledNumber)
                            <td>{{ $shuffledNumber }}</td>
                        @endforeach
                    @endisset
                </tr>
            @endforeach
        </table>

    </body>
</html>

