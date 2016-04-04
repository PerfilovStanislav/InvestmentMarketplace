var GO = !0;

function onlyText(e) {$(this).val($(this).val().replace(/[^a-zа-я0-9 \-]/gi,''));}
function onlyEmail(e) {$(this).val($(this).val().replace(/[^a-z0-9\-_.@]/gi,'').replace(/(^[@\._]*)|@(?=.*@)/gi,''));}
function onlyNumber(e) {
	var v = $(this).val().replace(/[^\d.]/gi,'');
	$(this).val(v);
	if ((v.indexOf('.') === 0 && v.length > 1 && parseFloat(v) > 0) || v.indexOf('.') !== v.lastIndexOf('.')) toFloat(e);
}
function toFloat(e) {var v = parseFloat(e.target.value); e.target.value = isNaN(v) ? '' : v;}
function onlyUrl(e) {$(this).val($(this).val().replace(/[^a-zа-я0-9\-\.\/:\?\=\%]/gi,''));}

var initTypes = function() {
	$(this).find('.onlyText').on('input', onlyText);
	$(this).find('.onlyEmail').on('input', onlyEmail);
	$(this).find('.onlyNumber').on('input', onlyNumber).on('change', toFloat);
	$(this).find('.onlyUrl').on('input', onlyUrl);
}


var controls = function() {
	$(this).find('.copy').on('click', function() {
		var g = $(this).parent().prev();
		var p = g.find('>div:last');
		var c = p.clone().insertAfter(p);
		for (var i=0, l=p.find('select').length; i<l; i++) {
		   c.find('select:eq('+i+')').val(p.find('select:eq('+i+')').val());
		}
		reCountN(g);
		c.find('.remove').on('click', remove);
	});
		
	$(this).find('.remove').on('click', remove);
	
	$(this).find('.showPrev').on('click', function() {
	  $(this).parent().hide('slow').prev().show('slow');
	});
	
	
	form = $("#addproject_form");	
	$('[name]:not([type="checkbox"],[name="ref_percent[]"]):visible', form).on('focusin', function(e) {
		$(this).parent().removeClass('state-error');
	});
	$('div.langs, div.payments').find(':checkbox').on('click', function(e) {
		$('div.payments:has(:checked) label,div.langs:has(:checked) label', form).parent().removeClass('state-error');
	});
};

function remove() {
	var p = $(this).closest('div[role=row]');
	var g = p.closest('div[role=group]');
	if (g.find('>div').length !== 1) p.remove();
	reCountN(g);
}

function reCountN(el) {
	$(el).find('n').each(function(i) {$(this).text(i+1)});
}


/* ------------------------------------------------------------ IMAGE SHOW ------------------------------------------------------------ */
var imgClickInit = function() {
    $('.mix img').magnificPopup({
      type: 'image',
      callbacks: {
        beforeOpen: function(e) {
          $('body').addClass('mfp-bg-open');
          this.st.mainClass = 'mfp-zoomIn';
          this.contentContainer.addClass('mfp-with-anim');
        },
        afterClose: function(e) {
          setTimeout(function() {
            $('body').removeClass('mfp-bg-open');
            $(window).trigger('resize');
          }, 1000)
        },
        elementParse: function(item) {
          item.src = item.el.attr('src');
        },
      },
      overflowY: 'scroll',
      removalDelay: 200,
      prependTo: $('#content_wrapper')
    });
};

var addproject_form = function() {
	form.submit(function(){
		var a = $('[name]:not([type="checkbox"],[name="ref_percent[]"]):visible', form).filter(function(i) {return $(this).val() === "";})
			.add('div.payments:not(:has(:checked)) label,div.langs:not(:has(:checked)) label', form)
			.parent();
		a.addClass('state-error');
		if ($('#full_site_image').attr('src') === "") {
			$('label[for=inputImage]').addClass('btn-danger').removeClass('btn-primary');
			a = a.add('label[for=inputImage]');
		};
		if (a.length) {
			var v = a.eq(0).offset().top;
			$('html').animate({ scrollTop: v - 75}, 250+Math.abs($('html').scrollTop()-v)*0.5, 'easeOutQuad');
			return !1;
		}
		else if ($('#full_site_image').attr('src') === "") {
			alert('Загрузите скриншот сайта');
			return !1;
		}

		if (GO) {
			var d = $('#full_site_image').cropper('getCroppedCanvas');
			$('[name=screen_data]').val( $('#full_site_image').cropper('getCroppedCanvas', {width:Math.min(1280,d.width*960/d.height,d.width)}).toDataURL('image/jpeg', 0.8) );
			$('[name=thumb_data]').val( $('#thumb_site_image').cropper('getCroppedCanvas', {width:320}).toDataURL('image/jpeg', 0.8) );
			$.ajax({
			   type: 'POST',
			   url: SITE+'Projects/add',
			   //dataType: 'json',
			   data: form.serialize(),
			   beforeSend: function(data) {
					GO = !1;
			   },
			   success: function(data){
					console.log(data);
				 },
			   error: function (xhr, ajaxOptions, thrownError) {
					console.warn(2, xhr.status);
					console.warn(3, thrownError);
				 }
				,
			   complete: function(data) {
					GO = !0;
				 }

			});
		}
		return false;
	});
}


/**
 * USERS
 */