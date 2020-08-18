<?php require 'app/views/inc/header.php'; ?>

<!-- include infinite scroll -->
<?php require 'app/views/gallery/infiniteScroll.php'; ?>

<!-- include modalbox for image popup -->
<?php require 'app/views/gallery/imagePopup.php'; ?>

<script src="<?php echo URLROOT; ?>/public/js/gallery.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/image.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/modalbox.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/like.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/comment.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/follow.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/avatar.js"></script>
<script src="<?php echo URLROOT; ?>/public/js/toggle.js"></script>

<?php require 'app/views/inc/footer.php'; ?>