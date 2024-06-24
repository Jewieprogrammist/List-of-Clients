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
        <h2>List of Clients</h2>
        <a role="button" href="create.php" class="btn btn-outline-primary">New Client</a>
       
        <table class="table">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">NAME</th>
            <th scope="col">EMAIL</th>
            <th scope="col">PHONE</th>
            <th scope="col">ADDRESS</th>
            <th scope="col">CREATED_AT</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "myshop";
            $conn = mysqli_connect($servername,$username,$password,$database);
            
            if(!$conn){
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM `clients`";
            $result = $conn->query($sql);
            
            if(!$result){
                die("Invalid query: " . $conn->error);
            }
            while($row = $result->fetch_assoc()){
                echo "
                <tr>
                <td>$row[id]</td>
                <td>$row[name]</td>
                <td>$row[email]</td>
                <td>$row[phone]</td>
                <td>$row[address]</td>
                <td>$row[created_at]</td>
                <td>
                    <a class='btn btn-danger btn-sm' href='delete.php?id=$row[id]'>DELETE</a>
                    <a class='btn btn-primary btn-sm' href='edit.php?id=$row[id]'>EDIT</a>
                </td>
            </tr>
                ";
            }

            ?>
            
        </tbody>
        </table>
    </div>
</body>

</html>