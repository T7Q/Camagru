<?php require 'app/views/inc/header.php'; ?>

	<div class="container">
		<!-- <h1>GET INSPIRATION FROM OUR USERS</h1> -->

		<div id="alert-body" class="p-3 m-3 rounded text-center d-none"></div>


		<div class="article-list mt-5" id="article-list"></div>
		<ul class="article-list__pagination article-list__pagination--inactive" id="article-list-pagination"></ul>
	</div>


	<!-- modal box -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
		role="dialog">
		<!-- <div class="modal-dialog modal-xl" role="document"> -->
		<div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">

		<!-- <div class="modal-dialog modal-lg" role="document"> -->
			<div class="modal-content">
				<div class="modal-header">
					<div id="alert-modal" class="p-3 m-3 rounded text-center d-none"></div>			
					<button type="button mx-auto" class="close" aria-label="Close" onclick="closeModal()">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body" id="popup">
					<div class="row">
						<!-- img -->
						<div class="col-md-7 col-sm-6 col-xs-6 mx-auto">
							<div class="row">
								<div class="col-1 d-flex align-items-center">
									<a href=""><i class="fas fa-chevron-left icon-7x"></i></a>									
								</div>
								<div class="col mx-auto">
									<div class="row embed-responsive embed-responsive-4by3">
										<img src="<?php echo URLROOT; ?>/public/img/general/loading.png" id="pop-up-img" alt="" class="embed-responsive-item">
									</div>
									<div class="row" id="pop-up-del">
										<button type="button" class="btn btn-outline-danger btn-sm" >Delete</button>
									</div>
								</div>
								<div class="col-1 mx-auto d-flex  align-items-center">
									<a href=""><i class="fas fa-chevron-right icon-7x"></i></a>									
								</div>
							</div>
						</div>
							<!-- comments -->
						<div class="col-md-5 col-sm-6 col-xs-6 mx-auto">
							<div class="row">
								<div class="col-1"></div>
								<div class="col">
									<div class="row">
										<div class="col pl-0">
											<img src="<?php echo URLROOT; ?>/public/img/general/avatar.png" alt="Girl in a jacket" class="avatar img-thumbnail">
										</div>
										<div id="pop-up-username" class="col">User
										</div>
										<div id="pop-up-follow" class="col pr-0">
											<button type="button" class="btn btn-outline-success btn-sm">Follow</button>
										</div>
									</div>
									<hr class="pr-0">
									<div class="row"></div>
										<div id="comment-list" class="col container"></div>
									<div id="pop-up-reaction" class="row">
										<button class="btn"><i class="fas fa-heart icon-7x"></i></button>
										<button class="btn"><i class="fas fa-comment icon-7x"></i></button>
									</div>
									<div class="row">
										<form id="post-comment" class="form-inline">
											<textarea class="form-control" placeholder="Add a comment" id="post-comment-text" rows="1" maxlength="150"></textarea>
											<button class="btn btn-outline-primary btn-sm">Post</button>
										</form>
									</div>
								</div>
								<div class="col-1"></div>
							</div>
						</div>
					  </div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>

<script src="<?php echo URLROOT; ?>/public/js/gallery.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/image.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/modalbox.js"></script>


<?php require 'app/views/inc/footer.php'; ?>


