<?php require 'app/views/inc/header.php'; ?>

<div class="container">

  <div id="alert-body" class="p-3 m-3 rounded text-center d-none"></div>

  <div class="row">
    <div class="col d-flex justify-content-center">
      <img src="<?php echo URLROOT; ?>/public/img/general/avatar.png" width="100px" height="100px" class="avatar img-thumbnail">
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
  <hr>

 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <!-- <div class="modal-dialog" role="document"> -->
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
                <button type="button" class="close" aria-label="Close" onclick="closeModal()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
              <!-- TOGGLE -->
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-outline-secondary active">
                  <input type="radio" name="options" id="change-profile" autocomplete="off" checked onclick="switchtab(this.id)"> Profile
                </label>
                <label class="btn btn-outline-secondary">
                  <input type="radio" name="options" id="change-pwd" autocomplete="off" onclick="switchtab(this.id)"> Password
                </label>
                <label class="btn btn-outline-secondary">
                  <input type="radio" name="options" id="change-notification" autocomplete="off" onclick="switchtab(this.id)"> Notification
                </label>
              </div>
              <!-- end Toggle -->

              <!-- profile -->
              <div id="profile-modal" class="mt-3">

                <div id="alert-profile" class="p-3 m-3 rounded text-center d-none"></div>  

                <form id="profile-form">
                  <div class="form-group">
                    <label for="username-form" class="col-form-label">Username:</label>
                    <input type="text" name="username" class="form-control" required id="username-form" maxlength="25">
                  </div>
                  <div class="form-group">
                    <label for="first-name" class="col-form-label">First name:</label>
                    <input type="text" name="first_name" class="form-control" id="first-name-form" maxlength="25">
                  </div>
                  <div class="form-group">
                    <label for="last-name-form" class="col-form-label">Last name:</label>
                    <input type="text" name="last_name" class="form-control" id="last-name-form" maxlength="25">
                  </div>
                  <div class="form-group">
                    <label for="email-form" class="col-form-label">Email:</label>
                    <input type="email" name="email" class="form-control" required id="email-form">
                  </div>
                  <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
              </div>
              <!-- end profile  -->

              <!-- password -->
              <div id="pwd-modal" class="mt-3 d-none">
              
              <div id="alert-pwd" class="p-3 m-3 rounded text-center d-none"></div>  

                <form id="pwd-form">
                  <div class="form-group">
                    <label for="currentPwd">Current password<sup>*</sup></label>
                    <input type="password" name="currentPwd" class="form-control" id="currentPwd" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="newPwd">New password<sup>*</sup></label>
                    <input type="password" name="newPwd" class="form-control" id="newPwd" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="ConfirmPwd">Confirm new password<sup>*</sup></label>
                    <input type="password" name="ConfirmPwd" class="form-control" id="ConfirmPwd" placeholder="Password">
                  </div>
                  <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
              </div>
              <!-- endpassword -->

              <!-- notification  -->
              <div id="notify-modal" class="mt-3 d-none">
                
                <div id="alert-notify" class="p-3 m-3 rounded text-center d-none"></div>  


                <p>
                  <span>An email notification is sent if your image was liked or commented.</span>
                </p>
                <div class="custom-control custom-switch"> 
                
                  <input type="checkbox" class="custom-control-input" id="notification-switch" <?php echo ($data['notification'] == 1) ? 'checked' : ''; ?>>
                  <!-- <input type="checkbox" class="custom-control-input" id="notification-switch" checked> -->
                  <label class="custom-control-label" for="notification-switch">Update your notificaton settings here</label>
                </div>
              </div>
              <!-- end notif -->

            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
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