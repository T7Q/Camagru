<div class="modal fade" id="profile" tabindex="-1" role="dialog" aria-labelledby="profileLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profileLabel">Edit profile</h5>
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

            <!-- include modalbox for Profile changepopup -->
            <?php require 'app/views/profile/profilechange.php'; ?>

            <!-- include modalbox for Password Change popup -->
            <?php require 'app/views/profile/changepwd.php'; ?>
            
            <!-- include modalbox for Notification popup -->
            <?php require 'app/views/profile/notification.php'; ?>
            
            </div>

            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop fade show" id="backdrop" style="display: none;"></div>