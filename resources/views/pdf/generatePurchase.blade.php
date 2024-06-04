<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CineMagic</title>
</head>

<style>
    .title {
        text-align: center;
        background-color: rgb(243, 243, 243);
        border-radius: 20px;
        padding: 20px;
        border: 1px solid black;
    }

    .card{
        border: 1px solid black;
        border-radius: 20px;
        padding: 5px;
        background-color: rgb(243, 243, 243);
    }

    .qrcode {
        margin: auto;
        width: 30%;
    }

    .ticketInfo{
        margin-left: 25px;
    }
</style>


<body>
    <h1 class="title">CineMAGIC</h1>
    <hr>
    <h2>Informações da Compra</h2>
    <hr>
    <h2>Bilhetes</h2>

    <div class="card">
        <div class="qrcode">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate($ticketCode)) !!} ">
        </div>
        <div class="ticketInfo">
            <h3>Filme: </h3>
            <h3>Sala: </h3>
            <h3>Lugar: </h3>
            <h3>Data: </h3>
        </div>
    </div>
</body>
</html>
