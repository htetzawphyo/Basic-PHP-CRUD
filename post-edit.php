<?php
session_start();
require "config.php";
$titleError = '';
$descError = '';
$title = '';
$desc = '';

if(isset($_POST['post_update'])){
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $id = $_POST['id'];

  if(empty($title)){
    $titleError = "The title field is required!";
  }
  if(empty($desc)){
    $descError = "The description field is required!";
  }

  if(!empty($title) and !empty($desc)){
    $sql = "UPDATE posts SET title=:title, description=:description WHERE id='$id'";
    $pdostatement = $pdo->prepare($sql);
    $pdostatement->execute([
      ":title" => $title,
      ":description" => $desc
    ]);
    $_SESSION['successMsg'] = 'A post updated successfully';
    header('location: index.php');
  }
} else {
  $sql = "SELECT * FROM posts WHERE id=".$_GET['postId'];
  $pdostatement = $pdo->prepare($sql);
  $pdostatement->execute();
  $result = $pdostatement->fetchAll();
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
                      <b class="h4">Posts Edition Form</b>
                    </div>
                    <div class="col-md-6">
                      <a href="index.php" class="float-end btn btn-secondary"><< Back</a>
                    </div>
                  </div>

                </div>
              </div>
              <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
              <div class="card-body">
                   <div class="form-group mb-3">
                     <label>Title</label>
                     <input type="text"
                       name="title"
                       class="form-control
                       #title မှာ အလွတ်ပေးလိုက်ရင် "The title field is required!" အဲ့စာကို titleError ထဲ ထည့်ပေးလိုက်တယ်။ အဲ့တော့ titleError က "" empty နဲ့ မညီတော့ဘူး။ အဲ့တော့ if(titleError != '') နဲ့ စစ်လို့ရသွားပီ။
                       <?php if($titleError != '') : ?>
                         is-invalid
                       <?php endif ?>
                       "
                       placeholder="Enter post title"
                       value="<?php if ($titleError != '') {
                         echo $title = "";
                       }elseif (!empty($title)) {
                         echo $title;
                       }else {
                         echo $result[0]['title'];
                       }?>">
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
                      ><?php if ($descError != '') {
                        echo $desc = "";
                      }elseif (!empty($desc)) {
                        echo $desc;
                      }else {
                        echo $result[0]['description'];
                      }?></textarea>
                     <span class="text-danger"><?php echo $descError ?></span>
                   </div>
              </div>
              <div class="card-footer">
                <button type="submit" name="post_update" class="btn btn-primary">Update</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>



      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" charset="utf-8"></script>
  </body>
</html>
