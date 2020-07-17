<!-- // logged in vs logged out users -->

<nav class="navbar navbar-expand-lg navbar-dark bg-black">

  <div class="container">
    <!-- <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a> -->
    <a class="navbar-brand" href=""><i class="fas fa-circle icon"></i></a>

    <!-- SANDWICH PART
    Brand and toggle get grouped for better mobile display
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
      </button> 
    Collect the nav links, forms, and other content for toggling
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"> -->

    
    <ul class="navbar-nav mx-auto">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/gallery">Gallery</a>
        </li>
        <?php if(isset($_SESSION['user_id'])) : ?>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/users/photo">Photo</a>
        </li>
        <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Sign in</a>
            </li>
          <?php endif; ?>
    </ul>

    <ul class="navbar-nav">
        <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Join</a>
            </li>
          <?php endif; ?>
    </ul>
    <!-- SANDWICH PART
    </div>/.navbar-collapse -->
    </div>
</nav>

<!-- 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
  <div class="container">
      <a class="navbar-brand" href="<?php echo URLROOT; ?>"><?php echo SITENAME; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/pages/gallery">Gallery</a>
          </li>
          <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/photo">Photo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/profile">Profile</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/login">Sign in</a>
            </li>
          <?php endif; ?>
        </ul>
        
        <ul class="navbar-nav ml-auto">
          <?php if(isset($_SESSION['user_id'])) : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/logout">Logout</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo URLROOT; ?>/users/register">Join</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav> -->