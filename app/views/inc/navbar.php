<nav class="fixed-top navbar navbar-expand-lg navbar-dark bg-black">

  <div class="container">
    <a class="navbar-brand" href="<?php echo URLROOT; ?>/pages/home"><i class="fas fa-circle icon"></i>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent"> 
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?php echo URLROOT; ?>/galleries/all">GALLERY</a>
        </li>

        <?php if(isset($_SESSION['user_id'])) : ?>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/photobooth/photo">PHOTOBOOTH</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?php echo URLROOT; ?>/profiles/user">PROFILE</a>
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
    </div>
  </div>
</nav>
