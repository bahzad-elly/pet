<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="sidebar">
    <h4 class="text-center"><i class="fas fa-paw me-2"></i>Pet Shelter</h4>
    <hr>
    <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
        <i class="fas fa-chart-line me-3"></i> Dashboard
    </a>
    <a href="animals.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'animals.php' ? 'active' : ''; ?>">
        <i class="fas fa-dog me-3"></i> Animals
    </a>
    <a href="medical_record.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'medical_record.php' ? 'active' : ''; ?>">
        <i class="fas fa-notes-medical me-3"></i> Medical Records
    </a>
    <a href="adopters.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'adopters.php' ? 'active' : ''; ?>">
        <i class="fas fa-users me-3"></i> Adopters
    </a>
    <a href="adoption.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'adoption.php' ? 'active' : ''; ?>">
        <i class="fas fa-heart me-3"></i> Adoptions
    </a>
    <a href="intake.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'intake.php' ? 'active' : ''; ?>">
        <i class="fas fa-file-import me-3"></i> Intake Sources
    </a>
    <a href="vaccination_type.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'vaccination_type.php' ? 'active' : ''; ?>">
        <i class="fas fa-vial me-3"></i> Vaccine Types
    </a>
    <a href="animal_vacines.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'animal_vacines.php' ? 'active' : ''; ?>">
        <i class="fas fa-syringe me-3"></i> Animal Vaccines
    </a>
    <a href="users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
        <i class="fas fa-user-shield me-3"></i> Users
    </a>
    <hr>
    <a href="logout.php" class="text-danger mt-auto">
        <i class="fas fa-sign-out-alt me-3"></i> Logout
    </a>
</div>