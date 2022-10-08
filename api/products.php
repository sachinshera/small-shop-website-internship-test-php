<?php
// set contentType to json
header("Content-Type: application/json; charset=UTF-8");
//include db
include "db.php";
include "extractData.php";

// use GET,POST,PUT and DELETE

// get all products from products table
// check methods

if($_SERVER['REQUEST_METHOD'] == "GET"){
    // get all products from products table
    $sql = "SELECT * FROM products";
    $result = $db->query($sql);
    if($result){
        $products = array();
        while($row = $result->fetch_assoc()){
            $products[] = $row;
        }
        // return all products as json
        // set 200 status code
        http_response_code(200);
        echo json_encode($products);
    }else{
        // set 500 status code
        http_response_code(500);
        echo json_encode(array("message" => "Internal Server Error"));
    }
}
else if ($_SERVER['REQUEST_METHOD'] == "POST"){
    // intsert the product into the database check if product_id not exist
    // check name , unit_price and quantity in post request
    if(isset($_POST['name']) && isset($_POST['unit_price']) && isset($_POST['quantity'])){
        $name = $_POST['name'];
        $unit_price = $_POST['unit_price'];
        $quantity = $_POST['quantity'];
        // insert into database
        $sql = "INSERT INTO products(name,unit_price,quantity) VALUES('$name','$unit_price','$quantity')";
        $result = $db->query($sql);
        if($result){
            // set 201 status code
            http_response_code(201);
            echo json_encode(array("message" => "Product added successfully"));
        }else{
            // set 500 status code
            http_response_code(500);
            echo json_encode(array("message" => "Internal Server Error"));
        }
    }else{
        // set 400 status code
        http_response_code(400);
        echo json_encode(array("message" => "Bad Request"));
    }
}

else if ($_SERVER['REQUEST_METHOD'] == "PUT"){
    // update the product into the database check if product_id exist
    // check name , unit_price and quantity in post request
    if(PUT("name")  && PUT("unit_price")   && PUT("quantity") && PUT("product_id") ){
        $name = PUT("name");
        $unit_price = PUT("unit_price");
        $quantity = PUT("quantity");
        $id = PUT("product_id");
        // insert into database
        $sql = "UPDATE products SET name = '$name', unit_price = '$unit_price', quantity = '$quantity' WHERE id = '$id'";
        $result = $db->query($sql);
        if($result){
            // set 201 status code
            http_response_code(201);
            echo json_encode(array("message" => "Product updated successfully"));
        }else{
            // set 500 status code
            http_response_code(500);
            echo json_encode(array("message" => "Internal Server Error"));
        }
    }else{
        // set 400 status code
        http_response_code(400);
        echo json_encode(array("message" => "Bad Request"));
    }
}

else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    // delete the product into the database check if product_id exist
    // check name , unit_price and quantity in post request
    if(delete("product_id")){
        $id = delete("product_id");
        // delete from database
        $sql = "DELETE FROM products WHERE id = '$id'";
        $result = $db->query($sql);
        if($result){
            // set 201 status code
            http_response_code(201);
            echo json_encode(array("message" => "Product deleted successfully"));
        }else{
            // set 500 status code
            http_response_code(500);
            echo json_encode(array("message" => "Internal Server Error"));
        }
    }else{
        // set 400 status code
        http_response_code(400);
        echo json_encode(array("message" => "Bad Request"));
    }
}

else{
    // set 405 status code
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}



?>