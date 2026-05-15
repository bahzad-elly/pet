<?php
session_start();
include 'connect.php';
if (!isset($_SESSION['name'])) header("Location: index.php");

$uid = (int)$_GET['uid'];
$query = "SELECT * FROM users WHERE uid = $uid";
$res = mysqli_query($connection, $query);
$user = mysqli_fetch_assoc($res);

if ($_POST) {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);
    
    // Only update password if provided
    if (!empty($_POST['password'])) {
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username='$username', password='$pass', fullname='$fullname', email='$email', role='$role' WHERE uid=$uid";
    } else {
        $sql = "UPDATE users SET username='$username', fullname='$fullname', email='$email', role='$role' WHERE uid=$uid";
    }
    
    if (mysqli_query($connection, $sql)) {
        header("Location: users.php");
        exit();
    } else {
        $error = mysqli_error($connection);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User | Pet Shelter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "sidebar.php"; ?>
    <div class="main-content">
        <div class="mb-4">
            <h2 class="fw-bold mb-1">Edit User</h2>
            <p class="text-secondary small">Update account details for <span class="text-primary"><?php echo $user['username']; ?></span></p>
        </div>

        <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Full Name</label>
                            <input type="text" name="fullname" class="form-control" value="<?php echo $user['fullname']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-secondary">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $user['email']; ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="staff" <?php echo $user['role'] == 'staff' ? 'selected' : ''; ?>>Staff</option>
                                <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-semibold text-secondary">New Password <span class="text-muted">(leave blank to keep current)</span></label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update User Details</button>
                        <a href="users.php" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
