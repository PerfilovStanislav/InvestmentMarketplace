var initChat = function() {
    abortAllAjax();
    stopTimers();

    $('.icon_send', this).on('click', function(e) {
        $(this).parent().parent().submit();
    });
    STORAGE.status = 1;

    $("form[chat_id]").submit(function(e){
        var message = $(this).find('[name=message]').val();
        if (!message.length || STORAGE.status === 5) return false;

        STORAGE.status = 5; /* Отправляем сообщение */
        abortAllAjax();
        stopTimers();
        ajax(
            '/Investment/sendMessage/project/' + $(this).attr('chat_id') + '/lang/' + STORAGE.lang,
            {message: $(this).find('[name=message]').val()}
        );
        $(this).find('[name=message]').val('');
        return false;
    });
};

var checkChats = function(___) {
    if (!_.contains([1,2,5], STORAGE.status)) return false;

    var data = $('form[chat_id]').map(function(i,el){
        var project_id = $(el).attr('chat_id');
        return {project_id: project_id, id:(_.isEmpty(STORAGE.chat[project_id])?0:STORAGE.chat[project_id].id)}
    }).get();
    STORAGE.status = 3; /* отправлен запрос на проверку наличия новых сообщений */
    ajax('/investment/getChatMessages/lang/' + STORAGE.lang, {messages:data});
};

var sleepAndCheckChats = function() {
    STORAGE.status = 2; /* подготовка к отправке запроса да получение */
    STORAGE.chatTimer = setTimeout(checkChats, 3000);
};

var setNewChatMessages = function(data) {
    STORAGE.status = 4; /* сообщения получены*/
    var messages = data.messages
    if (!_.isEmpty(data)) {
        for (var messageId in messages) {
            var message = messages[messageId];
            var project_id = message.project_id;
            var SCP = (STORAGE.chat[project_id] = _.extend({project_id:project_id}, STORAGE.chat[project_id]));
            SCP.id = SCP.id === undefined ? message.id : _.max([SCP.id, message.id]);
            var $panel_scroller = $('[project_id='+project_id+'] .chat-widget .panel-scroller').eq(0);
            var $scroller_content = $panel_scroller.find('.scroller-content').eq(0);
            var $chat_block = $('#chatMessage').children().clone();
            $chat_block.find('.media-position').addClass('media-' + (message.me ? 'right' : 'left'))
                .find('img.media-object').attr('src', message.avatar)
            $chat_block.find('.date_create').text(message.date_create);
            if (message.html) {
                $chat_block.find('.message').html(message.message);
            } else {
                $chat_block.find('.message').text(message.message);
            }
            $chat_block.find('.media-heading').text(message.name);
            $scroller_content.append($chat_block);
            $scroller_content.css('scroll-behavior', 'smooth');
            $panel_scroller.scroller('reset').scroller('scroll', 999999);
            $scroller_content.css('scroll-behavior', '');
        }
    }
    STORAGE.status = 1; /* сообщения отрисованы*/
};