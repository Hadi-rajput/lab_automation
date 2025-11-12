<?php
include 'header.php';

$allcategories = mysqli_query($conn,"SELECT * from categories");

?>

<div class="container-fluid">

    <h1 class="text-center text-primary fw-bolder mb-4"
        style="font-size: 2.2rem; text-transform: uppercase; letter-spacing: 1px;">
        View Users
        <span class="text-secondary fw-normal" style="font-size: 1.2rem;"> | Control Panel</span>
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                   <?php foreach ($allcategories as $categories) {?>
                        <tr>
                         <td><?php echo $categories['categories_id']?></td>
                         <td><?php echo $categories['categories_name']?></td>
                         <td> <a href="edit-category.php?id=<?php echo $categories['categories_id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="delete_category.php?id=<?php echo $categories['categories_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

</div>


<?php
include 'footer.php';
?>