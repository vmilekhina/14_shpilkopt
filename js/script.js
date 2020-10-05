jQuery(function() {
	$('input[placeholder], textarea[placeholder]').placeholder();
	$(".phone-mask").mask("+7 999 999 99 99");

	var nowTime = new Date();
	//Дата окончания акции
	var targetTime = new Date('25 Mar 2014 15:00:00');
	var diffSecs = Math.floor((targetTime.valueOf() - nowTime.valueOf()));
	
	// if ($("#map").length && $("#map").data('coord')) {
	// 	google.maps.event.addDomListener(window, 'load', initialize);
	// }

	/*
	 //Код для таймера "до конца недели"
	 var weekday = nowTime.getDay();
	 weekday = weekday == 0 ? 7 : weekday;
	 var day_offset = 60 * 60 * 24 - (((nowTime.valueOf() / 1000) % (60 * 60 * 24)) + (3600 * 4));
	 var diffSecs = Math.floor(((7 - weekday) * 1000 * 60 * 60 * 24) + (day_offset * 1000));*/

	dif(Math.floor(diffSecs / 1000));

	$('.callback-form').submit(function(e) {
		e.preventDefault();

		var $form = $(this),
				ok = true,
				$phone = $form.find('.phone');

		if (!/\d{11}/.test($phone.val().replace(/\D/g, ''))) {
			ok = false;
			$phone.addClass("error");
		} else
			$phone.removeClass("error");


		if (ok) {
			$form.ajaxSubmit({
				success: function(response) {
					hideModal();
					$form.get(0).reset();
					showModal('.thanks2-modal');
					setTimeout('hideModal()', 3000);
				}
			});
		}
	});
	
	$('.order-form, .order-modal-form').submit(function(e) {
		e.preventDefault();

		var $form = $(this),
				ok = true,
				$phone = $form.find('.phone');

		if (!/\d{11}/.test($phone.val().replace(/\D/g, ''))) {
			ok = false;
			$phone.addClass("error");
		} else
			$phone.removeClass("error");


		if (ok) {
			$form.ajaxSubmit({
				success: function(response) {
					hideModal();
					$form.get(0).reset();
					showModal('.thanks1-modal');
					setTimeout('hideModal()', 3000);
				}
			});
		}
	});
	
	
	
	/*$('.send-btn').click(function(e) {
	 e.preventDefault();
	 $(this).closest('form').submit();
	 });*/
	

	$('.call-request').click(function(e) {
		e.preventDefault();
		var mod = $('.modal.callback-modal');
		if (mod.hasClass('open')) {
			hideModal(mod);
			mod.removeClass('open');
		} else {
			showModal(mod);
			mod.addClass('open');
		}
	});
	$('.order-cons-btn').click(function(e) {
		e.preventDefault();
		var mod = $('.modal.order-modal');
		if (mod.hasClass('open')) {
			hideModal(mod);
			mod.removeClass('open');
		} else {
			showModal(mod);
			mod.addClass('open');
		}
	});
	
		$('.product-btns .order-btn').click(function(e) {
		e.preventDefault();
		var mod = $('.modal.order-modal');
		if (mod.hasClass('open')) {
			hideModal(mod);
			mod.removeClass('open');
		} else {
			showModal(mod);
			mod.addClass('open');
		}
	});


	$('.overlay, .modal .close-btn, .modal .modal-close-text').click(function(e) {
		e.preventDefault();
		hideModal('.modal');
		$('.modal').removeClass('open');
	});
	

});
function dif(diffSecs) {
	var sec = Math.floor(diffSecs % 60);
	var mins = Math.floor(diffSecs / 60) % 60;
	var hours = Math.floor(diffSecs / 60 / 60) % 24;
	var days = Math.floor(diffSecs / 60 / 60 / 24);

	var temp = convert(days, ['день', 'дня', 'дней']);
	$('.timer .days').html(temp[0] < 10 ? '0' + temp[0] : temp[0]);
	$('.timer .days-text').html(temp[1]);
	var temp = convert(hours, ['час', 'часа', 'часов']);
	$('.timer .hours').html(temp[0] < 10 ? '0' + temp[0] : temp[0]);
	$('.timer .hours-text').html(temp[1]);
	var temp = convert(mins, ['минута', 'минуты', 'минут']);
	$('.timer .mins').html(temp[0] < 10 ? '0' + temp[0] : temp[0]);
	$('.timer .mins-text').html(temp[1]);
	var temp = convert(sec, ['секунда', 'секунды', 'секунд']);
	$('.timer .secs').html(temp[0] < 10 ? '0' + temp[0] : temp[0]);
	$('.timer .secs-text').html(temp[1]);

	if (diffSecs > 0)
	{
		t = setTimeout(function() {
			dif(diffSecs - 1)
		}, 1000);
	}
}

function convert(n, ar) {
	var o = n % 10;
	var l, g;
	switch (o) {
		case 1:
			l = 0;
			break;
		case 2:
		case 3:
		case 4:
			l = 1;
			break;
		default:
			l = 2;
			break;
	}

	var g = n % 100;
	if (g == 10 || g == 11 || g == 12 || g == 13 || g == 14) {
		l = 2;
	}
	return [n, ar[l]];
}

function showModal(modal) {
	showModalTop(modal, 66);
}
function showModalTop(modal, top) {
	modal = modal instanceof jQuery ? modal : jQuery(modal);
	modal.css("top", top + "px");
	modal.show();
	$(".overlay").show();
}
function hideModal() {
	$(".modals > div").hide();
	$(".overlay").hide();
}
function checkEmail(mail) {
	return /^[a-zа-я0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+(\.[a-zа-я0-9,!#\$%&'\*\+/=\?\^_`\{\|}~-]+)*@[a-zа-я0-9-]+(\.[a-z0-9-]+)*\.([a-zрф]{2,})$/i.test(mail);
}

var map;
function initialize() {
	var coords = $("#map").data('coord').split(',');
	var center = $("#map").data('center').split(',');
    var mapOptions = {
        zoom: 15,
        center: new google.maps.LatLng(center[0],center[1]),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById('map'), mapOptions);
    marker = new google.maps.Marker({
        position: new google.maps.LatLng(coords[0],coords[1]),
        map: map,
        title: ""
    });
}