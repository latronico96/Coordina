<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>
        @yield('title', 'Coordina')
    </title>
</head>

<body style="
    margin:0;
    padding:20px;
    background:#f3f4f6;
    font-family:Arial, Helvetica, sans-serif;
">

<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">

            <table width="600"
                   cellpadding="0"
                   cellspacing="0"
                   style="
                    background:#ffffff;
                    border-radius:10px;
                    padding:30px;
                   ">

                <tr>
                    <td>

                        <h1 style="
                            color:#2563eb;
                            margin-bottom:30px;
                        ">
                            Coordina
                        </h1>


                        @yield('content')


                        <hr style="
                            margin-top:40px;
                            border:none;
                            border-top:1px solid #ddd;
                        ">


                        <p style="
                            color:#777;
                            font-size:12px;
                        ">
                            Este mensaje fue enviado desde Coordina.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
