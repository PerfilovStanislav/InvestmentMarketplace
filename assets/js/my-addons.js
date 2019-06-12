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
    data: {ajax:' 1'},
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
        console.error(' ajaxError xhr', xhr);
        /*console.error(' ajaxError', ajaxOptions);
        console.error(' ajaxError', thrownError);*/
    }/*,
    success: function(result,status,xhr) {
        console.log('success', result,status,xhr);
    }*/
});

/* @TODO сделать вызов ajax запросов через очередь */
var abortAllAjax = function() {
    $.each(Q, function(i, xhr){
        xhr.abort();
    });
};

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

/* вызов массив функций для определённой области , элимента, формы*/
/*var callFunctions = function() {
    for (var i in arguments) {
        if (typeof(arguments[i]) == 'function') arguments[i].apply(this);      // вызов функции без параметров
        else arguments[i][0].apply(this, [arguments[i][1]]);                 // вызов функции с параметрами
    }
};*/

/* вызывается после каждого ответа с сервера
// умеет: отрисовывать вьюшки, вызывать методы, показывать ошибки и удачные запросы
// Порядок обработки находится в system/helpers/json_helper/default_sort
*/
var applyFunctions = function(key, value) {
    if (key === 'c') {
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
        $.each(value, function(type,data) {
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
    }
    else if (key === 'error' || key === 'success') {
        $.each(value, function(scope,params) {
            var $scope = getScope(scope);
            $.each(params, function (fields, values) {
                $.each(values, function (inputName, inputValue) {
                    var $input = $('input[name=' + inputName + ']', $scope);
                    if ($input.length) {
                        $input.on('focusin', function (e) {
                            $(this).parent().removeClass('state-error').removeClass('state-success').prev('.alert').slideToggle('fast', 'swing', function () {
                                this.remove()
                            });
                        });
                        $input.parent().addClass('state-' + key);

                        var $alert = $('#alert').clone().addClass('alert-' + (key === 'error' ? 'danger' : 'success')).removeAttr('id');
                        $alert.find('er').text(inputValue);
                        $alert.insertBefore($input.parent()).not(':visible');
                        $alert.find('button').on('click', function () {
                            $(this).parent().slideToggle('fast', 'swing', function () {
                                this.remove()
                            });
                        });
                    } else {
                        new PNotify({
                            title: inputName,
                            text: inputValue,
                            type: key,
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
    else if (key === 'f') {
        /*вызов методов в необходимой области видимости*/
        $.each(value, function(scope,functions) {
            $.each(functions, function(a, b) {
                if (parseInt(a).toString() == a) { /* if is number*/
                    a = b;
                    b = null;
                }
                window[a].apply(getScope(scope), [b]);
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
        case 'onlyUrl'      : filtered_str = str.replace(/[^a-zа-я0-9\-\.\/:\?\=\%]/gi,''); break;
        case 'onlyNumber'   : filtered_str = str.replace(/[^\d.]/gi,''); break;
        case 'onlyEmail'    : filtered_str = str.replace(/[^a-z0-9\-_.@]/gi,'').replace(/(^[@\._]*)|@(?=.*@)/gi,''); break;
        case 'onlyEn'       : filtered_str = str.replace(/[^a-z0-9 \-]/gi,''); break;
        case 'onlyText'     : filtered_str = str.replace(/[^a-zа-я0-9ё \-]/gi,''); break;
        case 'onlyDate'     : filtered_str = str.replace(/[^0-9\-]/gi,''); break;
    }
    if (str !== filtered_str) $el.val(filtered_str);
}

function toFloat(e) {var v = parseFloat(e.target.value); e.target.value = isNaN(v) ? '' : v;}
function onlyUrl    (e) {replace(e);}
function onlyNumber (e) {replace(e);}
function onlyEmail  (e) {replace(e);}
function onlyEn     (e) {replace(e);}
function onlyText   (e) {replace(e);}

var initTypes = function(el) {
	$('.onlyText'   , el).on('input', onlyText);
	$('.onlyEn'     , el).on('input', onlyEn);
	$('.onlyEmail'  , el).on('input', onlyEmail);
	$('.onlyNumber' , el).on('input', onlyNumber).on('change', toFloat);
	$('.onlyUrl'    , el).on('input', onlyUrl);
};

var UserAuthorization = function() {
    initTypes(this);

    var form = $("#authorizationuser_form");
    form.submit(function(){
        removeAlerts(form);
        var a = $('input', form).filter(function(i) {return $(this).val() === "";}).parent();

        if (a.length) {
            a.addClass('state-error');
            return !1;
        }

        allClear();
        ajax('/Users/authorize', form.serialize());
        return false;
    });
};

var removeAlerts = function(scope) {
    $('.alert', scope).slideToggle('fast', 'swing', function(){this.remove()});
};

var UserRegistration = function() {
    initTypes(this);

    var form = $("#adduser_form");
    $('input,textarea', form).on('focusin', function(e) {
        $(this).parent().removeClass('state-error').prev('.alert').slideToggle('fast', 'swing', function(){this.remove()});
    });
    form.submit(function(){
        removeAlerts(form);
        var a = $('input', form).filter(function(i) {return $(this).val() === "";}).parent();
        if ($('#confirm_pass').val() != $('input[name=password]', form).val()) a = a.add($('#confirm_pass').parent());

        if (a.length) {
            a.addClass('state-error');
            var v = a.eq(0).offset().top;
            $('html,body').animate({ scrollTop: v - 75}, 250+Math.abs($(document).scrollTop()-v)*0.5, 'easeOutQuad');
            return !1;
        }

        $.ajax({
            url: '/Users/add',
            data: form.serialize()
        });

        return false;
    });
};


var ProjectRegistration = function(a) {
    var form = $("#addproject_form");

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
        if ($('#full_site_image').attr('src') === "") {
            $('label[for=inputImage]').addClass('btn-danger').removeClass('btn-primary');
            a = a.add('label[for=inputImage]');
        }
        if (a.length) {
            a.addClass('state-error');
            var v = a.eq(0).offset().top;
            $('html,body').animate({ scrollTop: v - 75}, 250+Math.abs($(document).scrollTop()-v)*0.5, 'easeOutQuad');
            return !1;
        }
        else if ($('#full_site_image').attr('src') === "") {
            alert(LOCALE.load_site_screen);
            return !1;
        }

        var d = $('#full_site_image').cropper('getCroppedCanvas');
        $('[name=screen_data]').val($('#full_site_image').cropper('getCroppedCanvas', {width:Math.min(1280,d.width*960/d.height,d.width)}).toDataURL('image/jpeg', 0.95) );
        $('[name=thumb_data]').val($('#thumb_site_image').cropper('getCroppedCanvas', {width:320}).toDataURL('image/jpeg', 1.0) );
        $.ajax({
           url: '/Investment/add',
           data: form.serialize(),
        });

        return false;
    });

    $(function () {
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


        /* Import image*/
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
    $('.thumbnail>img', $(this)).magnificPopup({
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
    var panelScroller = $(this).find('.panel-scroller');
    if (panelScroller.length) {
         panelScroller.each(function(i, e) {
             $(e).scroller({
                 trackMargin: 2,
                 handleSize: 20
             });
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
        dateFormat: 'yy-mm-dd',
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
    $(document).on('click', 'a.ajax', function(e) {
        var $target = $(e.currentTarget);
        var functions = $target.data('beforesend');
        if (functions) {
            applyFunctions('f', functions);
        }
        abortAllAjax();
        stopTimers();
        ajax($target.attr('href'), [], $target.hasClass('page'))
        return false;
    });
};

var loadRealThumbs = function () {
    $('.thumbnail>img', this).each(function(i,img) {
        var realThumb = img.getAttribute('realthumb');
        if (realThumb) img.setAttribute('src', realThumb);
    });
}

var ajax = function(url, data, page) {
    var tmp = {url: url};
    if (data) tmp.data = data;
    if (page && url !== window.location.pathname) {
        window.history.pushState(null, null, url);
    }
    $.ajax(tmp);
};

var initChat = function() {
    $('.icon_send', this).on('click', function(e) {
        $(this).parent().parent().submit();
    });
    $("form[chat_id]").submit(function(e){
        var message = $(this).find('[name=message]').val();
        if (!message.length) return false;
        if (_.contains([1,2,4,5], STORAGE.status)) {
            clearTimeout(STORAGE.chatTimer);
            STORAGE.status = 1;
        }
        else if (STORAGE.status == 3) {
            STORAGE.status = 6;
        }
        ajax(
            '/Investment/sendMessage/project/'+$(this).attr('chat_id'),
            {message: $(this).find('[name=message]').val()}
        );
        $(this).find('[name=message]').val('');
        return false;
    });
};

var startChatCheck = function() {
    if (STORAGE.status != 6) {
        STORAGE.status = 2; /* подготовка к отправке*/
        STORAGE.chatTimer = setTimeout(checkChats, 3000);
    }
};

var checkChats = function() {
    var data = $('form[chat_id]').map(function(i,el){
        var id = $(el).attr('chat_id');
        return {id: id, max_id:(_.isEmpty(STORAGE.chat[id])?0:STORAGE.chat[id].max)}
    }).get();
    STORAGE.status = 3; /* отправлен запрос на проверку наличия новых сообщений*/
    ajax('/investment/getChatMessages/', {chats:data});
};
var setNewChatMessages = function(data) {
    STORAGE.status = 4; /* сообщения получены*/
    if (!_.isEmpty(data)) {
        var messages = data.messages;
        for (var project_id in messages) {
            STORAGE.chat[project_id] = _.extend({}, STORAGE.chat[project_id]);
            var proj_mess = messages[project_id];
            STORAGE.chat[project_id].max = _.max(_.keys(proj_mess), function(x){ return parseInt(x); });
            var $panel_scroller = $('[project_id='+project_id+'] .chat-widget .panel-scroller').eq(0);
            var $scroller_content = $panel_scroller.find('.scroller-content').eq(0);
            for (var id in proj_mess) {
                var mess = proj_mess[id];
                var $chat_block = $('#chatMessage').children().clone();
                $chat_block.find('.media-position').addClass('media-' + ((STORAGE.user.id||0) == mess.user_id  ||  (STORAGE.user.session_id||0) == mess.session_id ? 'right' : 'left'))
                    .find('img.media-object').attr('src', '/assets/img/avatars2/'+(((mess.user_id||mess.session_id||1)-1)%30+1)+'.webp')
                $chat_block.find('.date_create').text(mess.date_create);
                $chat_block.find('.message').text(mess.message);
                $chat_block.find('.media-heading').text(
                    mess.user_id && !_.isEmpty(data['users']) && !_.isEmpty(data['users'][mess.user_id])
                        ? data['users'][mess.user_id]['name']
                        : getRandomNameBySessionId(mess.session_id)
                );
                $scroller_content.append($chat_block)
            }
            $scroller_content.css('scroll-behavior', 'smooth');
            $panel_scroller.scroller('reset').scroller('scroll', 999999);
            $scroller_content.css('scroll-behavior', '');
        }
    }
    STORAGE.status = 5; /* сообщения отрисованы*/
};

var getRandomNameBySessionId = function(sessionId) {
    return ['Domestic', 'Wild', 'Furry', 'Herbivorous', 'Dangerous', 'Ferocious', 'Poisonous', 'Agile', 'Clever',
        'Aggressive', 'Beautiful', 'brave', 'Strong', 'Smart', 'Hungry', 'Angry', 'Fast', 'Strong', 'Gracious'][sessionId%19]
        + ' '
        + ['Crocodile', 'Bunny', 'Bear', 'Cow', 'Cat', 'Dog', 'Donkey', 'Elephant', 'Frog', 'Giraffe',
        'Hamster', 'Horse', 'Dragon', 'Octopus', 'Kangaroo', 'Lamb', 'Raccoon', 'Parrot', 'Panda', 'Poulpe',
        'Ant-eater', 'Mouse', 'Lion', 'Turtle', 'Unicorn', 'Snake', 'Whale', 'Fish', 'Bull', 'Zebra'][(sessionId-1)%30];
};

var setStorage = function(data) {
    STORAGE = addToObject(STORAGE, data);
};

var logoInConsole = function() {
    var common = 'font-family: "Open Sans", Helvetica, Arial, sans-serif; font-weight: bold; padding-right: 1px;';
    var blue = 'font-size: 36px; color: #0af; text-shadow: -1px 1px 1px #00425f';
    var red  = 'font-size: 32px; color: #f33; text-shadow: -1px 1px 1px #722';
    console.log('%c Rich%cinMe', common+blue, common+red);
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
