<html>

    <body>
        <p>{{ implode(' ', $combination) }}</p>
        <table>
            @foreach ($counted as $indexCounted => $counted)
                <tr>
                    <td>{{ $indexCounted }}</td>
                    <td>{{ $counted }}</td>
                </tr>
            @endforeach
        </table>

    </body>
</html>

