<?php include 'header.php'; ?>

<div class="container py-5">
  <div class="text-center bg-white shadow-lg rounded-4 p-5 border border-2 border-light">
    <h1 class="fw-bold text-gradient display-5 mb-3">
      Welcome, <span class="text-primary"><?php echo htmlspecialchars($_SESSION['username']); ?></span> 👋
    </h1>
    <p class="text-muted fs-5 mb-4">
      You are logged in as a <strong class="text-success">Tester</strong>.
    </p>
    <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
      <a href="assigned_products.php" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
        <i class="fas fa-tasks me-2"></i> View Assigned Products
      </a>
      <a href="completed_products.php" class="btn btn-outline-success px-4 py-2 rounded-pill shadow-sm">
        <i class="fas fa-check-circle me-2"></i> Completed Reviews
      </a>
    </div>
  </div>
</div>

<style>
.text-gradient {
  background: linear-gradient(90deg, #007bff, #6610f2);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.btn {
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
}
</style>

<?php include 'footer.php'; ?>
