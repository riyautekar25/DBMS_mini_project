<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
    #ques {
        min-height: 433px;
    }
    </style>
    <title>Threadit -- Welcome to Threadit</title>
</head>

<body>
    <?php include 'partials/_header.php';?>
    <?php include 'partials/_dbconnect.php';?>
    <?php
    $id = $_GET['catid'];
        $sql = "SELECT * FROM `category` WHERE category_id=$id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
    ?>

    <?php 
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        //insert thread into DB
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `threads` (`thread_title`,`thread_desc`,`thread_cat_id`,`thread_user_id`,`created_on`) VALUES ('$th_title','$th_desc','$id','$sno', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert)
        {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }
    ?>

    <!-- category container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> threads</h1>
            <p class="lead"><?php echo $catdesc;?></p>
            <hr class="my-4">
            <p>
            <ul>
                <li>This is a public forum.</li>
                <li>Avoid posting content which you do not wish to disclose in public.</li>
                <li>Maintain professionalism while posting and replying to topics.</li>
                <li>Try to add value with your each post</li>
            </ul>
            </p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>

    <?php
    if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true){
       echo'<div class="container">
                <h1 calss="py-2">Start a discussion</h1>
                <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Thread Title</label>
                            <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp"
                              placeholder="Enter title">
                            <small id="emailHelp" class="form-text text-muted">Keep your title as crisp as possible</small>
                        </div>
                        <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Elaborate Your Concern</label>
                            <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>';
        }
        else{
            echo'
            <div class="container">
                <h1 calss="py-2">Start a discussion</h1>
                <p class="lead">You are not logged in. Please login to start a discussion.</p>
            </div>
            ';
        }
    ?>

    <div class="container" id="ques">
        <h1 calss="py-2">Browse Questions</h1>
        <?php
    $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_time = $row['created_on'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno=$thread_user_id";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            

            echo'<div class="media my-3">
                <img src="Images\user.png" width="45px" alt="Generic placeholder image">
                <div class="media-body">'.
                '<h5 class="mt-0"><a href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
                    '.$desc.'
                </div>'.'<p class="font-weight-bold my-0"><b>Asked by: '.$row2['user_email'].' at '.$thread_time.'</b></p>'.
            '</div>';
            }
    if($noResult){
        echo'
        <div class="jumbotron jumbotron-fluid">
        <div class="container">
        <p class="display-4">No questions yet</p>
        <p class="lead">   Be the first person to ask a question.</p>
        </div>
        </div>
     ';
    }
    ?>



        <!-- <div class="media my-3">
            <img src="Images\user.png" width="45px" alt="Generic placeholder image">
            <div class="media-body">
                <h5 class="mt-0">Media heading</h5>
                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus
                odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate
                fringilla. Donec lacinia congue felis in faucibus.
            </div>
        </div> -->


    </div>

    <?php include 'partials/_footer.php';?>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>