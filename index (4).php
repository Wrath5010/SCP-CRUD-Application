<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Foundation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="container bg-secondary">
      <?php include "connection.php"; ?>
      <br>
      <div>
          <ul class = "nav navbar-dark bg-dark p-3">
              
              <?php foreach($result as $link): ?>
                <li class="nav-item active">
                  <a href="index.php?link=<?php echo $link['subject']; ?>" class="nav-link text-light btn btn-dark"><?php echo $link['subject']; ?></a>
                </li>
              <?php endforeach; ?>
              
          </ul>
      </div>
      <br>
        
        <div class="bg-dark p-2">
            <br>
            <p class="text-center h3"><a href= "create.php" class="btn btn-dark">Create a new SCP subject</a></p>
            <br>
        </div>

     <br>
    <h1 class="p-5 bg-light border shadow text-center ">SCP Subject CRUD Application</h1>
    <br>
    
    <div class="p-3 bg-light border shadow">
        <?php
        
        if(isset($_GET['link']))
        {
            $subject = $_GET['link'];
            
            //prepared statement
            $stmt = $connection->prepare("select * from scp where subject = ?");
            if(!$stmt)
            {
                echo "<p>Error in preparing SQL statement</p>";
                exit;
            }
            $stmt->bind_param("s", $subject);
            
            if($stmt->execute())
            {
                $result = $stmt->get_result();
                
                //check if a record has been retrieved
                if($result->num_rows > 0)
                {
                    $array = array_map('htmlspecialchars', $result->fetch_assoc());
                    $update = "update.php?update=" . $array['id'];
                    $delete = "index.php?delete=" . $array['id'];
                    
                    echo "
                        <div class='card card-body shadow mb-3'>
                            <h2 class='card-title'>{$array['subject']}</h2>
                            <h4>Object Class: {$array['class']}</h4>
                            <div class='text-center'>
                            <p><img src='{$array['image']}' width='50%' class='rounded' alt='{$array['subject']}'></p>
                            </div>
                            <h5>Description:</h5>
                            <p>{$array['description']}</p>
                            <h5>Special Containment Procedure:</h5>
                            <p>{$array['containment']}</p>
                            <p>
                                <a href='{$update}' class='btn btn-info'>Update Record</a>
                                <a href='{$delete}' class='btn btn-warning'>Delete Record</a>
                            </p>
                        </div>
                    ";
                }
                else
                {
                    echo "<p>No record found for SCP subject " . htmlspecialchars($subject) . "</p>";
                }
            }
            else
            {
                echo "<p>Error executing the statement</p>";
            }
        }
        else
        {
            echo "
                <br>
                <div class='text-center'>
                <p><img src='images/SCPIogo.webp' class='rounded' alt='SCP CRUD Application' width='40%'></p>
                </div>
                <h3 class='text-center'>Welcome to SCP CRUD Application.</h3>
                <br>
            ";
        }
        
        //delete record
        if(isset($_GET['delete']))
        {
            $delID = $_GET['delete'];
            $delete = $connection->prepare("delete from scp where id=?");
            $delete->bind_param("i", $delID);
            
            if($delete->execute())
            {
                echo "<div class='alert alert-warning'>SCP Record Deleted</div>";
            }
            else
            {
                echo "<div class='alert alert-danger'>Error Deleting Record {$delete->error}.</div>";
            }
        }
        
        ?>
    </div>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>