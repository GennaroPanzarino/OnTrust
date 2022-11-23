<?php
session_start();

if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {
} else {
  header('Location: login.php');
}
?>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<meta name="viewport" content="user-scalable=no"/>
<style>@import url("style.css");</style>
</head>
<body>
  <div class='heading'>Attività</div>
  <div id='tabs'>

    <a href="index.php">
    <div id='one'>
      <i class="material-icons">theaters</i>
    </div>
    </a>


    <a href="add.php">
    <div id='two'>
            <i class="material-icons">add_circle_outline</i>
    </div>


    </a>
    <a href="activity.php">
    <div id='three' class='current'>
            <i class="material-icons">book</i>
    </div>
    </a>


    <a href="profile.php"><div id='four'>
            <i class="material-icons">person</i>
    </div>
    </a>

  </div>
<i class="material-icons" id='success'>check_circle_outline</i>
<div class='title'>Successo</div>
<div class='subbox'><?php echo $_GET['message']?></div>
<script type="text/javascript">
</script>
</body>
