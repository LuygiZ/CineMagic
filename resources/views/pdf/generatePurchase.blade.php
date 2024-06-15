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
    .card {
        border: 1px solid black;
        border-radius: 20px;
        padding: 5px;
        margin-bottom: 50px;
        background-color: rgb(243, 243, 243);
    }
    .qrcode {
        margin: auto;
        width: 30%;
    }
    .ticketInfo {
        margin-left: 25px;
    }

</style>
<body>
    <h1 class="title">CineMAGIC</h1>
    <hr>
    <h2>Informações da Compra</h2>
    <hr>
    <h3>Número da Compra: {{ $purchase->id }}</h3>
    <h3>Cliente: {{ $purchase->customer_name }}</h3>
    <h3>Data da Compra: {{ $purchase->date }}</h3>
    <h3>Email: {{ $purchase->customer_email}}</h3>
    <h3>Total: {{ $purchase->total_price }}€</h3>
    <hr>
    <h2>Bilhetes</h2>
    <hr>
    <br><br>
    @foreach ($tickets as $ticket)
        <div class="card">
            <div class="qrcode">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate("http://cinemagic.test/screenings/ticket/verify?ticketCode=".$ticket->qrcode_url)) !!} ">
            </div>
            <div class="ticketInfo">
                <h3>Filme: {{ $ticket->Screening->Movie->title }}</h3>
                <h3>Sala: {{ $ticket->Seat->Theater->name }}</h3>
                <h3>Lugar: {{ $ticket->Seat->row}}{{ $ticket->Seat->seat_number}}</h3>
                <h3>Codigo: {{$ticket->qrcode_url}}</h3>
            </div>
        </div>
    @endforeach
</body>
</html>
