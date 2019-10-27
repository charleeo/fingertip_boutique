<?php 
  $sql ="SELECT * FROM categories WHERE parent = 0";
  $queryresult = $db->query($sql);
?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Fingertip Mart</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
       <?php 
       
       while($parent = mysqli_fetch_assoc($queryresult)){
         $parent_id =$parent['id'];
         $sql2 = "SELECT * FROM categories WHERE parent ='$parent_id'";
         $newquery = $db->query($sql2);
         ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
            <?php echo $parent['category']; ?>
          <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php
            while($child = mysqli_fetch_assoc($newquery)){
            ?>
            <li><a href="category.php?cat=<?= $child['id']; ?>"><?php echo $child['category']; ?></a></li>
       <?php } ?>
       
          </ul>
        </li>
        <?php } ?>
        <li><a href="cart.php" ><i class=" fas fa-shopping-cart"></i>My Cart</a></li>
      </ul>
<!--      
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul> -->
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>