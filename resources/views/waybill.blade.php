<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Waybill</title>

        
       

        <style>
            .waybill{
                border-collapse: collapse;
                width:14cm;
            }
            .waybill th{
                border:2px solid #000;
                border-top: none;
                border-left: none;
                border-right: none;
                font-family: Arial, Helvetica, sans-serif;
            }

            .waybill td{
                border:2px solid #000;
                border-top: none;
                border-left: none;
                border-right: none;
                border-bottom: none;
                text-align: center;
                font-family: Arial, Helvetica, sans-serif;
            }
        </style>
    </head>
    <body> 
        
        <div>
            <img src = "storage/AL-YUMA LOGO.png" alt="" style="height:2.8cm; padding-left:1cm;">
            <img src = "storage/COAT_OF_ARMS.png" alt="" style="width:3cm; margin-bottom:0.3cm; padding-left:1cm;">
        </div>
           
        <h2 style="text-align: center; margin-top:0cm; margin-right:1cm; color:green;  font-family: Arial, Helvetica, sans-serif; font-weight: bold;">PRESIDENTIAL FERTILIZER INITIATIVE 2020</h2>

        <div style="text-align: center; margin-left:1.5cm; background-color:gainsboro; margin-right:2.4cm; margin-top:-1cm;">
            <h3 style="color:firebrick;  font-family: Arial, Helvetica, sans-serif;">WAYBILL #{{ str_pad($waybill->id,6,'0',STR_PAD_LEFT) }}</h3>
        </div>
        
        <div style="margin-left:1.9cm; margin-top:-0.9cm;">
            <h5 style="font-family: Arial, Helvetica, sans-serif;"><span style="padding-left:11cm;">Date: {{ Carbon\Carbon::parse($waybill->dispatched_at)->format('Y-m-d') }}</span><br\><span style="padding-left:11cm;">Truck No: {{ $waybill->truck }}</span></h5>
        </div>

        <div style="margin-left:1.9cm; margin-top:0.5cm;">
            <h4 style="font-family: Arial, Helvetica, sans-serif;"><span style="padding-right:0.2cm;">From:</span><span style="padding-left:0.5cm;">{{ $waybill->allocation->point->name }}</span><br\><span style="padding-left:1.9cm;">{{ $waybill->allocation->point->address }}, {{ $waybill->allocation->point->city }}</span><br\><span style="padding-left:1.9cm;">{{ $waybill->allocation->point->state }}</span></h4>
            <h4 style="font-family: Arial, Helvetica, sans-serif;"><span style="padding-right:0.2cm; margin-left:0.5cm;">To:</span><span style="padding-left:0.5cm;">{{ $waybill->allocation->plant->name }}</span><br\><span style="padding-left:1.9cm;">{{ $waybill->allocation->plant->address }}, {{ $waybill->allocation->plant->city }}</span><br\><span style="padding-left:1.9cm;">{{ $waybill->allocation->plant->state }}</span></h4>
        </div>

        <div style="margin-top:-1cm; margin-bottom:1.5cm;">
        <h4 style="font-family: Arial, Helvetica, sans-serif;"><span style="padding-left:11cm;">Driver:</span><span style="padding-left:0.2cm;">{{ $waybill->driver }}</span><br\><span style="padding-left:12.5cm;">{{ $waybill->dphone }}</span><br\></h4>
        </div>

        <div style="margin-left:1.9cm; margin-bottom:1cm;">
        <table class="waybill">
            <tr>
                <th>PRODUCT</th>
                <th>QUANTITY</th>
                <th>NUMBER OF BAGS</th>
            </tr> 
            <tr>
                <td>{{ $waybill->allocation->product->name }}</td>
                <td>{{ $waybill->dquantity }}MT</td>
                <td>{{ $waybill->dbags }} bags</td>
            </tr>
        </table>
        </div>

        <div style="margin-left:1.9cm;">
            <h3 style="font-family: Arial, Helvetica, sans-serif;">RECEIVER'S PHONE NUMBER<br\><span style="padding-left:0cm; font-size: 40px; color:firebrick;">{{ $waybill->allocation->plant->user->phone }}</span><br\></h3>
        </div>
        
        <br\>
        
        <div style="text-align: center; background-color:gainsboro; position: absolute;  bottom: 0;">
            <h5 style=" font-family: Arial, Helvetica, sans-serif;">The above mentioned program was initiated by the Federal Government under the administration of his excellency president Muhammadu Buhari in order to over powered the farming sector and to boost the economy of the country.</h5>
            <h5 style="font-size: 12px; color:firebrick; font-family: Arial, Helvetica, sans-serif;">EMERGENCY CONTACTS: 0815 232 3835, 0703 304 1728</h5>
        </div>

    </body>
</html>
