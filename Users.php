<?php include 'header.php'?>
<?php include 'nav.php'?>

<?php
session_start(); 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "School";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Create and Update operations
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'] ?? '';
    $name = $_POST['name'];
    $email = $_POST['email'];

    if ($user_id) { // Update user
        $sql = "UPDATE users SET name='$name', email='$email' WHERE user_id=$user_id";
    } else { // Create new user
        $sql = "INSERT INTO users (name, email, created_at) VALUES ('$name', '$email', NOW())";
    }
    $conn->query($sql);
    
    // Redirect after processing the form
    header('Location: Users');
    exit;
}

// Handle Delete operation
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    $deletedUser = $conn->query("SELECT * FROM users WHERE user_id=$user_id")->fetch_assoc();
    $_SESSION['deleted_user'] = $deletedUser; 
    $conn->query("DELETE FROM users WHERE user_id=$user_id");
    header('Location: Users?deleted=true'); 
    exit;
}

// Handle Edit operation
if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $name = $_GET['name'];
    $email = $_GET['email'];

    // Redirect to the form with pre-filled data
    header("Location: Users?edit=$user_id&name=$name&email=$email");
    exit;
}

// SQL query to fetch users from the database
$sql = "SELECT user_id, name, email, created_at FROM users";
$result = $conn->query($sql);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <style>
        table {
            width: 50% !important;
            border-collapse: collapse;
            margin: auto;
            table-layout: fixed;
        }
        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }
        .form-container {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .alert {
            color: green; 
        }
    </style>
</head>

<!-- Form for Adding/Updating Users -->
<div class="form-container">
    <form method="POST" action="Users">
        <input type="hidden" name="user_id" value="<?= $_GET['edit'] ?? '' ?>">
        <label>Name:</label><input type="text" name="name" value="<?= $_GET['name'] ?? '' ?>" required><br><br>
        <label>Email:</label><input type="email" name="email" value="<?= $_GET['email'] ?? '' ?>" required><br><br>
        <button type="submit" class="btn btn-outline-primary"><?= isset($_GET['edit']) ? 'Update User' : 'Add User' ?></button>
    </form>
</div>

<!-- Table containing users in the database -->
<h1>Registered Users</h1>

<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 'true' && isset($_SESSION['deleted_user'])): ?>
    <div class="alert">
        User deleted. 
        <a href="restore">Undo</a> 
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <form method="GET" action="Users">
                    <select name="action" class="dropdown" onchange="this.form.submit()">
                        <option value="">Select Action</option>
                        <option value="edit" 
                            <?= (isset($_GET['edit']) && $_GET['edit'] == $row['user_id']) ? 'selected' : '' ?>>Edit</option>
                        <option value="delete">Delete</option>
                    </select>
                    <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                    <input type="hidden" name="name" value="<?= $row['name'] ?>">
                    <input type="hidden" name="email" value="<?= $row['email'] ?>">
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>
