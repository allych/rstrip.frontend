function showError(name, message) {
	$('form[name="' + name + '"] #error').show();
	$('form[name="' + name + '"] #error').html( typeof message != 'undefined' ? message : 'Error in connection with server' );
}

function slider() {
	if(typeof jQuery().nivoSlider == 'function') {
		$('#slider').nivoSlider({
			effect:'fade', //Specify sets like: 'fold,fade,sliceDown'
			slices:15,
			animSpeed:500,
			pauseTime:3000,
			startSlide:0, //Set starting Slide (0 index)
			directionNav:true, //Next & Prev
			directionNavHide:true, //Only show on hover
			controlNav:true, //1,2,3...
			controlNavThumbs:false, //Use thumbnails for Control Nav
			controlNavThumbsFromRel:false, //Use image rel for thumbs
			controlNavThumbsSearch: '.jpg', //Replace this with...
			controlNavThumbsReplace: '_thumb.jpg', //...this in thumb Image src
			keyboardNav:true, //Use left & right arrows
			pauseOnHover:true, //Stop animation while hovering
			manualAdvance:false, //Force manual transitions
			captionOpacity:0.8, //Universal caption opacity
			beforeChange: function(){},
			afterChange: function(){},
			slideshowEnd: function(){} //Triggers after all slides have been shown
		});
	}
}

function update_captcha(){
	if (jQuery('#captcha') != undefined){
		var ts = new Date().getTime();
		jQuery('#captcha').attr('src','/captcha?ts='+ts);
	}
}

function send_request (action, params, func) {
	jQuery('#loading').html('<img src="/img/loading.gif" />');
	var ts = new Date().getTime();
	jQuery.ajax({
		url: backend_host + '?action=' + action,
		type: 'get',
		jsonp: 'callback',
		dataType: 'jsonp',
		contentType: 'application/json; charset=utf-8',
		data: JSON.parse(params),
		success: function(data){
				jQuery('#loading').html('');
				if (typeof func != 'undefined' && func != '') eval(func+'(data)');
			},
		error: function (errMsg) {
				alert('Error: ' + errMsg);
			}

	});
}

function collect_params(form_name){
	var params = '';
	if (jQuery('form[name="'+form_name+'"]') != undefined){
		var parameters = new Array();
		params = new Array();
		var form_elements = jQuery('form[name="'+form_name+'"]:last input[type="text"], form[name="'+form_name+'"]:last input[type="password"], form[name="'+form_name+'"]:last input[type="hidden"], form[name="'+form_name+'"]:last input[type="checkbox"], form[name="'+form_name+'"]:last input[type="radio"], form[name="'+form_name+'"]:last select, form[name="'+form_name+'"]:last textarea');

		form_elements.each(function(){
			if (!jQuery(this).is(':disabled')){
				if ((!jQuery(this).is('input[type="checkbox"]') && !jQuery(this).is('input[type="radio"]')) || jQuery(this).is(':checked')){
					var str = jQuery(this).val();
					if (str == undefined){
						str = '';
					}
					str = str_replace('"','``',str);
					str = str_replace("'",'`',str);
					parameters[jQuery(this).attr('name')] = str;
				}
			}
		});

		for (var key in parameters){
			var value = parameters[key];
			if (typeof value != 'function')
				params[params.length] = '"' + key + '":"' + value.replace(/\r\n|\r|\n/g,' ') + '"';
		}
		params = '{' + params.join(',') + '}';
	}
	return params;
}

function in_array(what, where) {
	for(var i=0; i<where.length; i++)
		if(what == where[i])
			return true;
	return false;
}
function str_replace(search, replace, subject){
	return subject.split(search).join(replace);
}

