var map, popup, marker, poiLaver;

$(document).ready(function(){
	map = L.map('map').setView([latitude, longitude], zoom);

	L.tileLayer('http://{s}.tile.cloudmade.com/9529237a6b724b0a881b8b3a1270e149/997/256/{z}/{x}/{y}.png', {
		attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery <a href="http://cloudmade.com">CloudMade</a>',
		maxZoom: 18
	}).addTo(map);

	popup = L.popup();
	marker = new Array();
	poiLayer = L.layerGroup(marker);

	map.on('click', onMapClick);
			
	$('#map, .poi-sidebar-list').height($(window).height() - 125);

	$('form[name="poi_get_form"] input[name="width"]').val(parseInt($('#map').css('width')));
	$('form[name="poi_get_form"] input[name="height"]').val(parseInt($('#map').css('height')));

	$(window).resize(function(){
		$('#map, .poi-sidebar-list').height($(window).height() - 125);
		$('form[name="poi_get_form"] input[name="width"]').val(parseInt($('#map').css('width')));
		$('form[name="poi_get_form"] input[name="height"]').val(parseInt($('#map').css('height')));
	});

	GetPOI();
})

function onMapClick(e) {
	popup.latlng = e.latlng;
	popup
		.setLatLng(e.latlng)
		.setContent(htmlPopupActions())
		.openOn(map);
}


function GetPOI(id){
	if (typeof id == 'undefined'){
		send_request('get-poi', collect_params('poi_get_form'), 'GetPOIFetch');
	}
	else {
		$('form[name="poi_get_form"] input[name="id"]').removeAttr('disabled');
		$('form[name="poi_get_form"] input[name="id"]').val(id);
		send_request('get-poi', collect_params('poi_get_form'), 'GetPOIFetch');
		$('form[name="poi_get_form"] input[name="id"]').attr('disabled','disabled');
	}
}
function GetPOIFetch(data){
	if (typeof data.poi != 'undefined' && data.poi.length > 0) {
		for (var i = 0; i < data.poi.length; i++) {
			marker[data.poi[i].id] = L.marker([data.poi[i].latitude,data.poi[i].longitude])
							.bindPopup(htmlPOIPopup(data.poi[i]))
							.on('click', function(){
								$(".popup_actions .poi_description").dotdotdot({
									ellipsis	: '... ',
									wrap		: 'word'
								});
							});
			marker[data.poi[i].id].data = data.poi[i];
			poiLayer.addLayer(marker[data.poi[i].id]);
			poiLayer.addTo(map);
		}

	}
}


function EditPOIForm(id) {
	marker[id].unbindPopup().closePopup().bindPopup(htmlEditPOIForm(marker[id].data)).openPopup();
	return false;
}
function EditPOICancel(id) {
	marker[id].unbindPopup().closePopup().bindPopup(htmlPOIPopup(marker[id].data)).openPopup();
	$(".popup_actions .poi_description").dotdotdot({
		ellipsis	: '... ',
		wrap		: 'word'
	});

}
function EditPOI() {
	send_request('edit-poi', collect_params('poi_edit_form'), 'EditPOIFetch');
}
function EditPOIFetch(data){
	if (data.status == 'ok') {
		marker[data.poi.id].closePopup();
		poiLayer.removeLayer(marker[data.poi.id]);
		GetPOI(data.poi.id);
	}
}


function AddPOIExternal() {
	$('#map').css('cursor','crosshair');
	map.off('click', onMapClick);
	map.on('click', onMapClickAddPOI);
}
function onMapClickAddPOI(e) {
	popup.latlng = e.latlng;
	popup
		.setLatLng(e.latlng)
		.setContent(htmlAddPOIForm(popup))
		.openOn(map);
	$('#map').css('cursor','auto');
	map.on('click', onMapClick);
	map.off('click', onMapClickAddPOI);
}
function AddPOIForm() {
	popup.setContent(htmlAddPOIForm(popup));
}
function AddPOICancel(id) {
	map.closePopup(popup);
}
function AddPOI() {
	send_request('add-poi', collect_params('poi_add_form'), 'AddPOIFetch');
}
function AddPOIFetch(data){
	map.closePopup(popup);
	if (data.status == 'ok') {
		GetPOI(data.poi.id);
	}
}


function DeletePOIForm(id) {
	marker[id].unbindPopup().closePopup().bindPopup(htmlDeletePOIForm(marker[id].data)).openPopup();
}
function DeletePOICancel(id) {
	marker[id].unbindPopup().closePopup().bindPopup(htmlPOIPopup(marker[id].data)).openPopup();
	$(".popup_actions .poi_description").dotdotdot({
		ellipsis	: '... ',
		wrap		: 'word'
	});

}
function DeletePOI() {
	send_request('delete-poi', collect_params('poi_delete_form'), 'DeletePOIFetch');
}
function DeletePOIFetch(data){
	map.closePopup(popup);
	if (data.status == 'ok') {
		poiLayer.removeLayer(marker[data.poi.id]);
	}
}


function LoadImagePOIForm(id) {
	marker[id].unbindPopup().closePopup().bindPopup(htmlLoadImagePOIForm(marker[id].data)).openPopup();
	fileInputStyle('form[name="poi_load_image_form"] input[name="img"]');
}
function LoadImagePOICancel(id) {
	marker[id].unbindPopup().closePopup().bindPopup(htmlPOIPopup(marker[id].data)).openPopup();
	$(".popup_actions .poi_description").dotdotdot({
		ellipsis	: '... ',
		wrap		: 'word'
	});
}
function LoadImagePOI() {
	$('form[name="poi_load_image_form"] #loading').html('<img src="/img/loading.gif" />');
	$('form[name="poi_load_image_form"]').ajaxForm({
		target: '#preview',
		dataType: 'json',
		success: function(data){
			if (typeof data.status != 'undefined' && data.status == 'ok') {
				$('form[name="poi_load_image_form"] input[name="img"]').attr('type','hidden');
				$('form[name="poi_load_image_form"] input[name="img"]').val(data.poi.img);
				send_request('edit-poi', collect_params('poi_load_image_form'), 'LoadImagePOIFetch');
			}
			else {
				$('form[name="poi_load_image_form"] #loading').html('');
				showError('poi_load_image_form',data.error);
			}
		}
	}).submit();
}
function LoadImagePOIFetch(data){
	if (data.status == 'ok') {
		marker[data.poi.id].closePopup();
		poiLayer.removeLayer(marker[data.poi.id]);
		GetPOI(data.poi.id);
	}
}

