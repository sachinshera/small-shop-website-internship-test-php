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
<!-- a section for add invoice  with customer_name , invoice_number and invoice date-->
<section class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Add New Invoice</h1>
            <form action="invoices.php" method="POST" class="w-50">
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Enter Customer Name">
                </div>
                <div class="mb-3">
                    <label for="invoice_number" class="form-label">Invoice Number</label>
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Enter Invoice Number">
                </div>
                <div class="mb-3">
                    <label for="invoice_date" class="form-label">Invoice Date</label>
                    <input type="text" class="form-control" id="invoice_date" name="invoice_date" placeholder="Enter Invoice Date">
                </div>
                <button type="submit" class="btn btn-primary" name="add_invoice">Add Invoice</button>
            </form>
        </div>
    </div>
</section>

<!-- a section for get all invoice with delete option -->
<section class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">All Invoices</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Invoice Number</th>
                        <th scope="col">Invoice Date</th>
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
            // add invoice with form data to /api/invoices
            $("form").submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: "/api/invoices",
                    type: "POST",
                    data: new FormData(this),
                    contentType:false,
                    processData:false,
                    success: function(data){
                        getInvoices();
                       alert("invoice added successfully");
                    },
                    error:function(){
                        console.log("Failed to add invoice");
                    }
                })
            });

            // get all invoice with delete action
           function getInvoices(){
            $.ajax({
                url: "/api/invoices",
                type: "GET",
                success: function(data){

                    $("tbody").html("");
                    var invoices = data;
                    invoices.forEach(function(invoice){
                        $("tbody").append(`
                            <tr>
                                <td>${invoice.customer_name}</td>
                                <td>${invoice.invoice_number}</td>
                                <td>${invoice.invoice_date}</td>
                                <td>
                                    <button class="btn btn-danger delete_invoice" data-id="${invoice.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });

                    // delete invoice
                    $(".delete_invoice").click(function(){
                        var id = $(this).data("id");
                        // assigen in formData the name of invoice_id
                        var formData = new FormData();
                        formData.append("invoice_id", id);
                        $.ajax({
                            url: "/api/invoices",
                            type: "DELETE",
                            data:formData,
                            processData:false,
                            contentType:false,
                            success: function(data){
                                alert("invoice deleted successfully");
                                getInvoices();
                            },
                            error:function(){
                                console.log("Failed to delete invoice");
                            }
                        })
                    });
                },
                error:function(){
                    console.log("Failed to get all invoices");
                }
            });
           }

           getInvoices();
        })
    </script>
</body>
</html>