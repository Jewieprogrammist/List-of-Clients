<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";
$conn = mysqli_connect($servername, $username, $password, $database);

$name = "";
$email = "";
$phone = "";
$address = "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (!isset($_GET["id"])) {
        header("location: main.php");
        exit;
    }
    $id = $_GET["id"];
    $sql = "SELECT * FROM clients WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    if (!$row) {
        header("location: main.php");
        exit;
    }

    $name = $row["name"];
    $email = $row["email"];
    $phone = $row["phone"];
    $address = $row["address"];
} else {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];

    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $errorMessage = "All fields are required";
    } else {
        $sql = "UPDATE clients SET name=?, email=?, phone=?, address=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $name, $email, $phone, $address, $id);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $successMessage = "Client updated successfully!";
        } else {
            $errorMessage = "Failed to update client";
        }

        header("location: main.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"/>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Client</h2>
        <?php
            if (!empty($errorMessage)) {
                echo 
                "<div class='alert alert-danger align-items-center' role='alert'>
                    <div>
                        $errorMessage
                    </div>
                </div>";
            } elseif (!empty($successMessage)) {
                echo 
                "<div class='alert alert-success align-items-center' role='alert'>
                    <div>
                        $successMessage
                    </div>
                </div>";
            }
        ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address" value="<?php echo htmlspecialchars($address); ?>">
            </div>
            <button type="submit" class="btn btn-outline-primary">EDIT</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
