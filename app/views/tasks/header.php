<header class="d-flex position-relative">
	<img class="position-absolute top-50 start-50 translate-middle" src="<?php echo IMAGES_PATH . "header/logo.png" ?>" alt="logo">
    <form action="<?php echo BASE_URL . 'home/logout' ?>" method="POST">
        <input type="submit" id="logout" class="rounded position-absolute top-50 end-0 translate-middle-y me-3 p-2" style="left: auto;" value="Logout">
    </form>
</header>