function endSelectLoadAjax (btn) {
	btn.removeClass('disabled').attr('disabled', false);
}
function beforeSelectLoad (btn) {
	$(btn.data('target')).find('.option-response').remove();
	btn.addClass('disabled').attr('disabled', true);
}
function successSelectLoad (response, btn) {
	endSelectLoadAjax(btn);
	$(btn.data('target')).append(response);
}
function loadCarreers (btn, old = null) {
	var dataPost = {}
	if (old) {		
		dataPost.old = old;
	}
	dataPost.id = btn.val();
	doAjax(btn.data('url'), 'GET', 'html', dataPost, btn, beforeSelectLoad, successSelectLoad, endSelectLoadAjax)
}
jQuery(document).ready(function($) {
	$('.btn-elim-carreer').on('click', function(event) {
		$('.elim-title').html('Eliminar Carrera');
		addValToElim ($('.btn-elim'), $(this));
	});
	$('.btn-elim-course').on('click', function(event) {
		$('.elim-title').html('Eliminar Curso');
		addValToElim ($('.btn-elim'), $(this));
	});
	$('.btn-elim-schedule').on('click', function(event) {
		$('.elim-title').html('Eliminar Horario');
		addValToElim ($('.btn-elim'), $(this));
	});
	$('.btn-elim-assignment').on('click', function(event) {
		$('.elim-title').html('Eliminar Asignación');
		addValToElim ($('.btn-elim'), $(this));
	});
	$('.carreers').on('change', function(event) {
		loadCarreers($(this));		
	});
	$('.enrollment-course').on('change', function(event) {
		loadCarreers($(this));		
	});
});