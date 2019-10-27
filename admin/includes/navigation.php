<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/phpecommerce/admin/index.php">Fingertip Admin</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class=""><a href="brand.php">Brand <span class="sr-only">(current)</span></a></li>
        <li class=""><a href="category.php">Categories <span class="sr-only">(current)</span></a></li>
        <li class=""><a href="products.php">Products <span class="sr-only">(current)</span></a></li>
        <li class=""><a href="archived.php">Archived <span class="sr-only">(current)</span></a></li>
        <?php if(is_logged_in()){ ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" 
          aria-expanded="false">Hello <?= $user_data['first']; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="change_password.php">Change Password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Log Out</a></li>
          </ul>
        </li>
        <?php } ?>
        <?php if(has_permission('admin')){ ?>
        <li class=""><a href="users.php">Users <span class="sr-only">(current)</span></a></li>
        <?php } ?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>