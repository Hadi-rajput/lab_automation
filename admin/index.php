<?php
include 'header.php';
?>

<section class="py-5 text-center" style="background: linear-gradient(135deg, #e9ecef, #ffffff);">
  <div class="container">
    <div class="p-5 rounded shadow-sm bg-white d-inline-block">
      <h1 class="fw-bold text-primary mb-3">
        Welcome, <span class="text-dark"><?php echo $_SESSION['username']; ?></span> 👋
      </h1>
      <p class="lead text-secondary mb-4">
        You are logged in as an <strong class="text-success">Administrator</strong>.
      </p>
      <p class="text-muted fs-5">
        Manage users, monitor system activity, and keep everything running smoothly.
      </p>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
