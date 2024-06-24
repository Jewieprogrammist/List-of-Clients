<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";
$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}


$name = "";
$email = "";
$phone = "";
$address = ""; 
$errorMessage = "";
$successMessage = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    do {
        if(empty($name) || empty($email) || empty($phone) || empty($address)){
            $errorMessage = "Все поля пусты!";
            break;
        }
        
        $sql = "INSERT INTO clients (name,email,phone,address)" . 
                "VALUES ('$name','$email','$phone','$address')";
        $result = $conn->query($sql);


        $name = "";
        $email = "";
        $phone = "";
        $address = ""; 
        
        $successMessage = "Клиент успешно добавлен";
        
        header("location: main.php");
        exit;
    }while(false);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Clients</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
</head>
<body>
    <div class="container my-5">
        <h2>New Client</h2>
        <?php
            if(!empty($errorMessage)){
                echo 
                "<div  class='alert alert-danger  align-items-center' role='alert'>
                    <div>
                        $errorMessage
                    </div>
                </div>";
            }
        ?>
        <br>
        <form method="POST">
            <h3>Name</h3> <div class="col-sm-2"><input type="text" class="form-control" name="name" value="<?php echo $name; ?>"></div>
            <h3>Email</h3> <div class="col-sm-2"><input type="text" class="form-control" name="email" value="<?php echo $email;?>"></div>
            <h3>Phone</h3> <div class="col-sm-2"><input type="text" class="form-control" name="phone" value="<?php echo $phone;?>"></div>
            <h3>Address</h3> <div class="col-sm-2"><input type="text" class="form-control" name="address" value="<?php echo $address;?>"></div>
            <br>
            <div class="row mb-3">
            <div class="col-sm-3"><button type="submit" class="btn btn-outline-primary">CREATE</button></div>
        </div>
        </form>
    </div>
</body>
</html>