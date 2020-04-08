<?php
session_start();
$con=mysqli_connect('localhost', 'root','','ongeza_test');
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$update = false;
$fname = '';
$lname = '';
$town_name = '';
$id = 0;
if (isset($_POST['save'])){
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $town_name = $_POST['town_name'];
    $gender = $_POST['gender'];
    
    $_SESSION['message']= "This Record has been saved!";
    $_SESSION['msg_type']= "success";
    header("location: index.php");
   $error = FALSE;
$query = "INSERT INTO gender (id, gender_name) VALUES ('','$gender')";
if($result = mysqli_query($con,$query)) {
     if( mysqli_affected_rows($con) > 0 ) {
          $id = mysqli_insert_id($con);
     } else {
          // no record inserted, therefore error condition exists
          echo "No record inserted. Cannot proceed.";
          $error = TRUE;
     }
    } else {
         // query failed to execute
         echo "Query Failed";
         $error = TRUE;
    }
if( $error !== TRUE ) {
     $query = "INSERT INTO customer  ( id, first_name, last_name,town_name,gender_id ) VALUES ('','$fname','$lname','$town_name','$id'  )"; // Where $id holds the value of the primary key from the previous query . . .
    if($result = mysqli_query($con,$query)) {
        echo '<h1>Registered successfully</h1>';
        

        }
    }
 
}

//Deleting a record
if (isset($_GET['delete'])){
    $id = $_GET['delete'];    
//    $erase= "DELETE FROM customer, WHERE id=$id";
    $result = mysqli_query($con,"DELETE customer.*,gender.* "
            . "FROM customer "
            . "LEFT JOIN gender ON (gender.id= customer.gender_id)"
            . " WHERE customer.id=$id")or die(mysqli_error($con));
    $_SESSION['message']= "This Record has been deleted!";
    $_SESSION['msg_type']= "danger";
    header("location: index.php");
    
}

//Editing a record
if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $query = "SELECT * from customer, gender where customer.id=$id";
    $result = mysqli_query($con,$query)or die(mysqli_error($con));
    if (count($result)==1){
        $row = mysqli_fetch_array($result);
        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $town_name=$row['town_name'];
        $gender=$row['gender_name'];
    }
}
//
if (isset($_POST['update'])){
    $id = $_POST['id'];
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $town_name = $_POST['town_name'];
    $gender = $_POST['gender'];
    $query="UPDATE gender INNER JOIN customer ON customer.gender_id = gender.id "
            . "SET customer.first_name='$fname',"
            . "customer.last_name='$lname',"
            . "customer.town_name='$town_name',"
            . "gender.gender_name='$gender'"
            . "WHERE customer.id=$id";
    mysqli_query($con,$query) or die(mysqli_error($con));
    
    $_SESSION['message']= "Record has been updated successfully!";
    $_SESSION['msg_type']= "warning";
    
    header('location: index.php');
}