<?php include('../config/constants.php');?>
<?php 
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;

$sql = 'SELECT `id`,`food`,`price`,`qty`,`total` FROM `tbl_order` WHERE status = "Delivered"';
$result = mysqli_query($conn, $sql);


$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Document</title>
    <!-- CSS only -->
    
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor"
     crossorigin="anonymous"> -->

    <style>
        h2{
            
            text-align: center
        }
        table{
            font-family: Arial,sans-serif;
            border-collapse:collapse;
            width:100%
        }
        td,th{
            border: 1px solid #444;
            padding:8px; 
            text-align:left;
        }

        .my-table{
            text-align: right;
        }

        #sign{
            padding-top:50px;
            text-align:right;
        }
    </style>
</head>
<body>
    <h2 class="italic">Invoice</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Unit price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>';
        
        
        $gtotal = 0 ;
        $i = 1;
        while($row=mysqli_fetch_assoc($result))
        {
            //Get the Values
            $id = $i;
            $item = $row['food'];
            $unit_price = $row['price'];
            $quantity = $row['qty'];
            $total = $row['total'];
            $gtotal+=$total;
            $i+=1;
            

       
       $html.= '<tr>
        <td>'.$id.'</td>
        <td>'.$item.'</td>
        <td>'.$unit_price.'</td>
        <td>'.$quantity.'</td>
        <td>'.$total.'</td>

        </tr>' ;
            
        }
        
        $html.='</tbody>
        <tr>
            <th colspan="4" class="my-table">Grand Total</th>
            <th>'.$gtotal.'</th>

        </tr>
        </table>
        <h3>Note : Only delivered orders will appear here </h3> 
    </body>
    </html>
       ';
        
    $dompdf = new Dompdf();
        $dompdf->loadHtml($html); 
         
        // (Optional) Setup the paper size and orientation 
        $dompdf->setPaper('A4', 'landscape'); 
         
        // Render the HTML as PDF 
        $dompdf->render(); 
         
        // Output the generated PDF to Browser 
        $dompdf->stream();


?>