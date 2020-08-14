<?php require 'app/views/inc/header.php'; ?>

<div class="container">

  <div id="alert-body" class="p-3 m-3 rounded text-center d-none"></div>

  <div class="row">
    <div class="col">
      <img src="<?php echo URLROOT; ?>/public/img/general/avatar.png" width="100px" height="100px" class="avatar img-thumbnail">
    </div>
    <div class="col">
      <div class="row">
        <h2 id="username" class="mr-5"><?php echo $data['username']; ?></h2>
        <button id="edit" class="btn btn-outline-primary">Edit Info</button>
      </div>
      <div class="row">
        <span id="image"><?php echo $data['images']; ?></span> <span class="pl-2 pr-2">images</span>
        <span id="followers" class="mr-1 ml-2"><?php echo $data['followers']; ?></span><span class="pl-2 pr-2">followers</span>
        <span id="following"><?php echo $data['following']; ?></span><span class="pl-2 pr-2">following</span>
      </div>
      <div class="row">
          <p id="notification" class="btn btn-link">Notification setting</p>
      </div>
    </div>
  </div>
  <hr>

<!-- modal box followers -->

<!-- modal box -->
<div class="modal fade" id="followers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
		role="dialog">
		<!-- <div class="modal-dialog modal-lg" role="document"> -->
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div id="alert-modal" class="p-3 m-3 rounded text-center d-none"></div>			
					<button type="button mx-auto" class="close" aria-label="Close" onclick="closeModal()">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body" id="popup">
					<div class="row">

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>



</div>

<script src="<?php echo URLROOT; ?>/public/js/profile.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/modalbox.js"></script>

<?php require 'app/views/inc/footer.php'; ?>

<!-- // basic profile html
// url profile / username 
// build profile public or private -->