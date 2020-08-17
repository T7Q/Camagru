<?php require 'app/views/inc/header.php'; ?>

<div class="container">

  <div id="alert-body" class="p-3 m-3 rounded text-center d-none"></div>

  <!-- User info header -->
  <?php require 'app/views/profile/profileheader.php'; ?>

  <!-- Infinite scroll gallery -->
  <?php require 'app/views/gallery/infiniteScroll.php'; ?>

  <!-- Image modal box -->
  <?php require 'app/views/gallery/imagePopup.php'; ?>

  <!-- Profile modal box-->
  <?php require 'app/views/profile/profilePopup.php'; ?>

</div>

<script src="<?php echo URLROOT; ?>/public/js/profile.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/modalbox.js"></script>

<script src="<?php echo URLROOT; ?>/public/js/gallery.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/image.js"></script>


<?php require 'app/views/inc/footer.php'; ?>
