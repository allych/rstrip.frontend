<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<link rel="icon" href="/images/favicon.png" type="image/x-icon" />

        <title><?php echo settings::init()->get('site_title'); ?> | <?php if (isset($current_menu)) { echo $current_menu->get_title(); } ?></title>

	<?php echo $css_files;?>
	<?php echo $script_files;?>
	<script>
	  var controller_name = '<?php if (isset($current_menu)) { echo $current_menu->get_title(); } ?>';
	</script>
    </head>


    <body>
        <!--MAIN CONTANER START -->
        <div id="maincontaner">
            <!--TOP CONTENER START -->
            <div class="top_contener">
                <div class="top_panel">
                    <a href="/" class="logo">
                        <img src="/images/logo2.png" alt="logo"/>
                    </a>
                    <div class="menu-header">
                        <ul id="top_nav" class="cart_links">
			    <?php
			      $menu = menu::init()->get_all_items();
			      if ($menu) foreach ($menu as $item){
				echo '<li><a href="/'.(!$item->is_default() ? $item->get_name() : '').'">'.$item->get_title().'</a><span>|</span></li>';
			      }
			    ?>
                        </ul>
                    </div>
                    <div class="navigation">
                    </div>
                </div>
            </div>

	    <!--CONTENER START -->
	    <div class="contener_panel wppost">

		<div class="breadcum">
		    <?php
		      if (isset($current_menu)){
			if ($current_menu->get_id_menu_parent()){
			  echo '<p id="breadcrumbs"><a href="/'.$current_menu->get_menu_parent()->get_name().'">'.$current_menu->get_menu_parent()->get_title().'</a> » <strong>'.$current_menu->get_title().'</strong></p>';
			}
			else{
			  echo '<p id="breadcrumbs"><strong>'.$current_menu->get_title().'</strong></p>';
			}
		      }
		    ?>
		</div>

		<div class="bottom_panel">
		    <article class="article">
			<?php
//			  $file = SITE_PATH.registry::get('templates_directory').DIRSEP.$current_menu->get_name().'.php';
//
//			  if (file_exists($file)){
//			    include($file);
//			  }
//			  else{
			    echo $content;
//			  }
			?>
		    </article>

		</div>
	    </div>
	    <!--CONTENER END -->
	</div>
	<!--MAIN CONTANER END -->
	<!--FOOTER PANEL START -->
	<div class="footer_panel">
	    <div class="footer">
		<h2><?php echo settings::init()->get('site_title'); ?></h2>
		<p><?php echo settings::init()->get('bottom_text'); ?></p>
	    </div>
	</div>
	<!--FOOTER PANEL END -->
	<!--COPYRIGHT START -->
	<div class="copyright">
	    Создание сайта <a href="http://www.allych.ru">Alla Mamontova</a> Дизайн <a href="http://gothemeteam.com/">GoThemeTeam</a>
	<!--COPYRIGHT END -->
    </body>
</html>
