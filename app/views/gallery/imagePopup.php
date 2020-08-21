<!-- modal box -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog">
	<div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-body p-0" id="popup">
				<button type="button" class="close position-fixed top-right btn-link" aria-label="Close" onclick="closeModal()">
						<span aria-hidden="true"><i class="fas fa-times"></i></span>
				</button>
				<div id="alert-modal" class="p-0 rounded text-center d-none position fixed"></div>
				<div class="row m-0">
					<!-- img -->
					<div class="col-12 col-lg-7 p-0">
						<div class="ml-5 mt-1 position-fixed set-avatar" id="set-profile-img">
							<button type="button" class="btn btn-outline-primary btn-sm my-button-white" >Set as profile pic</button>
						</div>
						<div class="row position-fixed ml-1 mt-1" id="pop-up-del">
							<button type="button" class="btn btn-outline-primary btn-sm my-button-white" ><i class="fas fa-trash-alt"></i></button>
						</div>
						<div class="row embed-responsive embed-responsive-4by3 m-0">
							<img src="<?php echo URLROOT; ?>/public/img/general/loading.png" id="pop-up-img" alt="" class="embed-responsive-item">
						</div>
					</div>
					<!-- comments -->
					<div class="col-12 col-lg-5 pl-5 pr-5">
						<div class="pt-1">
							<div class="row border-bottom d-flex flex-row align-items-center">
								<div class="p-2">
									<img id="user-avatar" src="<?php echo URLROOT; ?>/public/img/general/avatar.png" alt="user avatar" class="avatar img-thumbnail">
								</div>
								<a id="user-link" href="">
									<div class="p-2" id="pop-up-username">
									</div>
								</a>
								<div id="pop-up-follow" class="ml-auto p-2">
									<button type="button" class="btn btn-sm">Follow</button>
								</div>
							</div>
							<div class="row">
								<div id="comment-list" class="col"></div>
							</div>
							<div id="pop-up-reaction" class="row position-bottom mb-md-5 mb-xs-2 mb-sm-3">
								<button class="btn"><i class="fas fa-heart icon-7x"></i></button>
								<button class="btn"><i class="fas fa-comment icon-7x color-icon"></i></button>
							</div>
							<div class="row position-bottom mb-2 ">
								<div class="col-8 pl-0 pr-0">
									<form id="post-comment" class="form-inline">
										<input class="form-control font-weight-light small" placeholder="Add a comment" id="post-comment-text" maxlength="150">
									</form>
								</div>
								<div class="col-3">
									<button class="btn btn-primary ml-2 btn-md-sm">Post</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-backdrop fade show" id="backdrop" style="display: none;">
</div>