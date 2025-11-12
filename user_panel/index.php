<?php include 'header.php'; ?>

<div class="container-fluid py-5 shadow-lg" style="background-color: #f0f4f8;">
    <div class="text-center">
        
        <i class="fas fa-handshake fa-3x text-primary mb-3 animated fadeInDown"></i>

        <h2 class="fw-bolder display-4 mb-2 text-dark">
            Hello there, <span class="text-primary"><?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        </h2>
        
        <p class="mt-3 text-secondary fs-5 mx-auto" style="max-width: 600px;">
             You are logged in as a <span class="text-decoration-underline">User</span>. Your personalized dashboard awaits—ready for you to manage your products and track progress.
        </p>

        <hr class="w-25 mx-auto border-primary border-2 mt-4">

    </div>
</div> 

<?php include 'footer.php'; ?>