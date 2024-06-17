<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #e0e0e0;
        }
        .header {
            text-align: center;
            padding: 10px 0;
        }
        .header h1 {
            margin: 0;
        }
        .total {
            text-align: right;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Purchase Confirmation</h1>
        </div>
        <p>Hello, {{ $purchase->customer_name }}!</p>
        <p>Thank you for your purchase. Here are the pdf with the Tickets:</p>
        <br>
        <p class="total">Total: {{ $purchase->total_price }}€</p>
        <p>Sincerely,<br>CineMagic</p>
    </div>
</body>
</html>
