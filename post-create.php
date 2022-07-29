<?php
session_start();
require "config.php";
require "common.php";

$titleError = '';
$descError = '';
$title = '';
$desc = '';

if(isset($_POST['post_create'])){
  $title = $_POST['title'];
  $desc = $_POST['description'];

  if(empty($title)){
    $titleError = "The title field is required!";
  }
  if(empty($desc)){
    $descError = "The description field is required!";
  }

  if(!empty($title) and !empty($desc)){
    $sql = "INSERT INTO posts (title, description) VALUES (:title, :description)";
    $pdostatement = $pdo->prepare($sql);
    $pdostatement->execute([
      ":title" => $title,
      ":description" => $desc
    ]);
    $_SESSION['successMsg'] = 'A post created successfully';
    header('location: index.php');
  }
}

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
                      <b class="h4">Posts Creation Form</b>
                    </div>
                    <div class="col-md-6">
                      <a href="index.php" class="float-end btn btn-secondary"><< Back</a>
                    </div>
                  </div>

                </div>
              </div>
              <form action="post-create.php" method="post">
                <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf'] ?>">

              <div class="card-body">
                   <div class="form-group mb-3">
                     <label>Title</label>
                     <input type="text"
                       name="title"
                       class="form-control
                       <?php if($titleError != '') : ?>
                         is-invalid
                       <?php endif ?>
                       "
                       placeholder="Enter post title"
                       value="<?php echo $title; ?>">
                     <span class="text-danger"><?php echo $titleError ?></span>
                   </div>
                   <div class="form-group mb-3">
                     <label>Description</label>
                     <textarea name="description"
                       class="form-control
                       <?php if($descError != '') : ?>
                         is-invalid
                       <?php endif ?>
                       "
                       placeholder="Description..."
                      ><?php echo $desc; ?></textarea>
                     <span class="text-danger"><?php echo $descError ?></span>
                   </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="post_create" class="btn btn-primary">Create</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>



      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" charset="utf-8"></script>
  </body>
</html>
