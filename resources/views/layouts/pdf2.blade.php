<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

        @page {
                margin: 0cm 0cm;
            }

            /** Define now the real margins of every page in the PDF **/
            body {
                margin-top: 2cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }

            /** Define the header rules **/
            header {
                position: fixed;
                top: 0cm;
                left: 0cm;
                right: 0cm;
                height: 2cm;

                /** Extra personal styles **/

                text-align: center;
                line-height: 1.5cm;
            }


            #headerB {
                position: fixed;
                left: -20px; right: -20px; top: 0px;
                text-align: center;
            }

            /** Define the footer rules **/
            footer {
                position: fixed;
                bottom: 0cm;
                left: 0cm;
                right: 0cm;
                height: 1.5cm;

                /** Extra personal styles **/
                background-color: #837A79;
                color: white;
                text-align: center;
                line-height: 0.5cm;
            }
    </style>
</head>
<body>

    <div class="headerB">
            <img class="float-left rounded " src="{{public_path('logoCoop.jpg')}}" style="width:70px; height:70px">
    </div>
    <header>
        COOPERATIVA DE AGUA POTABLE
    </header>

    <section >
        @yield('content')
    </section>
    <footer>
        <p>
            Dirección: Av. 9 de Julio
            <br>
            Telefono: 3758-569554
        </p>
    </footer>
</body>
</html>
