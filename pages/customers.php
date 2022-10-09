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
    <!-- a section for add customer with cuatomer name , login and phone -->
    <section class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">Add New Customer</h1>
                <form action="customers.php" method="POST" class="w-50">
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Customer Name">
                    </div>
                    <div class="mb-3">
                        <label for="customer_login" class="form-label">Customer Login</label>
                        <input type="text" class="form-control" id="login_id" name="login_id" placeholder="Enter Customer Login">
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Customer Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Customer Phone">
                    </div>
                    <button type="submit" class="btn btn-primary" name="add_customer">Add Customer</button>
                </form>
            </div>
        </div>

    </section>

    <!-- a section for show all customers -->
    <section class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">All Customers</h1>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Customer Login</th>
                            <th scope="col">Customer Phone</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <script>
        $(document).ready(function() {
            // add customer when form submit from form data to /api/customers
            $("form").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "/api/customers",
                    type: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        getCUstomers();
                        alert("customer added successfully");
                    },
                    error: function(error) {
                        alert("failed to add customer");
                    }
                })
            });

            // get all customers from /api/customers

            function getCUstomers() {
                $.ajax({
                    url: "/api/customers",
                    type: "GET",
                    success: function(data) {
                        console.log(data);
                        $("tbody").html("");
                        data.forEach(function(customer) {
                            $("tbody").append(`
                            <tr>
                                <td>${customer.name}</td>
                                <td>${customer.login_id}</td>
                                <td>${customer.phone}</td>
                                <td>
                                    
                                    <a href="/customers/delete.php?id=${customer.id}" class="btn btn-danger delete-customer-btn">Delete</a>
                                </td>
                            </tr>
                        `);
                        });

                        // delete customer from /api/customers

                        $(".delete-customer-btn").click(function(e) {
                            e.preventDefault();
                            var id = $(this).attr("href").split("=")[1];
                            // assign in formData
                            var formData = new FormData();
                            formData.append("id", id);
                            $.ajax({
                                url: "/api/customers",
                                type: "DELETE",
                                data: formData,
                                contentType: false,
                                processData: false,
                                success: function(data) {
                                    getCUstomers();
                                    alert("customer deleted successfully");
                                },
                                error: function(error) {
                                    alert("failed to delete customer");
                                }
                            })
                        });

                    },
                    error: function(error) {
                        alert("failed to get customers");
                    }
                });
            }

            getCUstomers();
        })
    </script>

</body>

</html>