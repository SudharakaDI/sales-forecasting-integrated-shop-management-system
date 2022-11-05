<?php include('../config/constants.php');?>
<?php 
require_once '../vendor/autoload.php';
use Dompdf\Dompdf;


$sql = 'SELECT `id`,`food`,`price`,`qty`,`total` FROM `tbl_order`';
$result = mysqli_query($conn, $sql);



// //Count the Rows
// $count = mysqli_num_rows($res);
// $stmt = $conn->prepare($sql);
// $stmt->execute();
// $rows=$stmt->fetchAll(PDO::FETCH_ASSOC);
// $gt=0;
// $i=1;


// $html = '<!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="utf-8">
//     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
//     <title>Document</title>
//     <!-- CSS only -->
   
// </head>
// <body>
//     <h2 class="italic">Invoice</h2>
//     <table class="table table-bordered">
//         <thead>
//             <tr>
//                 <th scope="col">ID</th>
//                 <th scope="col">Item</th>
//                 <th scope="col">Unit price</th>
//                 <th scope="col">Quantity</th>
//                 <th scope="col">Total</th>
//             </tr>
//         </thead>
//         <tbody>';

//         foreach($rows as $row){
//             $html.= '<tr>
//                 <td>'.$row['id'].'</td>
//                 <td><div class="italic">'.$row['food'].'</div></td>
//                 <td>'.$row['price'].'</td>
//                 <td>'.$row['qty'].'</td>
//                 <td>'.$row['total'].'</td>
            
//             <tr>';


            
//         }

//     $html.='</table>

    
//     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>    
// </body>
// </html>';

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Document</title>
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
    <!-- CSS only -->

    
</head>
<body>
    <h2 class="italic">Invoice</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Unit price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>';?>
 
            <?php 
            $gtotal = 0 ;
            $counter = 1;
            while($row=mysqli_fetch_assoc($result))
            {
                //Get the Values
                $id = $row['id'];
                $item = $row['food'];
                $unit_price = $row['price'];
                $quantity = $row['qty'];
                $total = $row['total'];
                $gtotal+=$total;

                $html.= '<tr>
                <td><?php echo $id ;?></td>
                <td><?php echo $item ;?></td>
                <td><?php echo $unit_price ;?></td>
                <td><?php echo $quantity ;?></td>
                <td><?php echo $total ;?></td>
    
                </tr>';
                ?>
            
            
                <?php
            }
            ?>
            <?php
            $html.=  '</tbody>
        </table>
   

       


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>';



       
$dompdf = new Dompdf;
$dompdf->loadHtml($html);
$dompdf->setPaper('A4','portrait');
$dompdf->render();
$dompdf->stream('invoice.pdf');

?>

