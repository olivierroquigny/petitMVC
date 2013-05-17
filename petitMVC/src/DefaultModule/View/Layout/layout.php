<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<title><?php echo $this->getTitle(); ?></title>
<meta name="description" content="<?php echo $this->getDescription(); ?>">
<meta name="keywords" content="<?php echo $this->getKeywords(); ?>">
<meta name="author" content="Olivier Roquigny">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
	echo $this->getStyles(); 
?>
<?php 
	echo $this->getScripts(); 
?></head>
<body>
	<div id="container">
		<header id="ban"></header>
		<ul class="menuV">		
<?php foreach($this->getMenu() as $key => $value): ?>
				<li><a href="<?php echo $value['url']; ?>"><?php echo $value['menu'];?></a></li>
<?php endforeach; ?>
		</ul><!-- /.menuV -->
		<div id="content">
<?php 
	$indent ='		';
	echo $this->getContent($indent); 
?>
		</div><!-- /#content -->
		<footer id="footer">
			<ul class="menuV">
				<li><a href="<?php echo $this->getURL(0); ?>">Home</a></li>
			</ul>
		</footer>
	</div><!-- /#container .wrap -->
</body>
</html>
