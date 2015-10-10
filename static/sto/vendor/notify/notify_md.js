/* ========================================================================
 * Notify 组件 by yaojia 2015.7.7 v0.0.1
 * ========================================================================
 * Copyright 2014 Connor Sears
 * ======================================================================== */

define(["jquery"], function($) {

    function transitionEnd() {
        // 创建一个元素用于测试
        var el = document.createElement('bootstrap');

        // 将所有主流浏览器实现方式整合成一个对象，用于遍历
        // key   是属性名称
        // value 是事件名称
        var transEndEventNames = {
            WebkitTransition: 'webkitTransitionEnd',
            MozTransition: 'transitionend',
            OTransition: 'oTransitionEnd otransitionend',
            transition: 'transitionend'
        };

        // 循环遍历上面那个对象，判断 CSS 属性是否存在
        for (var name in transEndEventNames) {
            if (el.style[name] !== undefined) {
                return {
                    end: transEndEventNames[name]
                };
            }
        }

        return false;
    }
    var transition = transitionEnd();
    $.support.transition = transitionEnd();


    var Notify = function(opt) {
        this.queue = [];
        this.defaults = {
                shadow: true,
                container: $('body'),
                waitTime: 3e3
            }
            // $.extend(this.defaults, opt, {});

        this.templates = {
            dialog: '<div class="notify-dialog">' +
                '<div class="notify-content">' +
                '<div class="notify-header">' +
                '<i class="glyphicon glyphicon-check"></i>' +
                '</div>' +
                '<div class="notify-title"><%title%></div>' +
                '<div class="notify-body"><%content%></div>' +
                '<div class="notify-footer">' +
                '<button type="button" class="btn btn-success" data-dismiss="notify">取消</button>' +
                '<button type="button" class="btn btn-success" data-dismiss="notify">确定</button>' +
                '</div>' +
                '</div>' +
                ' </div> ' +
                '</div>',
            menubar: '<div class="notify-dialog">' +
                '<div class="notify-content">' +
                '<div class="notify-body"><ul class="block"><%content%></ul>' +
                '<div class="block"><a class="cancel" data-type="cancel" href="#">取消</a></div>' +
                '</div>' +
                '</div>' +
                ' </div> ' +
                '</div>',
            msg: '<div class="notify-dialog">' +
                '<div class="notify-content">' +
                '<div class="notify-body"><%content%></div>' +
                '</div>' +
                ' </div> ' +
                '</div>',
            alert: '<div class="notify-alert">' +
                '<div class="notify-content">' +
                '<div class="notify-title"><%title%></div>' +
                '<div class="notify-body"><%content%></div>' +
                '<div class="notify-footer">' +
                '<button type="button" class="btn btn-success">确定</button>' +
                '</div>' +
                '</div>' +
                '</div>'
        }


        // this._setupEl();

    }
    Notify.prototype = {
        constructor: Notify,
        _setupEl: function() { //msg menu  modal-dialog  模板和数据
            var _this = this;
            if (!this.queue.length) {
                return
            };
            console.log(this.queue);
            var msg = this.queue.shift();

            var TemplateEngine = function(tpl, data) {
                var re = /<%([^%>]+)?%>/g;
                var match;
                while (match = re.exec(tpl)) {
                    tpl = tpl.replace(match[0], data[match[1]])
                }
                return tpl;
            }

            console.log(this.templates[msg.type]);

            var outHtml = TemplateEngine(this.templates[msg.type], msg.data);


            var $el = $('<div class="notify-' + msg.type + '"/>');
            $el.html(outHtml);
       
            $('body').append($el);
            window.setTimeout(function() {
                $el.addClass('in');
            }, 20)

            this.el = $el;

            //如果是msg类型 自动消失

            switch (msg.type) {
                case 'msg':
                    window.setTimeout(function() {
                        _this._hide($el)
                    }, this.defaults.waitTime);
                    break;
                case 'menubar':
                    if (this.defaults.shadow) {
                        this._createShadow()
                    }
                    $('[data-type="cancel"]').on('click', function() {
                        _this._hide($el);
                    });



            }



        },

        _hide: function(el) {


            var el = el || this.el;

            console.log('_hide run' + $.support.transition);

            el.removeClass('in').on('transitionend', function() {
                el.remove();
            });


            $('#shadow').remove();


            if ($.support.transition) {

                el.removeClass('in').one($.support.transition.end, function() {
                    el.remove();
                });

            } else {
                el.remove();
            }


        },

        _createShadow: function() {

            if ($('#shadow').size()) {
                return
            };

            $('<div id="shadow">').css({
                position: 'absolute',
                left: 0,
                top: 0,
                right: 0,
                bottom: 0,
                zIndex: 998,
                width: '100%',
                height: '100%',
                background: '#000',
                opacity: '0.5'
            }).appendTo($('body'));

        },
        menubar: function(html) {

            var MSG = {
                type: 'menubar',
                data: {
                    content: html
                }
            };
            this.queue.push(MSG);
            this._setupEl();
        },
        log: function(html) {

            var MSG = {
                type: 'msg',
                data: {
                    content: html
                }
            };
            this.queue.push(MSG);
            this._setupEl()

        },
        alert: function(text, title, callbackOk) {

        },
        create: function() {
            return new Notify
        }
    };

    return notify = new Notify();
});
