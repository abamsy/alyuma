<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Allocation</title>
        <style>
           table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
            
        </style>
    </head>
    <body>
        <h2>Allocation Of {{ $allocation->quantity }} (MT) Of {{ $allocation->product->name }}
                Lifted From {{ $allocation->point->name }} To Be Deliverd To {{ $allocation->plant->name }} {{ $allocation->plant->state }}
                Dated {{ ( Carbon\Carbon::parse($allocation->allocated_at)->format('d M Y')) }}</h1>
        <table style="width:100%">
            <caption>
                
            </caption>
            <tr>
                <th>Blending Plant</th>
                <td colspan="2">{{ $allocation->plant->name }}</td>
            </tr>
            <tr>
                <th>Location</th>
                <td colspan="2">{{ $allocation->plant->state }}</td>
            </tr>
            <tr>
                <th>Product</th>
                <td colspan="2">{{ $allocation->product->name }}</td>
            </tr>
        </table>
        <br>
        
        <table>
            <thead>
                <tr>
                    <th>Waybill No.</th>
                    <th>Date</th>
                    <th>Lifted QTY (MT)</th>    
                </tr>   
            </thead>
            <tbody>
                @foreach ($waybills as $waybill)
                <tr>
                    <td>{{ str_pad($waybill->id,6,'0',STR_PAD_LEFT) }}</td>
                    <td>{{ ( Carbon\Carbon::parse($waybill->dispatched_at)->format('d M Y')) }}</td>
                    <td >{{ $waybill->dquantity }}</td>    
                </tr>
                @endforeach
                <tr>
                    <th colspan="2" style="text-align: right">Total Lifted QTY</th>
                    <td colspan="2" style="text-align: right">{{ $sum }}</td>
                <tr>
                    <th colspan="2" style="text-align: right">Released QTY</th>
                    <td colspan="2" style="text-align: right">{{ $allocation->quantity }}</td>
                </tr>
                <tr>
                    <th colspan="2" style="text-align: right">Balance</th>
                    <td colspan="2" style="text-align: right">{{ $balance }}</td>
                </tr>
            </tbody>
        </table>

    </body>
</html>