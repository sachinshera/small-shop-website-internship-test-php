<?php
// set contenttype to json
header('Content-Type: application/json');
    include "db.php";
    include "extractData.php";
    // check method
    if($_SERVER['REQUEST_METHOD'] == "GET"){

        // get all customers from customers table
        $sql = "SELECT * FROM customers";
        $result = $db->query($sql);
        if($result){
            $customers = array();
            while($row = $result->fetch_assoc()){
                $customers[] = $row;
            }
            // return all customers as json
            // set 200 status code
            http_response_code(200);
            echo json_encode($customers);
        }else{
            // set 500 status code
            http_response_code(500);
            echo json_encode(array("message" => "Internal Server Error"));
        }
       
        
    }else if ($_SERVER['REQUEST_METHOD'] == "POST"){
        // inter the customer into the database check if login_id not exist
        // check login_id ,name and phone in post request
        if(isset($_POST['login_id']) && isset($_POST['name']) && isset($_POST['phone'])){
            $login_id = $_POST['login_id'];
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            // check if login_id exist
            $sql = "SELECT * FROM customers WHERE login_id = '$login_id'";
            $result = $db->query($sql);
            if($result && $result->num_rows > 0){
                // set 400 status code
                http_response_code(400);
                echo json_encode(array("message" => "Login Id already exist"));
            }else{
                // insert into database
                $sql = "INSERT INTO customers(login_id,name,phone) VALUES('$login_id','$name','$phone')";
                $result = $db->query($sql);
                if($result){
                    // set 201 status code
                    http_response_code(201);
                    echo json_encode(array("message" => "Customer created successfully"));
                }else{
                    // set 500 status code
                    http_response_code(500);
                    echo json_encode(array("message" => "Internal Server Error"));
                }
            }
        }else{
            // set 400 status code
            http_response_code(400);
            echo json_encode(array("message" => "Bad Request"));
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == "PUT"){
    
        // update name and phone of customer by login_id 
        // check login_id ,name and phone in post request
        if(PUT("login_id") && PUT("name") && PUT("phone")){
            $login_id = PUT("login_id");
            $name = PUT("name");
            $phone = PUT("phone");
            // check if login_id exist
            $sql = "SELECT * FROM customers WHERE login_id = '$login_id'";
            $result = $db->query($sql);
            if($result->num_rows > 0){
                // update into database
                $sql = "UPDATE customers SET name = '$name', phone = '$phone' WHERE login_id = '$login_id'";
                $result = $db->query($sql);
                if($result){
                    // set 200 status code
                    http_response_code(200);
                    echo json_encode(array("message" => "Customer updated successfully"));
                }else{
                    // set 500 status code
                    http_response_code(500);
                    echo json_encode(array("message" => "Internal Server Error"));
                }
            }else{
                // set 400 status code
                http_response_code(400);
                echo json_encode(array("message" => "Login Id not exist"));
            }
        }else{
            // set 400 status code
            http_response_code(400);
            echo json_encode(array("message" => "Bad Request"));
        }
        
    }
    else if ($_SERVER['REQUEST_METHOD'] == "DELETE"){
        // delete customer by login_id
        // check login_id in delete method

    
        if(delete("id")){
            $login_id = delete("id");
            // check if login_id exist
            $sql = "SELECT * FROM customers WHERE id = '$login_id'";
            $result = $db->query($sql);
            if($result->num_rows > 0){
                // delete from database
                $sql = "DELETE FROM customers WHERE id = '$login_id'";
                $result = $db->query($sql);
                if($result){
                    // set 200 status code
                    http_response_code(200);
                    echo json_encode(array("message" => "Customer deleted successfully"));
                }else{
                    // set 500 status code
                    http_response_code(500);
                    echo json_encode(array("message" => "Internal Server Error"));
                }
            }else{
                // set 400 status code
                http_response_code(400);
                echo json_encode(array("message" => "Login Id not exist"));
            }
        }
    }
    else{
        echo json_encode(array(
            "message" => "Request Not Allowed"
        ));
    }

    // some functions

    

    
?>