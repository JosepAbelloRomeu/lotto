<html>

    <head>
        <style>
            table {
                border-collapse:separate; 
                border-spacing: 0.2em 0.4em;
            }
            .number {
                border: 2px solid #ff9990;
                color: #ff9990;
                padding: 2px 6px;
                text-align: center;
            }

            .number.hit {
                color: #70b14a !important;
                font-weight: bold;
            }
        </style>
    </head>

    <body>
        {!! $hitsHtml !!}
    </body>

</html>
