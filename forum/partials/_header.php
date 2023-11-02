<?php
session_start();

echo'
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/forum">Threadit</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/forum">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="rules.php">Forum Rules</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="#">Corporate</a></li>
          <li><a class="dropdown-item" href="#">Civil</a></li>
          <li><a class="dropdown-item" href="#">Criminal</a></li>
          <li><a class="dropdown-item" href="#">Family</a></li>
          <li><a class="dropdown-item" href="#">Legal Documents</a></li>
          <li><a class="dropdown-item" href="#">Other</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php" tabindex="-1">Contact</a>
      </li>
      </ul>
      <div class="row mx-2">';
      if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true)
      {
        echo'<form class="inline my-2 my-lg-0" method="get" action="search.php">
        <p class="text-light my-0 mx-2">Welcome '.$_SESSION['useremail'].'</p></form>
        <a href="partials/_logout.php" "type="button" class="btn btn-outline-success ml-2">Logout</a>';
      }
      else{
      echo'
        <form class="inline my-2 my-lg-0">
        <button type="button" class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
        <button type="button" class="btn btn-outline-success mx-2" data-bs-toggle="modal" data-bs-target="#signupmodal">SignUp</button>
        </form>
        
      ';
      }
      
    
      echo'</div>
  </div>
</div>
</nav>
';

include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
if(isset($_GET['signupsuccess']) && $_GET['signupsuccess']=="true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
            <strong>Success!</strong> You can now login
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>';}
?>