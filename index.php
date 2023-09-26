<?php  
$insert = false;
   // Connect to the Database 
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn){
  die("Sorry we failed to connect: ". mysqli_connect_error());
}
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  $title = $_POST["title"];
  $description = $_POST["description"];
  
  // Sql query to be executed
  $sql = "INSERT INTO `notes1` (`title`, `description`) VALUES ('$title', '$description')";
  $result = mysqli_query($conn, $sql);
  
  // Add a new trip to the Trip table in the database
  if($result){
    $insert = true;
  }
  else{
      echo "The record was not inserted successfully because of this error ---> ". mysqli_error($conn);
  }
}

 ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
   
    <title>iNote App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="">
     <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="/crud/index.php?update=true" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
            </div>

            <div class="form-group">
              <label for="desc">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
            </div> 
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
    <nav class="navbar navbar-expand-lg  bg-body-tertiary" data-bs-theme="dark" >
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Todo Php</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact us</a>
              </li>
             
          </div>
        </div>
      </nav>
      <?php
                if($insert){
                  echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                  <strong>Success!</strong> Your note has been inserted successfully
                  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>×</span>
                  </button>
                </div>";
                }
  ?>

       <div class="container my-5 ">
        <form action="/crud/index.php " method="POST" >
            <h2>iNotes </h2>
            <div class="form-group">
              <label for="title">Note Title</label>
              <input type="text" name="title" class="form-control" id="title" aria-describedby="emailHelp" >
              
            </div>
            <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
              </div>
            
            <button type="submit" class="btn btn-primary my-3 ">Add Note</button>
          </form>
       </div>

       <div class="container my-4">
       <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
       <?php 
        $sql= "SELECT * FROM `notes1`" ;
        $result = mysqli_query($conn, $sql);
        $snu=0;
        while($row = mysqli_fetch_assoc($result)){
          $snu= $snu+1;
          echo  "<tr>
          <th scope='row'>" . $snu. "</th>
          <td>". $row['title'] ."</td>
          <td>". $row['description'] ."</td>
          <td> <button class='edit btn btn-sm btn-primary' id=".$row['snu'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['snu'].">Delete</button>  </td>
          </tr>";
        
      }
       ?>
  
  </tbody>
</table>

       </div>
       <hr>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
   
   <script>
   $(document).ready(function () {
     $('#myTable').DataTable();

   });
 </script>
  </body>
</html>