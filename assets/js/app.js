(function ($) {

	$(document).ready(function () {

		$('#gshareOptionForm').submit(function () {
			$(this).ajaxSubmit({
				beforeSend: function (xhr) {
					$('#gshareSaveResult').html("<div id='gshareSaveMessage'></div>");
					$('#gshareSaveMessage').append("<p class='gshare-save-processing'>" + gshare_setting_params.save_processing + "</p>").show();
				},
				success: function () {
					$('#gshareSaveResult').html("<div id='gshareSaveMessage'></div>");
					$('#gshareSaveMessage').append("<p class='gshare-save-success'>" + gshare_setting_params.save_success + "</p>").show();
                },
                error: function() {
                    $('#gshareSaveResult').html("<div id='gshareSaveMessage'></div>");
					$('#gshareSaveMessage').append("<p class='gshare-save-error'>" + gshare_setting_params.save_error + "</p>").show();
                },
				timeout: 5000
			});
			setTimeout("jQuery('#gshareSaveMessage').hide('slow');", 5000);
			return false;
        });
        
        $('#gshareProOptionForm').submit(function () {
			$(this).ajaxSubmit({
				beforeSend: function (xhr) {
					$('#gshareProSaveResult').html("<div id='gshareProSaveMessage'></div>");
					$('#gshareProSaveMessage').append("<p class='gshare-save-processing'>" + gshare_setting_params.save_processing + "</p>").show();
				},
				success: function () {
					$('#gshareProSaveResult').html("<div id='gshareProSaveMessage'></div>");
					$('#gshareProSaveMessage').append("<p class='gshare-save-success'>" + gshare_setting_params.save_success + "</p>").show();
                },
                error: function() {
                    $('#gshareProSaveResult').html("<div id='gshareProSaveMessage'></div>");
					$('#gshareProSaveMessage').append("<p class='gshare-save-error'>" + gshare_setting_params.save_error + "</p>").show();
                },
				timeout: 5000
			});
			setTimeout("jQuery('#gshareProSaveMessage').hide('slow');", 5000);
			return false;
        });

		// Gshare tabs toggle
		$('.gshare-tab-link').on('click', function (e) {
			e.preventDefault();
			$targetTab = $(this).attr('href');
			$('.gshare-setting-tab').removeClass('active');
			$('.gshare-tab-link').removeClass('active');
			$($targetTab).addClass('active');
			$(this).addClass('active');
		});

		$('.image-radio-style-disable, .is-pro-field').on('click', function (e) {
			e.preventDefault();
			$('.gshare-setting-tab').removeClass('active');
			$('.gshare-tab-link').removeClass('active');
			$('#gshareProTab').addClass('active');
			$('.gshare-tab-link.get_pro').addClass('active');
			window.scrollTo(0, 0);
		});

		$('.gshare-color-picker').wpColorPicker();

		// add/remove checked class
		$(".image-radio-style").each(function () {
			if ($(this).find('input[type="radio"]').first().attr("checked")) {
				$(this).addClass('checked');
			} else {
				$(this).removeClass('checked');
			}
		});

		// sync the input state
		$(".image-radio-style").on("click", function (e) {
			if ($(this).hasClass('image-radio-style-disable')) {
				e.preventDefault();
				return false;
			} else {
				$(".image-radio-style").removeClass('checked');
				$(this).addClass('checked');
				var $radio = $(this).find('input[type="radio"]');
				$radio.prop("checked", !$radio.prop("checked"));

				e.preventDefault();
			}
		});


		// add/remove checked class
		$(".keen-radio-positionlink").each(function () {
			if ($(this).find('input[type="radio"]').first().attr("checked")) {
				$(this).addClass('checked');
			} else {
				$(this).removeClass('checked');
			}
		});

		// sync the input state
		$(".keen-radio-positionlink").on("click", function (e) {
			$(".keen-radio-positionlink").removeClass('checked');
			$(this).addClass('checked');
			var $radio = $(this).find('input[type="radio"]');
			$radio.prop("checked", !$radio.prop("checked"));

			e.preventDefault();
		});


		$.fn.multiselect = function () {
			$(this).each(function () {
				var checkboxes = $(this).find("input:checkbox");
				checkboxes.each(function () {
					var checkbox = $(this);
					// Highlight pre-selected checkboxes
					if (checkbox.prop("checked"))
						checkbox.parent().addClass("multiselect-on");

					// Highlight checkboxes that the user selects
					checkbox.click(function (e) {
						let thisName = checkbox.attr('name');
						if (checkbox.hasClass('is-pro-icon')) {
							e.preventDefault();
							return;
						}
						if (checkbox.val() == 'none') {
							e.preventDefault();
							$(`input[name="${thisName}"]`).prop('checked', false);
							$(`input[name="${thisName}"]`).parent().removeClass("multiselect-on");
							checkbox.prop("checked", true);
							checkbox.parent().addClass("multiselect-on");
						} else {
							if (checkbox.prop("checked")) {
								checkbox.parent().addClass("multiselect-on");
							} else {
								checkbox.parent().removeClass("multiselect-on");
							}
							if (!$('input[value="post"]').prop("checked") && !$('input[value="page"]').prop("checked")) {
								$('input[value="none"]').prop("checked", true);
								$('input[value="none"]').parent().addClass("multiselect-on");
							} else {
								$('input[value="none"]').prop("checked", false);
								$('input[value="none"]').parent().removeClass("multiselect-on");
							}
						}
					});
				});
			});
		};

		$(".keen-radio").multiselect();


	});

})(jQuery);
