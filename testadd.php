<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add/Delete User</title>
</head>
<body>
    <h1>Manage Users</h1>

    <!-- Form to Add User -->
    <form method="post" action="add_delete_user.php">
        <h2>Add New User</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <input type="submit" name="add_user" value="Add User">
    </form>

    <!-- Form to Delete User -->
    <form method="post" action="add_delete_user.php">
        <h2>Delete User</h2>
        <label for="email">Email of User to Delete:</label>
        <input type="email" id="email" name="delete_email" required>
        <br><br>
        <input type="submit" name="delete_user" value="Delete User">
    </form>

    <?php
        if (isset($_POST['add_user'])) {
            // PHP code to add user
            $name = $_POST['name'];
            $email = $_POST['email'];
            $default_password = password_hash('defaultPassword123', PASSWORD_DEFAULT); // Default password

            $conn = new mysqli('localhost', 'root', '', 'your_database');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$default_password')";
            
            if ($conn->query($sql) === TRUE) {
                echo "New user added successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }

        if (isset($_POST['delete_user'])) {
            // PHP code to delete user
            $email = $_POST['delete_email'];

            $conn = new mysqli('localhost', 'root', '', 'your_database');

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "DELETE FROM users WHERE email = '$email'";

            if ($conn->query($sql) === TRUE) {
                echo "User deleted successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
    ?>
</body>
</html>
