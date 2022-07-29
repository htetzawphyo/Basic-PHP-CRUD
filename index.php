<?php
session_start();
require "config.php";
require "common.php";

$sql = "SELECT * FROM posts ORDER BY id DESC";
$pdostatement = $pdo->prepare($sql);
$pdostatement->execute();
$result = $pdostatement->fetchAll();

 ?>

<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <style media="screen">
      body {
        padding-top: 30px;
      }
    </style>

    <!-- BOOTSTRAP LINK -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
  </head>
  <body>
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">
                  <div class="row">
                    <div class="col-md-6">
                      <b class="h4">Posts List</b>
                    </div>
                    <div class="col-md-6">
                      <a href="post-create.php" class="float-end btn btn-primary">+ Add New</a>
                    </div>
                  </div>

                </div>
              </div>
              <div class="card-body">
                <?php if(isset($_SESSION['successMsg'])) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                   <?php
                      echo $_SESSION['successMsg'];
                      unset($_SESSION['successMsg'])
                    ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif ?>
                <table class="table">
                  <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Action</th>
                  </tr>
                  <?php
                    $i = 1;
                    if($result){
                    foreach ($result as $value) {
                  ?>
                      <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo escape($value['title']); ?></td>
                        <td><?php echo escape($value['description']); ?></td>
                        <td><?php echo date('Y-m-d',strtotime($value['created_at'])) ?></td>
                        <td>
                          <a href="post-edit.php?postId=<?php echo $value['id'] ?>"
                             type="button"
                             class="btn btn-warning btn-sm">Edit</a>
                          <a href="post-delete.php?post_id_to_delete=<?php echo $value['id'] ?>"
                             type="button"
                             class="btn btn-danger btn-sm"
                             onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                        </td>
                      </tr>
                  <?php
                     $i++;
                    }
                  }
                   ?>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>



      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" charset="utf-8"></script>
  </body>
</html>
