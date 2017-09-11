function getRootUrl () {
  return $('.baseUrl').val();
}
function activeteStatus (inp,toHidden,toShow,toRemove,toAdd) {
	inp.prevAll(toHidden).addClass('hidden');
	inp.prevAll(toShow).removeClass('hidden');
	inp.parent().removeClass(toRemove);
	inp.parent().addClass(toAdd);
	inp.nextAll('.form-control-feedback').addClass('active');
}
function startAjax (btn) {
	btn.prevAll('.miniLoader').addClass('active');
	btn.addClass('disabled').attr('disabled', true);
}
function endAjax (response, btn) {
	btn.prevAll('.miniLoader').removeClass('active');
	removeResponseAjax();
	$('.responseAjax').addClass('alert-'+response.type).addClass('active');
}
function startIconAjax (btn) {
	btn.find('.fa').addClass('hidden');
	startAjax(btn);
}
function ajaxErrorWithIcon (btn) {
	btn.find('.fa-times').removeClass('hidden');
	ajaxError(btn);
}

function responseMsg(response)
{

	if (typeof response.msg == "object") {
		$('.responseAjax').children('p').html('<ul class="listErrors"></ul>');
		$.each(response.msg, function(index, val) {
			$('.listErrors').append('<li>'+val+'</li>');
		});
	}else
	{
		$('.responseAjax').children('p').html(response.msg);
	}
}
function ajaxError (btn) {
	endAjax ({ type: 'danger'}, btn);
	btn.removeClass('disabled').attr('disabled', false);
	$('.responseAjax').children('p').html('Ups, ha habido un error.');
}
function addValToElim (toAdd, esto) {
	esto.addClass('to-elim');
	$(toAdd).val(esto.val()).attr('data-url',esto.data('url')).attr('data-tosend',esto.data('tosend'));
}
function closeModalElim (boton) {
	$('.to-elim').removeClass('to-elim');
	$(boton).removeClass('disabled').attr('disabled', false);
	removeResponseAjax();
}
function elimSuccess (response, btn) {
	endAjax(response, btn)
	responseMsg(response);
	if (response.type == 'danger') {
		btn.removeClass('disabled').attr('disabled', false);
	}else
	{
		$('.to-elim').parent().parent().remove();
	}
}
function loadContentWithIcon (response, btn) {
	btn.find('.fa-check').removeClass('hidden');
	loadContent(response, btn);
}
function loadContent (response, btn) {
	$('.miniLoader').removeClass('active');
	btn.removeClass('disabled').attr('disabled', false);
	$('.partial-container').html(response);
}
function login (response, btn) {
	endAjax(response, btn)
	$('.responseAjax').children('p').html(response.msg);

	if (response.type == 'danger') {
		btn.removeClass('disabled').attr('disabled',false);
	}else
	{
		btn.addClass('disabled').attr('disabled',true);
		setTimeout(function() {
			window.location.reload();	
		},2000);
	}
}
function changePassSuccess(response, btn) {
	endAjax(response, btn);
	responseMsg(response);
	if (response.type != 'danger') {
		$('.validate-input').val('');
	}
	btn.removeClass('disabled').attr('disabled', false);

}
function removeResponseAjax() {
	$('.responseAjax').removeClass('alert-success');
	$('.responseAjax').removeClass('alert-danger');
	$('.responseAjax').removeClass('active');

}
function checkEmpty(inp) {
	if (inp.val() == "") {
		activeteStatus(inp,'.control-label','.label-control-danger','has-success','has-error');
		return 0;
	}else
	{
		activeteStatus(inp,'.control-label','.label-control-success','has-error','has-success');
		return 1;
	}
}
function restoreInput (inp) {
	inp.nextAll('.control-label').remove();
}
function addHtml (inp,toShow,msg) {
	var $content = $('<p></p>');
	$content.html(msg).addClass('control-label').addClass(toShow);
	inp.nextAll('.control-label').remove();
	inp.after($content);
}
function emptyMsg (inp) {
	var proceed = checkEmpty(inp);
	if (proceed == 0) {
		addHtml(inp,'.label-control-danger','El campo es obligatorio');
	}else
	{
		addHtml(inp,'.label-control-success','<i class="fa fa-check"></i>');

	}
	return proceed;
}
function validate() {
	var proceed = 1;
	$('.validate-input').each(function(index, el) {
		restoreInput($(el)); 
		if (checkEmpty($(el)) == 0) {
			emptyMsg($(el));
			proceed = 0;
		}
	});
	return proceed;
}
function doAjax(url, method, dataType, dataPost, btn, beforeSendCallback, successCallback, errorCallback) {
	$.ajax({
		headers: {'csrftoken': $('input[name = _token]').val()},
		url: url,
		type: method,
		dataType: dataType,
		data: dataPost,
		beforeSend: function(){
			beforeSendCallback(btn)
		},
		success: function(response){
			successCallback(response, btn);
		},
		error: function(){
			errorCallback(btn)
		}
	});
}
function clonarInput (target, name, btn) {
	var toClone = $('.'+target);
	var cloned = toClone.clone();
	toClone.removeClass(target).addClass('active');
	var inputs = toClone.find('.input-lang');
	inputs.each(function(index, el) {
		if (!btn.hasClass('no-lang')) {
			var lang = $('.lang-val')[index];
			if (btn.hasClass('btn-new')) {
				$(el).attr('name',name+'['+$(lang).val()+'][]');
			}else
			{
				$(el).attr('name',name+'['+$(lang).val()+']');
			}
		}else
		{
				$(el).attr('name',name);
		}
	});
	toClone.after(cloned);
	return toClone;
}
function applyAffix ($top, $bottom) {
	if ($(window).width() >= 768 && $(window).width() < 1024 && $('.filters-menu').length > 0) {
		$('.filters-menu').affix({
		 	offset: {
		    	top: $top.offset().top,
		    	bottom: function () {
		      		return this.bottom = parseInt($bottom.offset().top)+parseInt($('.filters-menu').height())
		    	}
			}
		});
	}
}
function beforeMisc(btn){
	var attr = btn.find('.miniLoader').attr('src');
	btn.html('<img src="'+attr+'" class="miniLoader active">');
}

function successMisc(response, btn){
	btn.html(response);
} 

function errorMisc(btn)
{
	btn.html('<div class="alert alert-danger">Ups, hubo un error, intentalo de nuevo</div>')
}
jQuery(document).ready(function($) {
	$('.contLoading').removeClass('active');
	$('.btn-submit').on('click', function(event) {
		var proceed = validate();
		
		if (proceed) {
			$('form').submit();
		};
	});
	$('.validate-input').on('focus', function(event) {
		restoreInput($(this)); 
	});
	$('#modalElim').on('hide.bs.modal', function(event) {
		closeModalElim('.btn-elim')
	});
	$('.btn-elim').on('click', function(event) {
		var btn = $(this);
		var url = btn.data('url');
		var dataPost = {};
		dataPost[btn.data('tosend')] = btn.val();
		doAjax(url, 'POST', 'json', dataPost, btn, startAjax, elimSuccess, ajaxError);
	});
});