<!-- // logged in vs logged out users -->

<nav class="navbar navbar-expand-lg navbar-dark bg-black">

  <div class="container">
    <!-- <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a> -->
    <a class="navbar-brand" href="<?php echo URLROOT; ?>/pages/home"><i class="fas fa-circle icon"></i></a>

    <!-- SANDWICH PART
    Brand and toggle get grouped for better mobile display
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
      </button> 
    Collect the nav links, forms, and other content for toggling
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> -->

    
    <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/galleries/all">GALLERY</a>
        </li>
        <?php if(isset($_SESSION['user_id'])) : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/cameras/snapshot">CAMERA</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/profile">PROFILE</a>
        </li>
        <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">SING IN</a>
            </li>
          <?php endif; ?>
    </ul>

    <ul class="navbar-nav">
        <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">LOGOUT</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">JOIN</a>
            </li>
          <?php endif; ?>
    </ul>
    <!-- SANDWICH PART
    </div>/.navbar-collapse -->
    </div>
</nav>
