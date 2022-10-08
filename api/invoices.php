<?php 

//set contentType to json

header("Content-Type: application/json; charset=UTF-8");
include "db.php";
include "extractData.php";

// use GET,POST,PUT and DELETE

// get all invoices from invoices table

// check methods

if($_SERVER['REQUEST_METHOD'] == "GET"){
    // get all invoices from invoices table
    $sql = "SELECT * FROM invoices";
    $result = $db->query($sql);
    if($result){
        $invoices = array();
        while($row = $result->fetch_assoc()){
            $invoices[] = $row;
        }
        // return all invoices as json
        // set 200 status code
        http_response_code(200);
        echo json_encode($invoices);
    }else{
        // set 500 status code
        http_response_code(500);
        echo json_encode(array("message" => "Internal Server Error"));
    }
}
else if ($_SERVER['REQUEST_METHOD'] == "POST"){
    // intsert the invoice into the database check if invoice_id not exist
    // check customer_name , invoice_number and invoice_date in post request
    if(isset($_POST['customer_name']) && isset($_POST['invoice_number']) && isset($_POST['invoice_date'])){
        $customer_name = $_POST['customer_name'];
        $invoice_number = $_POST['invoice_number'];
        $invoice_date = $_POST['invoice_date'];
        // insert into database
        $sql = "INSERT INTO invoices(customer_name,invoice_number,invoice_date) VALUES('$customer_name','$invoice_number','$invoice_date')";
        $result = $db->query($sql);
        if($result){
            // set 201 status code
            http_response_code(201);
            echo json_encode(array("message" => "Invoice added successfully"));
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
    // update the invoice into the database check if invoice_id exist
    // check customer_name ,invoice_number and invoice_date in put method
    $invoice_id = PUT("invoice_id");
    $customer_name = PUT("customer_name");
    $invoice_date = PUT("invoice_date");
    $invoice_number = PUT("invoice_number");
    if($invoice_number && $customer_name && $invoice_date){
        // update into database
        $sql = "UPDATE invoices SET customer_name='$customer_name',invoice_date='$invoice_date',invoice_number  = '$invoice_number' WHERE id='$invoice_id'";
        $result = $db->query($sql);
        if($result){
            // set 200 status code
            http_response_code(200);
            echo json_encode(array("message" => "Invoice updated successfully"));
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
}else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
    // delete the invoice from the database check if invoice_id exist
    // check invoice_id in delete method
    $invoice_id = delete("invoice_id");
    if($invoice_id){
        // delete from database
        $sql = "DELETE FROM invoices WHERE id='$invoice_id'";
        $result = $db->query($sql);
        if($result){
            // set 200 status code
            http_response_code(200);
            echo json_encode(array("message" => "Invoice deleted successfully"));
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
}else{
    // set 405 status code
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}

?>