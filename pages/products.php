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



<h1 class="text-center">
    <?php echo "hellow sachin"; ?>
</h1>
    
</body>
</html>