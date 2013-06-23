<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title><?= ($title != '' ? $title . ' | ' : '') . settings::init()->get('site_title'); ?></title>
		<meta name="keywords" content="<?= $this->get_keywords(); ?>">

		<?= $this->get_css_files(); ?>
		<?= $this->get_script_files(); ?>
    </head>
<?
	$list = categories::init();
	$list->set_id_parent(null);
	$categories = $list->get_all_list();
?>

    <body>

		<div class="container">

			<div class="masthead">
				<a href="/"><img src="/img/logo.png" alt="<?= settings::init()->get('site_title'); ?>" class="logo" /></a>
				<div class="navbar">
					<div class="navbar-inner">
						<div class="container">
							<ul class="nav">
								<? /*if ($categories) foreach ($categories as $item) {
									echo '<li';
									if (isset($category) && $category->get_id() == $item->get_id()){
										echo ' class="active" ';
									}
									echo '><a href="/category/all/'.$item->get_url().'">'.$item->get_name().'</a></li>';
								}*/ ?>
							</ul>
							<a href="/map"><button type="button" class="btn btn-success pull-right">Начать путешествие</button></a>
						</div>
					</div>
				</div>
			</div>

			<div class="jumbotron"><?= $this->get_content(); ?></div>

			<hr>

			<div class="footer">
				<p class="text-right"><small>Интернет-портал для путешественников <em>ReadySteadyTrip.Ru</em></small></p>
			</div>

		</div>


	</body>
</html>
