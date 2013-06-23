<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<title><?= settings::init()->get('site_title'); ?></title>

		<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.4/leaflet.css" />
		<!--[if lte IE 8]>
			<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.4/leaflet.ie.css" />
		<![endif]-->
		<?= $this->get_css_files(); ?>
		<?= $this->get_script_files(); ?>

	</head>
	<body>

		<div class="header">
			<a href="/"><img src="/img/logo.jpg" /></a>
		</div>

		<div class="bs-docs-example bs-navbar-top-example">
			<div class="navbar navbar-static-top">
				<div class="navbar-inner">
					<div class="container" style="width: auto; padding: 0 20px;">
						<ul class="nav map-toolbar">
							<li><a href="javascript:void(0);" title="Добавить POI" onclick="AddPOIExternal();"><img src="/img/icons/marker.png" /></a></li>
							<li><a href="javascript:void(0);" title="Добавить маршрут" onclick="alert('Еще не реализовано');"><img src="/img/icons/layer-shape-curve.png" /></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="span10 map-container">
				<div id="map"></div>
			</div>
			<div class="span2 poi-sidebar-list">
			</div>
		</div>

		<form name="poi_get_form">
			<input type="hidden" name="id" value="0" disabled="disabled" />
			<input type="hidden" name="zoom" value="<?= user::init()->get_session_param('map_zoom'); ?>" />
			<input type="hidden" name="width" value="0" />
			<input type="hidden" name="height" value="0" />
			<input type="hidden" name="latitude" value="<?= user::init()->get_session_param('map_latitude'); ?>" />
			<input type="hidden" name="longitude" value="<?= user::init()->get_session_param('map_longitude'); ?>" />
		</form>

		<script src="http://cdn.leafletjs.com/leaflet-0.4/leaflet.js"></script>
		<script type="text/javascript">

			var backend_host = 'http://backend.<?= SITE_HOST ?>:8080/';
			var latitude = <?= user::init()->get_session_param('map_latitude'); ?>;
			var longitude = <?= user::init()->get_session_param('map_longitude'); ?>;
			var zoom = <?= user::init()->get_session_param('map_zoom'); ?>;
			
			/* HTML templates functions */
			
			function htmlPopupActions() {
				return $('<div>', {
					class: 'popup_actions'
				})	.append($('<a>',{
						href: 'javascript:void(0);',
						title: 'Добавить POI'
					}).append('<img src="/img/icons/marker.png" />').bind('click', function(){AddPOIForm(); return false;})
				)
					.append($('<a>',{
						href: 'javascript:void(0);',
						title: 'Добавить маршрут'
					}).append('<img src="/img/icons/layer-shape-curve.png" />').bind('click', function(){alert('Еще не реализовано');})
				).get(0);
			}
			
			function htmlPOIPopup(poi) {
				return $('<div>', {
					class: 'popup_actions',
				})	.append($('<h6>').append(poi.name)
				)	.append($('<a>',{
						href: 'javascript:void(0);',
						title: 'Удалить POI'
					}).append('<img src="/img/icons/cross-script.png" />').bind('click', function(){DeletePOIForm(poi.id); return false;})
				)
					.append($('<a>',{
						href: 'javascript:void(0);',
						title: 'Редактировать POI'
					}).append('<img src="/img/icons/pencil.png" />').bind('click', function(){EditPOIForm(poi.id); return false;})
				).get(0);
			}

			function htmlAddPOIForm(popup) {
				return $('<form>', {
					class: 'popup_form',
					name: 'poi_add_form'
				})	.append($('<label>').append('Название*')
				)	.append($('<input>',{
						type: 'hidden',
						name: 'latitude',
						value: popup.latlng.lat
					})
				)	.append($('<input>',{
						type: 'hidden',
						name: 'longitude',
						value: popup.latlng.lng
					})
				)	.append($('<input>',{
						type: 'text',
						name: 'name'
					})
				)	.append($('<label>').append('Название*')
				)	.append($('<textarea>',{
						name: 'description'
					})
				)	.append($('<button>',{
						class: 'btn btn-mini',
						type: 'submit'
					}).append('Сохранить').bind('click', function(){AddPOI(); return false;})
				)	.append($('<div>',{
						id: 'loading'
					})
				).get(0);
			}

			function htmlEditPOIForm(poi) {
				return $('<form>', {
					class: 'popup_form',
					name: 'poi_edit_form'
				})	.append($('<label>').append('Название*')
				)	.append($('<input>',{
						type: 'hidden',
						name: 'latitude',
						value: poi.latitude
					})
				)	.append($('<input>',{
						type: 'hidden',
						name: 'longitude',
						value: poi.longitude
					})
				)	.append($('<input>',{
						type: 'hidden',
						name: 'id',
						value: poi.id
					})
				)	.append($('<input>',{
						type: 'text',
						name: 'name',
						value: poi.name
					})
				)	.append($('<label>').append('Название*')
				)	.append($('<textarea>',{
						name: 'description'
					}).append(poi.description)
				)	.append($('<button>',{
						class: 'btn btn-mini',
						type: 'submit'
					}).append('Сохранить').bind('click', function(){EditPOI(); return false;})
				)	.append($('<button>',{
						class: 'btn btn-mini',
						type: 'button'
					}).append('Отмена').bind('click', function(){EditPOICancel(poi.id); return false;})
				)	.append($('<div>',{
						id: 'loading'
					})
				).get(0);
			}

			function htmlDeletePOIForm(poi) {
				return $('<form>', {
					class: 'popup_form',
					name: 'poi_delete_form'
				})	.append($('<label>').append('Вы уверены, что хотите удалить POI?')
				)	.append($('<input>',{
						type: 'hidden',
						name: 'id',
						value: poi.id
					})
				)	.append($('<button>',{
						class: 'btn btn-mini',
						type: 'submit'
					}).append('Удалить').bind('click', function(){DeletePOI(); return false;})
				)	.append($('<button>',{
						class: 'btn btn-mini',
						type: 'button'
					}).append('Отмена').bind('click', function(){DeletePOICancel(poi.id); return false;})
				)	.append($('<div>',{
						id: 'loading'
					})
				).get(0);
			}

		</script>
	</body>
</html>
