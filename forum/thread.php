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
        #ques{
            min-height: 433px;
        }
    </style>
    <title>Threadit -- Welcome to Threadit</title>
</head>

<body>
    <?php include 'partials/_header.php';?>
    <?php include 'partials/_dbconnect.php';?>
    <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno=$thread_user_id";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];
        }
    ?>
    <?php 
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=='POST'){
        //insert into comment into DB
        $comment = $_POST['comment'];
        $sno = $_POST['sno'];
        $sql = "INSERT INTO `comments` (`comment_content`,`thread_id`,`comment_time`, `comment_by`) VALUES ('$comment','$id', current_timestamp(), '$sno')";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert)
        {
            echo '
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment has been added!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            ';
        }
    }

    ?>


    <!-- category container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <!-- <p>
            <ul>
                <li>This is a public forum.</li>
                <li>Avoid posting content which you do not wish to disclose in public.</li>
                <li>Maintain professionalism while posting and replying to topics.</li>
                <li>Try to add value with your each post</li>
            </ul>
            </p> -->
           <p>Posted by:<b><?php echo $posted_by;?></b></p>
        </div>
    </div>

    <?php
        if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true){
        echo'<div class="container">
        <h1 calss="py-2">Post a comment</h1>
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Type your comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
        </div>';
        }
        else{
            echo'
            <div class="container">
                <h1 calss="py-2">Post a comment</h1>
                <p class="lead">You are not logged in. Please login to be able to post comments.</p>
            </div>
            ';
        }
    ?>
    <div class="container my-4">
        <div class="jumbotron">
            <hr class="my-4">
            <p>
            <ul>
                <li>This is a public forum.</li>
                <li>Avoid posting content which you do not wish to disclose in public.</li>
                <li>Maintain professionalism while posting and replying to topics.</li>
                <li>Try to add value with your each post</li>
            </ul>
            </p>
        </div>
    </div>





    <div class="container" id="ques">
        <h1 calss="py-2">Discussions</h1>
    <?php
    $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            $comment_time = $row['comment_time'];
            $thread_user_id = $row['comment_by'];
            $sql2 = "SELECT user_email FROM `users` WHERE sno=$thread_user_id";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);


        echo'<div class="media my-3">
            <img src="Images\user.png" width="45px" alt="Generic placeholder image">
            <div class="media-body">
            <p class="font-weight-bold my-0"><b>'. $row2['user_email'] .' at '.$comment_time.'</b></p>
                '.$content.'
            </div>
        </div>';
    }

    if($noResult){
        echo'
        <div class="jumbotron jumbotron-fluid">
        <div class="container">
        <p class="display-4">No Comments Found</p>
        <p class="lead">   Be the first person to comment.</p>
        </div>
        </div>
     ';
    }
    ?>

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