<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #ff6600;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        .header .logo {
            position: absolute;
            top: 10px;
            left: 20px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #ff6600;
            border: 2px solid #ff9900;
            overflow: hidden;
        }
        .header .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            line-height: 80px; /* Center text vertically with logo */
            margin-left: 100px; /* Space for logo */
        }
        .donor-info-section {
            padding: 20px;
            margin-top:120px;
        }
        .donor-info-section h2 {
            background-color: #f74f22;;
            color: #fff;    
            margin-top: 0;
            font-size: 20px;
        }
        .donor-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .donor-info-table th,
        .donor-info-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .donor-info-table th {  
            width: 30%;
        }
        
    </style>
</head>
<?php 
 $year = date('y'); // e.g., '25' for 2025
    $randomNumber = str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);
    $code = 'GS-' . $year . $year . '-' . $randomNumber;

?>
<body>
    <div class="container" style="background-image: url('https://gausevasociety.com/donation-portal/public/assets/images/reiept-bg.jpg'); height: 989px; background-repeat: no-repeat; width: 705px;">
        <div class="donor-info-section">
            <table class="donor-info-table">
                <tr>
                    <th style="background-color: #f74f22;"><h2>Donor Information:</h2></th>
                    <td></td>
                </tr>
                </table>

            <table class="donor-info-table">
                <tr>
                    <th>Name :</th>
                    <td>{{@$user->name}}</td>
                </tr>
                <tr>
                    <th>PAN No :</th>
                    <td>{{@$user->pan_number}}</td>
                </tr>
                <tr>
                    <th>Address :</th>
                    <td>{{@$user->address}}</td>
                </tr>
                <tr>
                    <th>State :</th>
                    <td>{{@$user->state}}</td>
                </tr>
                <tr>
                    <th>Pin Code :</th>
                    <td>{{@$user->pincode}}</td>
                </tr>
                <tr>
                    <th>Country :</th>
                    <td>{{@$user->country}}</td>
                </tr>
                <tr>
                    <th>Receipt No :</th>
                    <td>{{$code}}</td>
                </tr>
                <tr>
                    <th>Date :</th>
                    <td>{{ \Carbon\Carbon::parse($date)->format('d-M-Y h:i A') }}</td>
                </tr>
                <tr>
                    <th>Payment Mode :</th>
                    <td>Online</td>
                </tr>
                <tr>
                    <th>Donation for Gausewa :</th>
                    <td></td>
                </tr>
                <tr>
                    <th>Amount :</th>
                    <td>{{@$amount}}</td>
                </tr>
                <tr>
                    <th>Amount in word :</th>
                    <td>{{$amount_in_words }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html> 