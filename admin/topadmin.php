<?php
// Assuming $currentPage is set to the current page name or URL
$currentPage = basename($_SERVER['PHP_SELF']);

require '../inc/conn.php';
if (!isset($_SESSION['userID'])) {
    header("Location: ../");
}

if ($_SESSION['userRoles'] != "admin") {
  ?>
  <script>
      alert("You have been logged out due to invalid access.");
      window.location = "../logout.php";
  </script>
  <?php
} 

if (isset($_SESSION['inactivity'])) {
  ?>
  <script>
      alert("You have been logged out due to inactivity.");
      window.location = "../logout.php";
  </script>
  <?php
} 

$programID = "";
$reagentID = "";
$labID = "";
$instrumentID = "";
$sampleDate = "";
$userID = $_SESSION['userID'];
$instID = $_SESSION['userInstID'];
$roles = $_SESSION['userRoles'];
$acct = $_SESSION['userAcct'];

function isActive($page) {
  global $currentPage;
  return ($currentPage == $page) ? 'active' : '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

    <!---link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"--->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>

    <link rel="stylesheet" href="../inc/dashboard.css">
    <title>Adeqa - Dashboard  </title>
    
</head>
<body>
  
<nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="./">
        <img src="../inc/img/adeeqablack.png" width="28%" height="auto" class="d-inline-block align-top" alt="">
        <b></b>
    </a>
   
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="btn btn-outline-danger" href="../logout.php" role="button">Logout</a>
        </li>
    </ul>
</nav>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <ul class="navbar-nav">
    <li class="nav-item <?php echo isActive('User.php'); ?>">
      <a class="nav-link" href="../admin/User.php">User</a>
    </li>
    <li class="nav-item <?php echo isActive('Institution.php'); ?>">
      <a class="nav-link" href="../admin/Institution.php">Institution</a>
    </li>

    <?php
        if ($instID == '1vendor') { ?>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Configure
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" <?php echo isActive('Instrument.php'); ?> href="../admin/Instrument.php">Instrument</a>
              <a class="dropdown-item"  <?php echo isActive('Method.php'); ?> href="../admin/Method.php">Method</a>
            </div>
          </li>
          
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
              Drug
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" <?php echo isActive('DrugCategory.php'); ?> href="../admin/DrugCategory.php">Category</a>
              <a class="dropdown-item" <?php echo isActive('DrugType.php'); ?> href="../admin/DrugType.php">Type</a>
            </div>
          </li>

                   <?php } 
          else { ?> 
          <li class="nav-item <?php echo isActive('AssignProgram.php'); ?>">
            <a class="nav-link" href="../admin/AssignProgram.php">Assign Program</a>
          </li>
            <?php }
           ?>
   <!-- Dropdown -->
   <!--<li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Dropdown link
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Link 1</a>
        <a class="dropdown-item" href="#">Link 2</a>
        <a class="dropdown-item" href="#">Link 3</a>
      </div>
    </li> -->
  </ul>
</nav>

</body>
</html>

