<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login");
    exit();
}

include 'header.php';
?>

<div class="container mt-5">
    <h3 class="text-center">Welcome to Your Dashboard</h3>
    <p class="text-center">Hello, <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong>!</p>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">View and edit your profile information.</p>
                    <a href="profile.php" class="btn btn-primary">Go to Profile</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Jobs</h5>
                    <p class="card-text">Browse available jobs and apply.</p>
                    <a href="jobs.php" class="btn btn-primary">View Jobs</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Applications</h5>
                    <p class="card-text">View your job applications.</p>
                    <a href="applications.php" class="btn btn-primary">View Applications</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <a href="logout" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <a href="Users" class="btn btn-secondary">Users</a>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
