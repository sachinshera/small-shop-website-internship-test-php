<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    <?php 
       $currentPage = $_SERVER["REDIRECT_URL"];
       echo str_replace("/", "", $currentPage);
    ?>
    </title>
   
    <?php include "../includes/cdn.php"; ?>
</head>
<body>
<?php include "../includes/header.php"; ?>

<!-- a section for add new products -->
<section class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Add New Product</h1>
            <form action="products.php" method="POST" class="w-50">
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Enter Product Name">
                </div>
                <div class="mb-3">
                    <label for="product_price" class="form-label">Product Unit Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter Product Price">
                </div>
                <div class="mb-3">
                    <label for="product_quantity" class="form-label">Product Quantity</label>
                    <input type="text" class="form-control" id="product_quantity" name="product_quantity" placeholder="Enter Product Quantity">
                </div>
                <button type="submit" class="btn btn-primary" name="add_product">Add Product</button>
            </form>
        </div>
    </div>

</section>

<!-- show all products section  -->

<section class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">All Products</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Product Price</th>
                        <th scope="col">Product Quantity</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            // get all product data 
          function getProducts(){
            $.ajax({
                url: "/api/products",
                type: "GET",
                success: function(data){
                    $("tbody").html("");
                    console.log(data);
                    var products = data;
                    var html = "";
                    for(var i=0; i<products.length; i++){
                        html += "<tr>";
                        html += "<td>"+products[i].id+"</td>";
                        html += "<td>"+products[i].name+"</td>";
                        html += "<td>"+products[i].unit_price+"</td>";
                        html += "<td>"+products[i].quantity+"</td>";
                       
                        html += "<td><a href='products.php?delete_product_id="+products[i].id+"' class='btn btn-danger delete-btn btn-sm'>Delete</a></td>";

                        html += "</tr>";
                    }
                    $("tbody").html(html);

                    $("section .delete-btn").click(function(e){
                e.preventDefault();
                var delete_product_id = $(this).attr("href").split("=")[1];
                // assign product_id into formData
                var formData = new FormData();
                formData.append("product_id", delete_product_id);
                $.ajax({
                    url: "/api/products",
                    data: formData,
                    type: "DELETE",
                    contentType:false,
                    processData:false,
                    success: function(data){
                        console.log(data);
                        getProducts();
                        alert("Product Deleted Successfully");
                    },error:function(errrr){
                        console.log(errrr);
                        alert("Something went wrong");
                    }
                });
            });
                }
            });
          }

          getProducts();

            // add product when form will submit

            $("form").submit(function(e){
                e.preventDefault();
                var product_name = $("#product_name").val();
                var product_price = $("#product_price").val();
                var product_quantity = $("#product_quantity").val();

                $.ajax({
                    url: "/api/products",
                    type: "POST",
                    data: {
                        name: product_name,
                        unit_price: product_price,
                        quantity: product_quantity
                    },
                    success: function(data){
                        getProducts();
                        alert("Product Added Successfully");
                    },error:function(){
                        alert("Something went wrong");
                    }
                });
            });
        });
    </script>

</body>
</html>