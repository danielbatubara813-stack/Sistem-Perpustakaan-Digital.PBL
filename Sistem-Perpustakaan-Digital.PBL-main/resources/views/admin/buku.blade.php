@extends('layout.app-admin')

@section('content')
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <title>List Buku</title>

        <style>
            body {
                font-family: Arial;
                background: #f4f6f9;
                padding: 30px;
            }

            /* grid buku */
            .container-buku {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 25px;
            }

            /* card buku */
            .buku-card {
                background: white;
                padding: 20px;
                border-radius: 10px;
                text-align: center;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            /* cover buku */
            .book-cover {
                width: 140px;
                height: 180px;
                margin: auto;
                background: #bdbdbd;
                border-radius: 6px;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .book-cover::before {
                content: "";
                position: absolute;
                left: 0;
                top: 0;
                width: 18px;
                height: 100%;
                background: #333;
            }

            .book-cover span {
                color: #777;
                letter-spacing: 4px;
                font-size: 18px;
                text-align: center;
            }

            h4 {
                margin-top: 15px;
                font-size: 14px;
            }
        </style>
    </head>

    <body>

        <div class="container-buku">

            <!-- 25 buku -->

            <script>
                for (let i = 1; i <= 25; i++) {
                    document.write(`
    <div class="buku-card">
    <div class="book-cover">
    <span>BOOK<br>COVER</span>
    </div>
    <h4>Buku ${i}</h4>
    </div>
    `)
                }
            </script>

        </div>

    </body>

    </html>
@endsection