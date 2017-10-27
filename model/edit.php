<?php include 'stockController.php' ?>
<?php include 'siteController.php' ?>
<?php include 'config.php' ?>
<?php include 'global.php' ?>          
    <div class="container">
     <div class="no-gutter row"> 
           <div class="col-md-12">
               <div class="panel panel-default" id="sidebar">
                   <div class="panel-body">                
<?php          
    $sql = "SELECT * FROM user where user_username='$user_username'";
    $result = mysqli_query($database,$sql) or die(mysqli_error($database)); 
    $rws = mysqli_fetch_array($result);
?>             
<?php include 'controllers/form/edit-profile-form.php' ?>
                   </div>
               </div>
           </div>
        </div>
    </div>