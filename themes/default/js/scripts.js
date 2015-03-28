function reload(id, url) {
	$(id).attr('src', url);
}
function toggle(object, mode, type) {
	mode = mode || false;
	type = type || false;
	if(type) {
		if($(object).css('display') == 'none') {
			$(object).css('display', 'block');
			$('#comment-form-state').html('Скрыть');
			$('#comment-form-toggle').css('border-bottom', '1px solid #C2C2C2');
		} else {
			$(object).css('display', 'none');
			$('#comment-form-state').html('Показать');
			$('#comment-form-toggle').css('border-bottom', '0');
		}
	} else {
		if(mode) {
			if($(object).get(0).type == 'password') {
				$(object).get(0).type = 'text';
				$('#show-hide').html('Скрыть');
			} else {
				$(object).get(0).type = 'password';
				$('#show-hide').html('Показать');
			}
		} else {
			if($(object).get(0).type == 'password') {
				$(object).get(0).type = 'text';
			} else {
				$(object).get(0).type = 'password';
			}
		}
	}
}

$(document).ready(function() {
	$('select, #avatar').styler();
	$('#comment-form-toggle').css('border-bottom', '0');
	$('#show-hide').html('Показать');
	$('#comment-form-state').html('Показать');
	$('#comment-form-box').css('display', 'none');
	$('div.tabs-content').hide();
	$('ul.tabs li:first').addClass('active').show();
	$('div.tabs-content:first').show();
	$('ul.tabs li[data-type="tab"]').click(function() {
		$('ul.tabs li').removeClass('active');
		$(this).addClass('active');
		$('div.tabs-content').hide();
		var activeTab = $(this).find('a').attr('data-href');
		$(activeTab).show();
		return false;
	});
	$('#comment-form-toggle').click(function(e) {
		toggle('#comment-form-box', true, true);
	});
	$('#show-hide').click(function(e) {
		toggle('#reg-password', true);
		toggle('#reg-re-password');
	});
	$('.menu .m-button').click(function(e) {
		e.stopPropagation();
		if($(this).parent().hasClass('selected')) {
			$('.menu .selected div div').removeClass('show');
			$('.menu .selected').removeClass('selected');
		} else {
			$('.menu .selected div div').removeClass('show');
			$('.menu .selected').removeClass('selected');
			if($(this).next('.subs').length) {
				$(this).parent().addClass('selected');
				$(this).next('.subs').children().addClass('show');
			}
		}
	});
	$(document).click(function() {
		$('.show').removeClass('show');
		$('.selected').removeClass('selected');
	});
});