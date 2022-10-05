<!DOCTYPE html>
<html>
  <body>

   


    <?php
      // Check if image file is a actual image or fake image
      if(isset($_POST["submit"])) {
        $target_dir = "../receipts";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
          $uploadOk = 1;
        } else {
          $uploadOk = 0;
        }

        if ($uploadOk == 1) {
          $folderName = $_SESSION['id'];
          $rootFolder    = "../payment_receipt_uploads";
          

          // NOW, WE CREATE THE FOLDER USING PHP'S mkdir().
          // BUT WE MAY NEED TO CHECK IF THE DIRECTORY EXISTS OR NOT
          // SO WE DON'T INADVERTENTLY OVERRIDE SOMETHING
          if(!is_dir($folder2Create)){ //<== IF NO SUCH FOLDER EXISTS, WE CREATE IT.
            $folder2Create = $rootFolder . "/" . $folderName;
            $folderCreated = mkdir($folder2Create, 0777);
            if(!$folderCreated){
              echo '<script type = "text/javascript"> alert("Folder Could Not Be Created.");</script>'; 
              $check=0;
            }else
              $check=1;
          }else
            $check=1;
          
          if ($check==1){
            if ($_FILES["fileToUpload"]["size"] > 500000) {   // Check file size
              echo '<script type = "text/javascript"> alert("Sorry, your file is too large. Please Choose a file Under 500KB");</script>'; 
            }else{
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                  echo '<script type = "text/javascript"> alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>'; 
                }else{
                  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "Your Receipt (filename: ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded successfully.";
                    rename($target_dir . basename($_FILES["fileToUpload"]["name"],$target_dir ."custid: ".$_SESSION['id']."_orderid: ".$orderid);
                  } else {
                    echo "Sorry, there was an error uploading your file.";
                  }
                }
            }
          }

        }else{
          echo '<script type = "text/javascript"> alert("File Is Not an Image or PDF.");</script>'; 
        }
      }
   
    ?>

  <form method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
  </form>
  </body>
</html>



   <!--~ Query-->
   <div class ='f-row' id='query'>
                                <div class = 'f-row'><br></div>

                                <div class = colleft id='query'>
                                    <h1>&emsp;Queries<h1>
                                    <h3>&emsp;&emsp;Send us your questions or inquireies and we will get back to you within 72 <br>&emsp;&emsp;Hours.<h3> 
                                </div>
                                <div class = colright>
                                    <?php
                                        if (isset($_POST['submitquery'])){
                                            $query=array(mysqli_real_escape_string($con,$_POST['name']),
                                                mysqli_real_escape_string($con,$_POST['email']),
                                                mysqli_real_escape_string($con,$_POST['message']));
                                            insertinfo($query,'query');
                                        }
                                    ?>
                                    <form method= 'post'>
                                        <input type="text" name="name" placeholder="Your Name"/><br><br>
                                        <input type="text" name="email" placeholder="Email Address"/><br><br>
                                        <input type="text" name="message" placeholder="Message"/><br><br>
                                        <input type="submit" value="Submit Question" name ="submitquery"/>
                                    </form>
                                </div>
                                <div class = 'f-row'><br><br></div>
                            </div>
                        <!--!~-->
