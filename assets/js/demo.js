'use strict';
var Demo = function() {
    var runDemoTopbar = function() {
        if ($("#topbar-multiple").length) {
            $('#topbar-multiple').multiselect({
                buttonClass: 'btn btn-default btn-sm ph15',
                dropRight: true
            });
        }
    }
    var runDemoSettings = function() {
        if ($('#skin-toolbox').length) {
            $('#skin-toolbox .panel-heading').on('click', function() {
                $('#skin-toolbox').toggleClass('toolbox-open');
            });
            $('#skin-toolbox .panel-heading').disableSelection();
            var Breadcrumbs = $('#topbar');
            var Sidebar = $('#sidebar_left');
            var Header = $('.navbar');
            var Branding = Header.children('.navbar-branding');
            var headerSkins = "bg-primary bg-success bg-info bg-warning bg-danger bg-alert bg-system bg-dark";
            var sidebarSkins = "sidebar-light light dark";
            var settingsObj = {
                'headerSkin': '',
                'sidebarSkin': 'sidebar-default',
                'headerState': 'navbar-fixed-top',
                'sidebarState': 'affix',
                'breadcrumbState': 'relative',
                'breadcrumbHidden': 'visible',
            };
            var themeKey = 'admin-settings1';
            var themeGet = localStorage.getItem(themeKey);
            if (themeGet === null) {
                localStorage.setItem(themeKey, JSON.stringify(settingsObj));
                themeGet = localStorage.getItem(themeKey);
            }
            (function() {
                var settingsParse = JSON.parse(themeGet);
                settingsObj = settingsParse;
                $.each(settingsParse, function(i, e) {
                    switch (i) {
                        case 'headerSkin':
                            Header.removeClass(headerSkins).addClass(e);
                            Branding.removeClass(headerSkins).addClass(e + ' dark');
                            if (e === "bg-light") {
                                Branding.removeClass(headerSkins);
                            } else {
                                Branding.removeClass(headerSkins).addClass(e);
                            }
                            $('#toolbox-header-skin input[value="bg-light"]').prop('checked', false);
                            $('#toolbox-header-skin input[value="' + e + '"]').prop('checked', true);
                            break;
                        case 'sidebarSkin':
                            Sidebar.removeClass(sidebarSkins).addClass(e);
                            $('#toolbox-sidebar-skin input[value="bg-light"]').prop('checked', false);
                            $('#toolbox-sidebar-skin input[value="' + e + '"]').prop('checked', true);
                            break;
                        case 'headerState':
                            if (e === "navbar-fixed-top") {
                                Header.addClass('navbar-fixed-top');
                                $('#header-option').prop('checked', true);
                            } else {
                                Header.removeClass('navbar-fixed-top');
                                $('#header-option').prop('checked', false);
                                Sidebar.nanoScroller({
                                    destroy: true
                                });
                                Sidebar.find('.nano-content').attr('style', '');
                                Sidebar.removeClass('affix');
                                $('#sidebar-option').prop('checked', false);
                            }
                            break;
                        case 'sidebarState':
                            if (e === "affix") {
                                Sidebar.addClass('affix');
                                $('#sidebar-option').prop('checked', true);
                            } else {
                                Sidebar.nanoScroller({
                                    destroy: true
                                });
                                Sidebar.find('.nano-content').attr('style', '');
                                Sidebar.removeClass('affix');
                                $('#sidebar-option').prop('checked', false);
                            }
                            break;
                        case 'breadcrumbState':
                            if (e === "affix") {
                                Breadcrumbs.addClass('affix');
                                $('#breadcrumb-option').prop('checked', true);
                            } else {
                                Breadcrumbs.removeClass('affix');
                                $('#breadcrumb-option').prop('checked', false);
                            }
                            break;
                        case 'breadcrumbHidden':
                            if (e === "hidden") {
                                Breadcrumbs.addClass('hidden');
                                $('#breadcrumb-hidden').prop('checked', true);
                            } else {
                                Breadcrumbs.removeClass('hidden');
                                $('#breadcrumb-hidden').prop('checked', false);
                            }
                            break;
                    }
                });
            })();
            $('#toolbox-header-skin input').on('click', function() {
                var This = $(this);
                var Val = This.val();
                var ID = This.attr('id');
                Header.removeClass(headerSkins).addClass(Val);
                Branding.removeClass(headerSkins).addClass(Val + ' dark');
                settingsObj['headerSkin'] = Val;
                localStorage.setItem(themeKey, JSON.stringify(settingsObj));
            });
            $('#toolbox-sidebar-skin input').on('click', function() {
                var Val = $(this).val();
                Sidebar.removeClass(sidebarSkins).addClass(Val);
                settingsObj['sidebarSkin'] = Val;
                localStorage.setItem(themeKey, JSON.stringify(settingsObj));
            });
            $('#header-option').on('click', function() {
                var headerState = "navbar-fixed-top";
                if (Header.hasClass('navbar-fixed-top')) {
                    Header.removeClass('navbar-fixed-top');
                    headerState = "relative";
                    Sidebar.removeClass('affix');
                    Sidebar.nanoScroller({
                        destroy: true
                    });
                    Sidebar.find('.nano-content').attr('style', '');
                    Sidebar.removeClass('affix');
                    $('#sidebar-option').prop('checked', false);
                    $('#sidebar-option').parent('.checkbox-custom').addClass('checkbox-disabled').end().prop('checked', false).attr('disabled', true);
                    settingsObj['sidebarState'] = "";
                    localStorage.setItem(themeKey, JSON.stringify(settingsObj));
                    Breadcrumbs.removeClass('affix');
                    $('#breadcrumb-option').parent('.checkbox-custom').addClass('checkbox-disabled').end().prop('checked', false).attr('disabled', true);
                    settingsObj['breadcrumbState'] = "";
                    localStorage.setItem(themeKey, JSON.stringify(settingsObj));
                } else {
                    Header.addClass('navbar-fixed-top');
                    headerState = "navbar-fixed-top";
                    $('#sidebar-option').parent('.checkbox-custom').removeClass('checkbox-disabled').end().attr('disabled', false);
                    $('#breadcrumb-option').parent('.checkbox-custom').removeClass('checkbox-disabled').end().attr('disabled', false);
                }
                settingsObj['headerState'] = headerState;
                localStorage.setItem(themeKey, JSON.stringify(settingsObj));
            });
            $('#sidebar-option').on('click', function() {
                var sidebarState = "";
                if (Sidebar.hasClass('affix')) {
                    Sidebar.nanoScroller({
                        destroy: true
                    });
                    Sidebar.find('.nano-content').attr('style', '');
                    Sidebar.removeClass('affix');
                    sidebarState = "";
                } else {
                    Sidebar.addClass('affix');
                    if ($('.nano.affix').length) {
                        $(".nano.affix").nanoScroller({
                            preventPageScrolling: true
                        });
                    }
                    sidebarState = "affix";
                }
                $(window).trigger('resize');
                settingsObj['sidebarState'] = sidebarState;
                localStorage.setItem(themeKey, JSON.stringify(settingsObj));
            });
            $('#breadcrumb-option').on('click', function() {
                var breadcrumbState = "";
                if (Breadcrumbs.hasClass('affix')) {
                    Breadcrumbs.removeClass('affix');
                    breadcrumbState = "";
                } else {
                    Breadcrumbs.addClass('affix');
                    breadcrumbState = "affix";
                }
                settingsObj['breadcrumbState'] = breadcrumbState;
                localStorage.setItem(themeKey, JSON.stringify(settingsObj));
            });
            $('#breadcrumb-hidden').on('click', function() {
                var breadcrumbState = "";
                if (Breadcrumbs.hasClass('hidden')) {
                    Breadcrumbs.removeClass('hidden');
                    breadcrumbState = "";
                } else {
                    Breadcrumbs.addClass('hidden');
                    breadcrumbState = "hidden";
                }
                settingsObj['breadcrumbHidden'] = breadcrumbState;
                localStorage.setItem(themeKey, JSON.stringify(settingsObj));
            });
            $("#clearLocalStorage").on('click', function() {
                if (bootbox.confirm) {
                    bootbox.confirm("Are You Sure?!", function(e) {
                        if (e) {
                            setTimeout(function() {
                                localStorage.clear();
                                location.reload();
                            }, 200);
                        } else {
                            return;
                        }
                    });
                }
            });
        }
    }
    var runFullscreenDemo = function() {
        var selector = $('html');
        var ua = window.navigator.userAgent;
        var old_ie = ua.indexOf('MSIE ');
        var new_ie = ua.indexOf('Trident/');
        if ((old_ie > -1) || (new_ie > -1)) {
            selector = $('body');
        }
        var screenCheck = $.fullscreen.isNativelySupported();
        $('.request-fullscreen').click(function() {
            if (screenCheck) {
                if ($.fullscreen.isFullScreen()) {
                    $.fullscreen.exit();
                } else {
                    selector.fullscreen({
                        overflow: 'auto'
                    });
                }
            } else {
                alert('Your browser does not support fullscreen mode.')
            }
        });
    }
    return {
        init: function() {
            runDemoTopbar();
            runDemoSettings();
            runFullscreenDemo();
        }
    }
}();