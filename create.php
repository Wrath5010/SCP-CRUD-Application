<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCP Foundation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="container bg-secondary">
      
      <?php
      
        Include "connection.php";
        
        if(isset($_POST['submit']))
        {
            //prepared statement to insert data
            $insert = $connection->prepare("insert into scp(subject, class, image, description, containment) values(?, ?, ?, ?, ?)");
        
            $insert->bind_param("sssss", $_POST['subject'], $_POST['class'], $_POST['image'], $_POST['description'], $_POST['containment']);    
            
            if($insert->execute())
            {
                echo "
                <div class='alert alert-success p-3'>Record successfully created</div>
                ";
            }
            else
            {
                echo"
                <div class='alert alert-success p-3'>Error: {$insert->error}</div>
                ";
            }
        }
      
      ?>
      <br>
      <br>
    <h1 class="p-3 bg-light border shadow text-center p-4">Create a new SCP record</h1>
    <br>
    <p><a href="index.php" class="btn btn-dark">Back to Main Page</a></p>
    <div class="p-3 bg-light border shadow">
        <form method="post" action="create.php" class="form-group">
            <label>Enter SCP Subject:</label>
            <br>
            <input type="text" name="subject" placeholder="SCP Subject..." class="form-group" required>
            <br><br>
            <label>Enter SCP class:</label>
            <br>
            <input type="text" name="class" placeholder="SCP Class..." class="form-group" required>
            <br><br>
            <label>Enter SCP image:</label>
            <br>
            <input type="text" name="image" placeholder="images/nameofimage.png..." class="form-group">
            <br><br>
            <textarea name="description" class="form-control">Enter SCP Description Information</textarea>
            <br><br>
            <textarea name="containment" class="form-control">Enter SCP Containment Information</textarea>
            <br><br>
            <input type="submit" name="submit" class="btn btn-primary">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>