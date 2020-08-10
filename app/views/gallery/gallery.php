<?php require 'app/views/inc/header.php'; ?>

	<div class="container">
		<a href="#" onclick='openModal()'>test!</a>
		<!-- <h1>GET INSPIRATION FROM OUR USERS</h1> -->
		<div class="article-list" id="article-list"></div>
		<ul class="article-list__pagination article-list__pagination--inactive" id="article-list-pagination"></ul>
	</div>


	<!-- modal box -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true"
		role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">					
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
										<img src="https://bit.ly/2XPEz9M" alt="Girl in a jacket" class="embed-responsive-item">
									</div>
									<div class="row">
										<button type="button" class="btn btn-outline-danger btn-sm" onclick="delete(this.id)" id="USER_ID">Delete</button>
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
									<div class="row border">
										<div class="col pl-0">
											<img src="https://bit.ly/2XPEz9M" alt="Girl in a jacket" class="rounded img-thumbnail">
										</div>
										<div class="col">User
										</div>
										<div class="col pr-0">
											<button type="button" class="btn btn-outline-success btn-sm" onclick="follow(this.id)" id="USER_ID">Follow</button>
										</div>
									</div>
									<hr class="pr-0">
									<div class="row"> User1: comment</div>
									<div class="row"><button class="btn"><i class="fas fa-heart icon-7x"></i> 0</button><button class="btn"><i class="fas fa-comment icon-7x"></i> 0</button></div>
									<div class="row"> enter your comment here</div>
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


<?php require 'app/views/inc/footer.php'; ?>
