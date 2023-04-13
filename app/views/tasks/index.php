<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong">
	<link rel="stylesheet" type="text/css" href="<?= $data['css'] ?>" />
	<link rel="stylesheet" type="text/css" href="<?= $data['css_main'] ?>" />
	<link rel="stylesheet" type="text/css" href="<?= $data['css_modal'] ?>" />
	<script type="text/javascript" src="<?= $data['js'] ?>"></script>
	<script type="text/javascript" src="<?= $data['consts'] ?>"></script>
	<script type="text/javascript" src="<?= $data['js_project_cell'] ?>"></script>
	<title>To Do List</title>
	<script>
		window.tasks = <?php print_r(json_encode(json_decode($data['tasks'], true)["tasks"])) ?>;
	</script>
</head>
<body>
	<?php include 'header.php' ?>
	<?php include 'main.php' ?>
	<?php include 'modal.php' ?>
</body>
</html>