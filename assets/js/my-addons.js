"use strict";
var STORAGE;
var setDefaultStorage = function() {
    STORAGE = {chat: {}}
};
setDefaultStorage();
var xhrId = 0, Q = {};
/* устанавливаем параметры для всех аякс запросов*/
$.ajaxSetup({
    type: "POST",
    data: {ajax:'1'},
    dataType: 'json',
    beforeSend: function(xhr, status) {
        xhr.xhrId = ++xhrId;
        Q[xhr.xhrId] = xhr;
    },
    complete: function(xhr, status) {
        delete Q[xhr.xhrId];
        if (xhr.responseJSON) $.each(xhr.responseJSON, applyFunctions);
        linkAjaxQueue();
    },
    error: function (xhr, ajaxOptions, thrownError) {
        /* console.error(' ajaxError xhr', xhr);
        console.error(' ajaxError', ajaxOptions);
        console.error(' ajaxError', thrownError); */
    }
});

var abortAllAjax = function() {
    $.each(Q, function(i, xhr){
        xhr.abort();
    });
};

/* data-beforesend='{"f":["allClear"]}' */
var allClear = function() {
    abortAllAjax();
    stopTimers();
    setDefaultStorage();
};

var ajaxQueue = [];
var addToAjaxQueue = function(links) {
    ajaxQueue = ajaxQueue.concat(links)
};
var linkAjaxQueue = function () {
    if (!ajaxQueue.length) return false;
    ajax(ajaxQueue.shift());
};

var stopTimers = function() {
    clearTimeout(STORAGE.chatTimer);
};

/* вызывается после каждого ответа с сервера
// умеет: отрисовывать вьюшки, вызывать методы, показывать ошибки и удачные запросы
*/
var applyFunctions = function(key, value) {
    if (key === 'view') {
        /*отрисовываем вьюшки*/
        $.each(value, function(k,v) {
            $('#' + k).html(v);
        });
    }
    else if (key === 'data') {        /* data обрабатывается самими функциями*/
        return true;
    }
    /* всё хорошо  либо просто уведомление*/
    else if (key === 'alert') {
        $.each(value, function(scope,data) {
            $.each(data, function(type,data) {
                $.each(data, function(title,text) {
                    new PNotify({
                        title: title,
                        text: text,
                        type: type,
                        width: "290px",
                        delay: 4000
                    });
                });
            });
        });
    }
    else if (key === 'field') {
        $.each(value, function(scope,params) {
            var $scope = getScope(scope);
            $.each(params, function (field, typeWithdescription) {
                $.each(typeWithdescription, function (type, description) {
                    var $input = $('input[name=' + field + ']', $scope);
                    if ($input.length) {
                        $input.on('focusin', function (e) {
                            $(this).parent().removeClass('state-error').removeClass('state-success').prev('.alert').slideToggle('fast', 'swing', function () {
                                this.remove()
                            });
                        });
                        $input.parent().addClass('state-' + (type === 'success' ? type : 'error'));

                        var $alert = $('#alert').clone().addClass('alert-' + type).removeAttr('id');
                        $alert.find('er').text(description);
                        $alert.insertBefore($input.parent()).not(':visible');
                        $alert.find('button').on('click', function () {
                            $(this).parent().slideToggle('fast', 'swing', function () {
                                this.remove()
                            });
                        });
                    } else {
                        new PNotify({
                            title: field,
                            text: description,
                            type: type,
                            width: "290px",
                            delay: 4000
                        });
                    }
                });
            })
            $('.alert:not(:visible)', $('#main')).slideToggle('fast');

            if ($('.state-error').length) {
                var v = $('.state-error').eq(0).offset().top;
                if (v) $('html,body').animate({scrollTop: v - 75}, 250 + Math.abs($(document).scrollTop() - v) * 0.5, 'easeOutQuad');
            }
        })
    }
    else if (key === 'function') {
        /*вызов методов в необходимой области видимости*/
        $.each(value, function(priority,scopes) {
            $.each(scopes, function(scope,functions) {
                $.each(functions, function(functionName, params) {
                    window[functionName].apply(getScope(scope), [params]);
                });
            });
        });
    }
};

var getScope = function (scope) {
    return scope === 'document' ? document : $('#'+scope);
};

function replace(e) {
    var filtered_str, $el = $(e.currentTarget);
    var str = $el.val();
    switch (e.handleObj.handler.name) {
        case 'onlyUrl'      : filtered_str = str.replace(/[^a-zа-я0-9\-\.\/:\?\=\%&#]/gi,''); break;
        case 'onlyNumber'   : filtered_str = str.replace(/[^\d.]/gi,''); break;
        case 'onlyEmail'    : filtered_str = str.replace(/[^a-z0-9\-_.@]/gi,'').replace(/(^[@\._]*)|@(?=.*@)/gi,''); break;
        case 'onlyEn'       : filtered_str = str.replace(/[^a-z0-9 \-]/gi,''); break;
        case 'onlyLogin'    : filtered_str = str.replace(/[^a-z0-9\-]/gi,''); break;
        case 'onlyDate'     : filtered_str = str.replace(/[^0-9\-]/gi,''); break;
    }
    if (str !== filtered_str) $el.val(filtered_str);
}

function toFloat(e) {var v = parseFloat(e.target.value); e.target.value = isNaN(v) ? '' : v;}
function onlyUrl    (e) {replace(e);}
function onlyNumber (e) {replace(e);}
function onlyEmail  (e) {replace(e);}
function onlyEn     (e) {replace(e);}
function onlyLogin  (e) {replace(e);}

var initTypes = function(el) {
	$('.onlyEn'     , el).on('input', onlyEn);
	$('.onlyLogin'  , el).on('input', onlyLogin);
	$('.onlyEmail'  , el).on('input', onlyEmail);
	$('.onlyNumber' , el).on('input', onlyNumber).on('change', toFloat);
	$('.onlyUrl'    , el).on('input', onlyUrl);
};

// var UserAuthorization = function() {
//     initTypes(this);
//
//     var form = $("#authorizationuser_form");
//     form.submit(function(){
//         removeAlerts(form);
//         var a = $('input', form).filter(function(i) {return $(this).val() === "";}).parent();
//
//         if (a.length) {
//             a.addClass('state-error');
//             return !1;
//         }
//
//         allClear();
//         ajax('/Users/authorize', form.serialize());
//         return false;
//     });
// };

var removeAlerts = function(scope) {
    $('.alert', scope).slideToggle('fast', 'swing', function(){this.remove()});
};

var ProjectRegistration = function(a) {
    var form = $("#addproject_form");

    initTypes(this);
    datePickerInit(this);
	$('.copy', this).on('click', function() {
		var g = $(this).parent().prev();
		var p = g.find('>div:last');
		var c = p.clone().insertAfter(p);
        $('[name]', c).on('focusin', function(e) {
            $(this).parent().removeClass('state-error');
        });

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

    $('.check', this).on('click', function() {
        var data = {};
        $(this).parent().find('input').each(function(i,el) {data[$(el).attr('name')] = $(el).val()});

        $('.alert-dismissable:visible', form).remove();
        $.ajax({
            url: '/Investment/checkWebsite/showsuccess/1',
            data: data
        });
    });

	$('[name]:not([type="checkbox"],[name="ref_percent[]"]):visible', form).on('focusin', function(e) {
		$(this).parent().removeClass('state-error');
	});
	$('div.langs, div.payments').find(':checkbox').on('click', function(e) {
		$('div.payments:has(:checked) label,div.langs:has(:checked) label', form).parent().removeClass('state-error');
	});

    $('div.langs :checkbox').on('click', function(e) {
        if ($(this).is(":checked")) {
            var $el = $('.description:eq(0)').clone().attr('id', 'desc_'+$(this).val());
            $('.description:last').after($el);
            $el.show();
            $el.find('textarea').attr('name', 'description[' + $(this).val()+']')
                .attr('placeholder', $('.description:eq(0) textarea').attr('placeholder') +$(this).parent().find('txt').text());
            $el.find('textarea').on('focusin', function(e) {
                $(this).parent().removeClass('state-error');
            });
            $(this).next().next().clone().appendTo($el.find('.field-icon'));
        }
        else {
            $('#desc_'+$(this).val()).remove();
        }
    });
    $('div.langs :checkbox:checked').attr('checked', false).trigger('click');


	form.submit(function(){
        var a = $('[name]:not([type="checkbox"],[name="ref_percent[]"]):visible', form).filter(function(i) {return $(this).val() === "";})
            .add('div.payments:not(:has(:checked)) label,div.langs:not(:has(:checked)) label', form)
            .parent();
        /*if ($('#full_site_image').attr('src') === "") {
            $('label[for=inputImage]').addClass('btn-danger').removeClass('btn-primary');
            a = a.add('label[for=inputImage]');
        }*/
        if (a.length) {
            a.addClass('state-error');
            var v = a.eq(0).offset().top;
            $('html,body').animate({ scrollTop: v - 75}, 250+Math.abs($(document).scrollTop()-v)*0.5, 'easeOutQuad');
            return !1;
        }
        /*else if ($('#full_site_image').attr('src') === "") {
            alert(LOCALE.load_site_screen);
            return !1;
        }*/

        /*var d = $('#full_site_image').cropper('getCroppedCanvas');
        $('[name=screen_data]').val($('#full_site_image').cropper('getCroppedCanvas', {width:Math.min(1280,d.width*960/d.height,d.width)}).toDataURL('image/jpeg', 0.95) );
        $('[name=thumb_data]').val($('#thumb_site_image').cropper('getCroppedCanvas', {width:320}).toDataURL('image/jpeg', 1.0) );
        */
        $.ajax({
           url: '/Investment/add',
           data: form.serialize(),
        });

        return false;
    });

    /*$(function () {
        'use strict';

        function debugBase64(base64URL){
            var win = window.open();
            win.document.write('<iframe src="' + base64URL  + '" frameborder="0" style="border:0; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%;" allowfullscreen></iframe>');
        }

        var console = window.console || { log: function () {} };
        var $full_site_image = $('#full_site_image');
        var $thumb_site_image = $('#thumb_site_image');
        var base64 = '';

        $('#download').on('click', function () {
            debugBase64(base64);
        })

        $full_site_image.cropper();
        $thumb_site_image.cropper({aspectRatio: 4/3});




      $('.docs-buttons').on('click', '[data-method]', function () {
        var $this = $(this);
        var data = $this.data();
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
          base64 = result.toDataURL('image/jpeg', 0.9);
    	  $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
        }
      });


        /!* Import image*!/
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

    });*/

};

var initForms = function(a) {
    $('form', this).each(function(i, form) {
        $('[name]:not([type="checkbox"],[name="ref_percent[]"])', form).on('focusin', function(e) {
            $(this).parent().removeClass('state-error');
        });

        initTypes(form);
        $(form).submit(function(event) {
            var _form = event.currentTarget;
            removeAlerts(_form);

            $('input:visible,textarea:visible', _form).each(function(i, input) {
                input.value = input.value.trim()
            });

            var a = $('[name]:not([type="checkbox"],[name="ref_percent[]"]):visible', _form).filter(function(i) {return $(this).val() === "";})
                .add('div.payments:not(:has(:checked)) label,div.langs:not(:has(:checked)) label', form)
                .parent();

            if ($('#confirm_pass').val() !== $('input[name=password]', form).val()) {
                a = a.add($('#confirm_pass').parent());
            }

            if (a.length) {
                a.addClass('state-error');
                var v = a.eq(0).offset().top;
                $('html,body').animate({ scrollTop: v - 75}, 250+Math.abs($(document).scrollTop()-v)*0.5, 'easeOutQuad');
                return !1;
            }
            $.ajax({
                url: _form.action,
                data: $(_form).serialize(),
            });
            return false;
        });
    });
};

var initFormPurchaseBanner = function(a) {
    var cost = 3;

    var form = this[0].querySelector('form');
    var tomorrow = (new Date()).addDays(1)

    var calc = (start, end) => {
        var count = (Math.abs(end-start))/(1000*60*60*24) + 1, discount = Math.min(count - 1, 30);
        form.querySelector('#days_count').value = count;
        form.querySelector('#discount').value = discount;
        form.querySelector('#amount').value = cost * count * (100 - discount) / 100;
    }

    var reCalc = () => {
        var fn = (className) => {return +form.querySelector(className).getAttribute('data-time')};
        calc(fn('.is-start-date'), fn('.is-end-date'))
    }

    new Litepicker({
        elementEnd: document.getElementById('end-date'),
        element: document.getElementById('start-date'),
        lang: 'en-US',
        numberOfMonths: 2,
        numberOfColumns: 2,
        mobileFriendly: true,
        singleMode: false,
        minDate: tomorrow.toISOString(),
        inlineMode: true,
        startDate: tomorrow.toISOString(),
        endDate: tomorrow.addDays(6).toISOString(),
        onSelect: calc,
        onShowTooltip: reCalc
    });

    form.querySelector('[type=file]').addEventListener('change', function(e) {
        var file = e.target.files[0];
        e.target.nextElementSibling.value = file.name + ' (' + (file.size / 1024).toFixed(2) + ' KiB)';
    })

    var positions = form.querySelectorAll('[name=position]');
    [].forEach.call(positions, function(posElement) {
        posElement.addEventListener('change', (e) => {
            cost = [0, 3, 2][e.target.value]
            reCalc()
        })
    });

    form.onsubmit = function(e) {
        $.ajax({
            type: 'POST',
            url: '/purchase/prepare',
            data: new FormData(e.target),
            cache: false,
            timeout: 600000,
            processData: false,
            contentType: false
        });
        return false;
    };

    initTypes(this)
};

var setBanners = function (data) {
    var length = data.length
    var rand = Math.floor(Math.random() * length)
    var bnrs = this[0].querySelector(".bnrs")
    for (const [key, value] of Object.entries(data)) {
        var k = (parseInt(key) + rand) % length + 1
        var span = bnrs.querySelector("span:nth-child("+k+")")
        span.querySelector("a").setAttribute('href', value.url)
        span.querySelector("a img").setAttribute('src', '/assets/bnrs/' + value.path)
    }
}

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
    $('img[href]', this).magnificPopup({
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
          item.src = item.el.attr('href');
        }
      },
      /*overflowY: 'scroll',*/
      removalDelay: 200,
      prependTo: $('#content_wrapper')
    });
};

/* ------------------------------------------------------------ SCROLLERS ------------------------------------------ */
 var panelScrollerInit = function() {
    var panelScroller = $(this).find('.panel-scroller:visible');
    if (panelScroller.length) {
         panelScroller.each(function(i, e) {
             $(e).scroller({
                 trackMargin: 2,
                 handleSize: 20
             });
         });
    }
};

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
        dateFormat: 'yy-mm-dd',
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        beforeShow: function(input, inst) {
        var themeClass = $(el).parents('.admin-form').attr('class');
        var smartpikr = inst.dpDiv.parent();
        if (!smartpikr.hasClass(themeClass)) {
          inst.dpDiv.wrap('<div class="' + themeClass + '"></div>');
        }
      }
    });

    // }).on("changeDate", function(e) {
    //     //console.log(e.date);
    //     var date = e.date;
    //     var startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
    //     var endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay()+6);
    //     //$('#weekpicker').datepicker("setDate", startDate);
    //     $(".datepicker").datepicker('update', startDate);
    //     $(".datepicker").val((startDate.getMonth() + 1) + '/' + startDate.getDate() + '/' +  startDate.getFullYear() + ' - ' + (endDate.getMonth() + 1) + '/' + endDate.getDate() + '/' +  endDate.getFullYear());
    // });
};

/* ------------------------------------------------------------ FULLSCREEN BUTTONS ---------------------------------- */
var adminPanelInit = function() {
	$('.admin-panels',this).adminpanel();
};

var linkClick = function() {
    $(document).on('click', 'a.ajax', function(e) {
        var $target = $(e.currentTarget);
        var isNewPage = $target.hasClass('page');
        var functions = $target.data('beforesend');
        if (functions) {
            applyFunctions('f', functions);
        }
        ajax($target.attr('href'), [], isNewPage)
        $('html,body').animate({scrollTop: 0}, 250, 'easeOutQuad');
        return false;
    });
};

var loadRealThumbs = function () {
    $('img[realthumb]', this).each(function(i,img) {
        var realThumb = img.getAttribute('realthumb');
        if (realThumb) img.setAttribute('src', realThumb);
    });
};

var ajax = function(url, data, isNewPage) {
    var tmp = {url: url};
    if (data) tmp.data = data;
    if (isNewPage) {
        abortAllAjax();
        stopTimers();
        if (url !== window.location.pathname) {
            window.history.pushState(null, null, url);
        }
    }
    $.ajax(tmp);
};

var changeUrl = function(data) {
    window.history.pushState(null, null, data.url);
};

var redirect = function(data) {
    document.location.href = data.url;
};

var setStorage = function(data) {
    STORAGE = addToObject(STORAGE, data);
};

var setParams = function(data) {
    $.ajaxSetup({
        data: {webp:data.webp}
    })
    setStorage({auth:data.auth})
};

var showInConsole = function(data) {
    console.dir(data);
};

var logoInConsole = function() {
    var common = 'font-family: "Open Sans", Helvetica, Arial, sans-serif; font-weight: bold; padding-right: 1px;';
    var blue = 'font-size: 36px; color: #0af; text-shadow: -1px 1px 1px #00425f';
    var red  = 'font-size: 32px; color: #f33; text-shadow: -1px 1px 1px #722';
    console.log('%c Rich%cinMe', common+blue, common+red);
};

var setProjectTitle = function(data) {
    $('input[name="name"]', this).val(data['title']);
};

var setPaymentType = function(data) {
    $('select[name="paymenttype"]', this).val(data['paymentType'])
};

var setPayments = function(data) {
    data['payments'].forEach(function(e) {
        var el = $('.payments input[name="id_payments[]"][value='+e+']');
        if (!el.is(":checked")) {
            el.trigger('click')
        }
    });
};

var setDescriptions = function(data) {
    var descriptions = data['descriptions'];
    for (var i in descriptions) {
        var el = $('.langs input[name="lang[]"][value='+i+']');
        if (!el.is(":checked")) {
            el.trigger('click')
        }
        $('textarea[name="description['+i+']"]').val(descriptions[i])
    }
};

var setPlans = function(data) {
    data['plans'].forEach(function callback(values, i, plans) {
        if (i < plans.length-1) {
            $('#add_plan').trigger('click')
        }
        $('input[name="plan_percents[]"]').eq(i).val(values[0])
        $('input[name="plan_period[]"]').eq(i).val(values[1])
        $('select[name="plan_period_type[]"]').eq(i).val(values[2]);
    });
};

var setMinDeposit = function (data) {
    $('input[name="min_deposit"]').val(data['deposit']);
    $('select[name="currency"]').val(data['currency']);
}

var setReferralPlans = function(data) {
    data['plans'].forEach(function callback(value, i, plans) {
        if (i < plans.length-1) {
            $('#add_ref_plan').trigger('click')
        }
        $('input[name="ref_percent[]"]').eq(i).val(value)
    });
};

var setDatepicker = function(data) {
    $('input[name=start_date]').datepicker("setDate", new Date(data['date']*1000) );
};

jQuery(document).ready(function() {
    Core.init();
    Demo.init();

    $(window).bind('popstate', function(e) {
        ajax(location.pathname);
    });

    linkClick();
    logoInConsole();
});
