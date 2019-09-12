<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cooperativa de Agua</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif;
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 5%;
        margin-right: 44%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: -3%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 14px;
        }

        #user{
        /*position: relative;*/
        float: right;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: -19%;
        font-size: 10px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #titulo{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fv, #fac{
        color: #000000;
        font-size: 15px;
        }
        #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #facliente thead{
        padding: 20px;
        background: #FFFFFF;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;
        }

        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;
        }

        #lista{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #lista thead{
        padding: 20px;
        background: #000000;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;
        }

        #gracias{
        text-align: center;
        }
    </style>
    <body>
        <header>

        <div id="logo">
                <a ><img id="imagen" class="float-left rounded " src="{{public_path('img/logoCoop.jpg')}}"> </a>
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>Cooperativa de Agua Potable</b><br>Av. 9 de Julio 1368, San Jose - Misiones, Argentina<br>Telefono:(+54)3758655665<br>Email:coop_agua@gmail.com
                </p>
            </div>

            <div id="fact">
                <p>Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y')}}</p>
            </div>

            <div id="user">
                Generado por: {{ Auth::user()->name . ' ' . Auth::user()->apellido }}
            </div>

        </header>
        <br>
        <section>
                @yield('content')
        </section>
        <br>
        <br>
        <div class="izquierda">
        <p><strong>Total de registros: </strong>10</p>
    </div>
    </body>
</html>
