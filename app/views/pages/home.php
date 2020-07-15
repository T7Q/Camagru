// basic html for home page
// logged in vs loggout users
// no JS?

<?php require APPROOT . '/views/inc/header.php'; ?>

<h1><?php echo  $data['title'] ?> to home.php</h1>


<ul>
	<?php foreach($data['posts'] as $post) : ?>
		<li><?php echo $post->title; ?></li>
	<?php endforeach; ?>
</ul>

<?php require APPROOT . '/views/inc/footer.php'; ?>