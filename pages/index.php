<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    <?php 
        include "../api/db.php";
       $currentPage = $_SERVER["REDIRECT_URL"];
       echo str_replace("/", "", $currentPage);
    ?>
    </title>
   
    <?php include "../includes/cdn.php"; ?>
</head>
<body>

<?php include "../includes/header.php"; ?>

<div class="container">
    <h1>Variation 1 </h1> 
    <!-- List all products and the total value of quantity * unit price is
shown, well
formatted in INR currency  -->

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Unit Price</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php


                $sql = "SELECT * FROM products";
                $result = mysqli_query($conn, $sql);
                $total = 0;
                while($row = mysqli_fetch_assoc($result)){
                    $total = $total + ($row['quantity'] * $row['unit_price']);
                    echo "<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['quantity']."</td>
                            <td>".$row['unit_price']."</td>
                            <td>".$row['quantity'] * $row['unit_price']."</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
    <h3>Total: <?php echo $total; ?></h3>
</div>

<div class="container">
    <h1>Variation 2</h1>
   <!-- Get invoice by customer name  from invoices table use dropdown for select name -->
    <form action="/" method="post">
        <div class="form-group">
            <label for="customerName">Customer Name</label>
            <select class="form-control" name="name" id="customerName">
                <?php
                    $sql = "SELECT * FROM customers";
                    $result = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<option value='".$row['name']."'>".$row['name']."</option>";
                    }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $customerName = $_POST['name'];
            // get data from invoices table
            $sql = "SELECT * FROM invoices WHERE customer_name = '$customerName'";
            $result = mysqli_query($conn, $sql);
            $total = 0;
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>".$row['customer_name']."</td>
                        <td>".$row['invoice_number']."</td>
                        <td>".$row['invoice_date']."</td>
                        
                    </tr>";
            }
        }
    ?>


</div>

</body>
</html>