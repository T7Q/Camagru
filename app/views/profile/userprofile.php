<?php require 'app/views/inc/header.php'; ?>

<div class="container">

  <div id="alert-body" class="p-3 m-3 rounded text-center d-none"></div>

  <div class="row">
	<div class="col d-flex justify-content-center">
		<!-- <img src="<?php echo URLROOT; ?>/public/img/general/avatar.png" width="100px" height="100px" class="avatar img-thumbnail"> -->
		<img id="profile-pic" src="<?php echo URLROOT . "/" . $data['avatar']; ?>" width="100px" height="100px" class="avatar img-thumbnail">
	</div>
	<div class="col">
		<div class="row">
		<h2 id="username" class="mr-5"><?php echo $data['username']; ?></h2>
		<?php if($data['show_edit_button']) : ?>
		<button id="edit" type="button" class="btn btn-outline-secondary" onclick='openModal(this.id)'>
			Edit profile
		</button>
		<?php endif; ?>
		</div>
		<div class="row">
		<span>
			<span id="image"><?php echo $data['images']; ?></span> <span class="pl-2 pr-2">images</span>
		</span>
		<span>
			<span id="following"><?php echo $data['following']; ?></span><span class="pl-2 pr-2">followers</span>
		</span>
		<span>
			<span id="followers" class="mr-1 ml-2"><?php echo $data['followers']; ?></span><span class="pl-2 pr-2">following</span>
		</span>
		</div>
	</div>
</div>

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
