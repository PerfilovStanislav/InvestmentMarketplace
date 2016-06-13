var GO = !0;
var beforeSend = function(d) {GO = !1;};
var complete = function(d) {GO = !0;};
var $userHead = $('#userHead');

function onlyText(e) {$(this).val($(this).val().replace(/[^a-zа-я0-9ё \-]/gi,''));}
function onlyEn(e) {$(this).val($(this).val().replace(/[^a-z0-9]/gi,''));}
function onlyEmail(e) {$(this).val($(this).val().replace(/[^a-z0-9\-_.@]/gi,'').replace(/(^[@\._]*)|@(?=.*@)/gi,''));}
function onlyNumber(e) {
	var v = $(this).val().replace(/[^\d.]/gi,'');
	$(this).val(v);
	if ((v.indexOf('.') === 0 && v.length > 1 && parseFloat(v) > 0) || v.indexOf('.') !== v.lastIndexOf('.')) toFloat(e);
}
function toFloat(e) {var v = parseFloat(e.target.value); e.target.value = isNaN(v) ? '' : v;}
function onlyUrl(e) {$(this).val($(this).val().replace(/[^a-zа-я0-9\-\.\/:\?\=\%]/gi,''));}

var initTypes = function(el) {
	$('.onlyText', el).on('input', onlyText);
	$('.onlyEn', el).on('input', onlyEn);
	$('.onlyEmail', el).on('input', onlyEmail);
	$('.onlyNumber', el).on('input', onlyNumber).on('change', toFloat);
	$('.onlyUrl', el).on('input', onlyUrl);
}

var reload = function() {
    alert(this);
    location.reload();
}

var UserAuthorization = function() {
    initTypes(this);

    var form = $("#authorizationuser_form");
    $('input', form).on('focusin', function(e) {
        $(this).parent().removeClass('state-error');
    });
    form.submit(function(){
        $f = $(this);
        var a = $('input', form).filter(function(i) {return $(this).val() === "";}).parent();

        if (a.length) {
            a.addClass('state-error');
            return !1;
        }

        if (GO) {
            $.ajax({
                type: 'POST',
                url: SITE+'Users/authorize',
                data: form.serialize(),
                beforeSend: beforeSend,
                success: function(data){
                    if (data === 'userAuthorized') location.reload();
                },
                complete: complete

            });
        }
        return false;
    });
};


var UserRegistration = function() {
    initTypes(this);

    var form = $("#adduser_form");
    $('input', form).on('focusin', function(e) {
        $(this).parent().removeClass('state-error');
    });
    form.submit(function(){
        var a = $('input', form).filter(function(i) {return $(this).val() === "";}).parent();
        if ($('#confirm_pass').val() != $('input[name=password]', form).val()) a = a.add($('#confirm_pass').parent());

        if (a.length) {
            a.addClass('state-error');
            var v = a.eq(0).offset().top;
            $('html').animate({ scrollTop: v - 75}, 250+Math.abs($('html').scrollTop()-v)*0.5, 'easeOutQuad');
            return !1;
        }

        if (GO) {
            $.ajax({
                type: 'POST',
                url: SITE+'Users/add',
                data: form.serialize(),
                beforeSend: beforeSend,
                success: function(data){
                    console.log(data);
                },
                complete: complete

            });
        }
        return false;
    });
};


var ProjectRegistration = function() {
    initTypes(this);
    datePickerInit(this);
	$('.copy', this).on('click', function() {
		var g = $(this).parent().prev();
		var p = g.find('>div:last');
		var c = p.clone().insertAfter(p);
		for (var i=0, l=p.find('select').length; i<l; i++) {
		   c.find('select:eq('+i+')').val(p.find('select:eq('+i+')').val());
		}
		reCountN(g);
		c.find('.remove').on('click', remove);
	});
		
	$('.remove', this).on('click', remove);
	
	$('.showPrev',this).on('click', function() {
	  $(this).parent().hide('slow').prev().show('slow');
	});


    var form = $("#addproject_form");
	$('[name]:not([type="checkbox"],[name="ref_percent[]"]):visible', form).on('focusin', function(e) {
		$(this).parent().removeClass('state-error');
	});
	$('div.langs, div.payments').find(':checkbox').on('click', function(e) {
		$('div.payments:has(:checked) label,div.langs:has(:checked) label', form).parent().removeClass('state-error');
	});


	form.submit(function(){
        var a = $('[name]:not([type="checkbox"],[name="ref_percent[]"]):visible', form).filter(function(i) {return $(this).val() === "";})
            .add('div.payments:not(:has(:checked)) label,div.langs:not(:has(:checked)) label', form)
            .parent();
        if ($('#full_site_image').attr('src') === "") {
            $('label[for=inputImage]').addClass('btn-danger').removeClass('btn-primary');
            a = a.add('label[for=inputImage]');
        };
        if (a.length) {
            a.addClass('state-error');
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
               beforeSend: beforeSend,
               success: function(data){
                    console.log(data);
               },
               error: function (xhr, ajaxOptions, thrownError) {
                    console.warn(2, xhr.status);
                    console.warn(3, thrownError);
               },
               complete: complete

            });
        }
        return false;
    });

    $(function () {

      'use strict';

      var console = window.console || { log: function () {} };
      var $full_site_image = $('#full_site_image');
      var $thumb_site_image = $('#thumb_site_image');
      var $download = $('#download');

      $full_site_image.cropper();
      $thumb_site_image.cropper({aspectRatio: 4/3});




      // Methods
      $('.docs-buttons').on('click', '[data-method]', function () {
        var $this = $(this);
        var data = $this.data();
        var $target;
        var result;
    	var $preview = data.control == 1 ? $full_site_image : $thumb_site_image;

        if ($this.prop('disabled') || $this.hasClass('disabled')) {
          return;
        }


        if ($preview.data('cropper') && data.method) {
    	  if (data.control == 1) {
    		var d = $preview.cropper('getCroppedCanvas');
    	    data.option = {width:Math.min(1280,d.width*960/d.height,d.width)};
    	  } else {data.option = {width:320};}

          data = $.extend({}, data);

          result = $preview.cropper(data.method, data.option);
    	  $download.attr('href', result.toDataURL('image/jpeg', 0.9));
    	  $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
        }
      });


      // Import image
      var $inputImage = $('#inputImage');
      var URL = window.URL || window.webkitURL;
      var blobURL;

      if (URL) {
        $inputImage.change(function () {
    	  $inputImage.parent().addClass('btn-primary').removeClass('btn-danger');
          var files = this.files;
          var file;

          if (!$full_site_image.data('cropper')) {
            return;
          }

          if (files && files.length) {
            file = files[0];

            if (/^image\/\w+$/.test(file.type)) {
              blobURL = URL.createObjectURL(file);
              $full_site_image.one('built.cropper', function () {
    				$thumb_site_image.one('built.cropper', function () {
    					URL.revokeObjectURL(blobURL);
    					$('button[data-control]').removeClass('disabled');
    			  }).cropper('reset').cropper('replace', blobURL);
              }).cropper('reset').cropper('replace', blobURL);
              $inputImage.val('');
            } else {
              window.alert('Please choose an image file.');
            }
          }
        });
      } else {
        $inputImage.prop('disabled', true).parent().addClass('disabled');
      }

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


/* ------------------------------------------------------------ IMAGE SHOW ------------------------------------------ */
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


/* #TODO УДАЛИТЬ */
/*var tagsInit = function() {
	// Init tagsinput plugin
    $("input#tagsinput").tagsinput({
      tagClass: function(item) {
        return 'label label-default';
      },
	  allowDuplicates: true,
	  confirmKeys: [13, 44, 32]
    });
}*/

 /* ------------------------------------------------------------ SCROLLERS ------------------------------------------ */
 var panelScrollerInit = function() {
	var panelScroller = $(this).find('.panel-scroller');
	if (panelScroller.length) {
		 panelScroller.each(function(i, e) {
			var This = $(e);
			var Delay = This.data('scroller-delay');
			var Margin = 5;
			if (This.hasClass('scroller-thick')) {
			   Margin = 0;
			}
			var DropMenuParent = This.parents('.dropdown-menu');
			if (DropMenuParent.length) {
			   DropMenuParent.prev('.dropdown-toggle').on('click', function() {
				  setTimeout(function() {
					 This.scroller();
					 $('.navbar').scrollLock('on', 'div');
				  }, 50);
			   });
			   return;
			}
			if (Delay) {
			   var Timer = setTimeout(function() {
				  This.scroller({
					 trackMargin: Margin,
				  });
				  $('#content').scrollLock('on', 'div');
			   }, Delay);
			} else {
			   This.scroller({
				  trackMargin: Margin,
			   });
			   $('#content').scrollLock('on', 'div');
			}
		 });
	}
}

/* ------------------------------------------------------------ SCROLL CHANGE --------------------------------------- */
var changeScrollContentHeight = function() {
	if(!$('body').hasClass('panel-fullscreen-active')) {
		$('#content .scroller').each(function() {
			var mh = $('.rating-star:eq(0)').offset().top - $('.col-xs-4 .thumbnail').offset().top;
			$(this).css('max-height', (mh)+'px').scroller("reset");
		});
	}
	else {
		$('#content .panel-fullscreen .scroller').css('max-height', ($(window).height()-80)+'px').scroller("reset");
	}
};

/* ------------------------------------------------------------ DATEPICKER ------------------------------------------ */
var datePickerInit = function(el) {
	$(".datepicker").datepicker({
      prevText: '<i class="fa fa-chevron-left"></i>',
      nextText: '<i class="fa fa-chevron-right"></i>',
      beforeShow: function(input, inst) {
        var newclass = 'admin-form';
        var themeClass = $(el).parents('.admin-form').attr('class');
        var smartpikr = inst.dpDiv.parent();
        if (!smartpikr.hasClass(themeClass)) {
          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
        }
      }
    });
}


/* ------------------------------------------------------------ FULLSCREEN BUTTONS ---------------------------------- */
var adminPanelInit = function() {
	$('.admin-panels',this).adminpanel();
}


var linkClick = function() {
    $('a[href*="/"]', this).click(function() {
        var url = $(this).attr('href');
        $.ajax({
            url:  url,
            type: "POST",
            data: {ajax:' 1'},
            success: function(data){
                refreshAllowed = true;
                $.each(data, applyFunctions);
            },
            dataType: 'json'
        });

        if(url != window.location){
            window.history.pushState(null, null, url);
        }

        return false;
    });
}


var applyFunctions = function(key, value) {
    if (key === 'functions') {
        value();
    }
    else {
        $('#' + key).fadeOut(300, 'linear', function () {
            $('#' + key).html(value);
            $('html').scrollTop(0);
            startAllNeedFunctions.apply($('#' + key));
            $('#' + key).fadeIn(500, 'linear');
        });
    }
}



jQuery(document).ready(function() {
    "use strict";
    Core.init();
    Demo.init();

    $(window).bind('popstate', function(e) {
        if (refreshAllowed) {
            $.ajax({
                url: location.pathname,
                type: "POST",
                data: {ajax:' 1'},
                success: function(data) {
                    $.each(data, applyFunctions);
                },
                dataType: 'json'
            });
        }
    });

	// ###   ###   ###		выполняем все необходимые скрипты для текущей страницы из массива
	startAllNeedFunctions.apply(document);
});

function startAllNeedFunctions() {
	while(script = scripts.shift()) {
		window[script].apply(this);
	}
};