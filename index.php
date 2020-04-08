<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Simple CRUD app</title>
        <link rel="stylesheet" 
              href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
              integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script>
function validate(){
    var firstName = document.getElementById('FirstName').value;
    if(firstName.length<3){
        alert("First Name should have atleast 3 characters");
        return false;
    } else{
        return true;
    }
}
</script>
    </head>
    <body>
        <?php require_once 'process.php';?>
        
        <?php
        if(isset($_SESSION['message'])):
        ?>
        <div class="alert alert-<?=$_SESSION['msg_type']?>">
        
             <?php
                     echo $_SESSION['message'];
                     unset($_SESSION['message']);
             ?>
         </div> 
        <?php endif ?>
        <div class="container">
        <?php 
            //connecting to database
            $con = new mysqli('localhost', 'root','','ongeza_test')
                    or die(mysqli_error($mysqli));
            $query = "SELECT * FROM gender INNER JOIN customer ON 
                        gender.id=customer.gender_id ";
            $result = mysqli_query($con,$query); 
//            printhelp($result);
           ?>
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Town Name</th>
                        <th>Gender</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <?php
                    while ($row = $result->fetch_assoc()):?>
                <tr>
                    <td><?php echo $row['id'];?></td>
                    <td><?php echo $row['first_name'];?></td>
                    <td><?php echo $row['last_name'];?></td>
                    <td><?php echo $row['town_name'];?></td>
                    <td><?php echo $row['gender_name'];?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $row['id'];?>"
                           class="btn btn-info">Edit</a>
                           <a href="process.php?delete=<?php echo $row['id'];?>"
                              class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endwhile;?>
            </table>
        </div>
            <?php
            function printhelp($array){
                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
              
        ?>
        <div class="row justify-content-center">
            <form onsubmit="return validate()"name="regForm" action="process.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id;?>">   
                  <div class="form-group">
                    <label>First Name</label>
                    <input id="FirstName" type="text" class="form-control" name="first_name" value="<?php echo $fname?>" 
                           placeholder="Enter your first Name" required></div>
                  <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="last_name" 
                           value="<?php echo $lname?>" 
                           placeholder="Enter your last Name" required></div>
                  <div class="form-group">
                    <label>Town Name</label>
                    <input type="text" name="town_name" 
                           class="form-control" value="<?php echo $town_name?>" 
                           placeholder="Which town do you live in?" required></div>
                  <div class="form-group">
                      <label>Select Your Gender</label>
                      <select id="gender" name="gender">
                          <option value="male">Male</option>
                          <option value="female">Female</option>
                      </select> </div>                 
                      <div class="form-group"> 
                        <?php 
                        if($update == true):?>
                          <button type="submit"  class="btn btn-info" name="update">Update</button>
                        <?php else: ?>   
                          <button type="submit"  class="btn btn-primary" name="save">Save</button>
                        <?php endif; ?>

               </div>
            </form>
             
        </div>    
            
    </div>
       
    </body>
</html>
