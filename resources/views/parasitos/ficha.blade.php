<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Ficha de Laboratorio</title>

<style>

*{
    box-sizing:border-box;
}

body{

    font-family: DejaVu Sans, sans-serif;

    margin:0;

    color:#1f2937;

    background:white;

}

.header{

    background:#000000;

    color:#fff;

    text-align:center;

    padding:35px 30px 30px;

}

.logo{

    width:95px;

    height:auto;

    margin-bottom:18px;

}

.header h1{

    margin:0;

    font-size:30px;

    font-weight:bold;

    line-height:1.25;

}

.header p{

    margin-top:18px;

    font-size:18px;

    color:#d1fae5;

}

.banner{

    width:100%;

    height:220px;

    overflow:hidden;

}

.banner img{

    width:100%;

    height:100%;

    object-fit:cover;

}

.content{

    padding:25px;

}

.title{

    color:#166534;

    font-size:26px;

    font-weight:bold;

}

.scientific{

    color:#6b7280;

    font-size:18px;

    margin-top:5px;

    font-style:italic;

}

table{

    width:100%;

    margin-top:25px;

    border-collapse:collapse;

}

td{

    padding:10px;

    border-bottom:1px solid #ddd;

}

.qr{

    margin-top:35px;

    text-align:center;

}

.qr img{

    width:220px;

}

.features{

    margin-top:35px;

    padding:20px;

    background:#ecfdf5;

    border-radius:10px;

}

.features p{

    margin:8px 0;

    color:#166534;

    font-size:15px;

}

.footer{

    margin-top:25px;

    text-align:center;

    color:#6b7280;

    font-size:13px;

}

</style>

</head>

<body>

<div class="header">

    <img
        src="{{ public_path('images/logo-utp.png') }}"
        class="logo"
    >

    <h1>
        Atlas Interactivo de
        <br>
        Parasitología Animal
    </h1>

    <p>
        Universidad Tecnológica de Pereira
    </p>

</div>

<div class="banner">

    <img src="{{ public_path('storage/'.$parasito->imagen_principal) }}">

</div>

<div class="content">

    <div class="title">

        {{ $parasito->nombre_comun }}

    </div>

    <div class="scientific">

        {{ $parasito->nombre_cientifico }}

    </div>

    <table>

        <tr>

            <td><strong>Familia</strong></td>

            <td>{{ $parasito->familia }}</td>

        </tr>

        <tr>

            <td><strong>Género</strong></td>

            <td>{{ $parasito->genero }}</td>

        </tr>

    </table>

    <div class="qr">

        <img
            src="data:image/png;base64,{{ $qr }}"
            style="width:220px"
        >

        <p>

            Escanee el código QR para acceder a la ficha científica interactiva.

        </p>

    </div>

    <div class="features">

        <p>✔ Información científica</p>

        <p>✔ Partes anatómicas</p>

        <p>✔ Mapa epidemiológico</p>

        <p>✔ Cuestionario interactivo</p>

        <p>✔ Realidad aumentada (WebAR)</p>

    </div>

    <div class="footer">

        Sistema Web para la Gestión de Información sobre Parasitología Animal

    </div>

</div>

</body>

</html>