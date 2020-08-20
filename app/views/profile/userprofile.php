<?php require 'app/views/inc/header.php'; ?>

<div class="container mt-5">

  <div class="row mb-5">
	<div class="col d-flex justify-content-center">
		<img id="profile-pic" src="<?php echo URLROOT . "/" . $data['avatar']; ?>" width="100px" height="100px" class="avatar img-thumbnail">
	</div>
	
	<div class="col">
		<div class="row overflow-auto">
			<h2 id="username" class="mr-5 font-weight-bold"><?php echo $data['username']; ?></h2>
			<?php if($data['show_edit_button']) : ?>
			<button id="edit" type="button" class="btn btn-outline-secondary" onclick='openModal(this.id)'>
				edit profile & settings
			</button>
			<?php endif; ?>
		</div>
		<div class="row align-items-center">
			<span>
				<span id="image"><?php echo $data['images']; ?></span>
				<button id="image-count-btn"  type="button" class="btn btn-link disabled"> images</button>

			</span>
			<span ml-2 mr-2>
				<span id="following"><?php echo $data['following']; ?></span>
				<button id="modalfollowing"  type="button" class="btn btn-link" onclick='openModal(this.id)'> following</button>
			</span>
			<span>
				<span id="followers" class="mr-1 ml-2"><?php echo $data['followers']; ?></span>
				<button id="modalfollowers"  type="button" class="btn btn-link" onclick='openModal(this.id)'> followers</button>
			</span>
		</div>
	</div>
</div>

<hr>


<div class="row d-flex justify-content-center mt-1 mb-2">
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="inlineRadioOptions" id="my-gallery" value="option1" checked>
		<label class="form-check-label" for="inlineRadio1" id="label-my">USER GALLERY</label>
	</div>
	<div class="form-check form-check-inline">
		<input class="form-check-input" type="radio" name="inlineRadioOptions" id="follow-gallery" value="option2">
		<label class="form-check-label" for="inlineRadio2">FOLLOWING</label>
	</div>
</div>

<div id="alert-body" class="p-3 m-3 rounded text-center d-none"></div>

  <!-- Infinite scroll gallery -->
  <?php require 'app/views/gallery/infiniteScroll.php'; ?>

  <!-- Image modal box -->
  <?php require 'app/views/gallery/imagePopup.php'; ?>

  <!-- Profile modal box-->
  <?php require 'app/views/profile/profilePopup.php'; ?>
  
  <!-- Follow(er/ing) modal box-->
  <?php require 'app/views/profile/followpopup.php'; ?>

</div>

<script src="<?php echo URLROOT; ?>/public/js/profile.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/modalbox.js"></script>

<script src="<?php echo URLROOT; ?>/public/js/gallery.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/image.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/like.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/comment.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/follow.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/avatar.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/toggle.js"></script>


<?php require 'app/views/inc/footer.php'; ?>
