/* ========================================================================
 * Notify 组件 by yaojia 2015.7.7 v0.0.1
 * ========================================================================
 * Copyright 2014 Connor Sears
 * Licensed under MIT (https://github.com/twbs/ratchet/blob/master/LICENSE)
 * ======================================================================== */

// 
// 待修正问题：
// 1.log提示类型 目前仅有错误类型
//动画方式取消过渡，改为animate
//增加loading
//用法示例
// notify.log('你好。。。');
// notify.menu('<li>删除</li>');     
// notify.info({title:'sdfsdf',content:'sdfsdfsdf'});

;!function (name, context, definition) {
   if (typeof module !== 'undefined') module.exports = definition(name, context)
   else if (typeof define === 'function' && typeof define.amd  === 'object') define(definition)
   else context[name] = definition(name, context)
}('Notify', this, function (name, context) {
 var Notify = function(opt) {
      this.queue = [];
      this.defaults = {
         shadow: true,
         container: $('body'),
         waitTime: 4e3
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
          var $e2 = $('<div style="position:fixed;top:0px;width:100%;" />');
          $e2.append($el);
         $('body').append($e2);
         //$el.appendTo();
         window.setTimeout(function() {
            $el.addClass('in');
         }, 100)

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

         console.log('_hide run');

         el.removeClass('in').on('transitionend', function() {
            el.remove();
         });
         $('#shadow').remove();


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
      alert:function(text, title, callbackOk){

      },
      create:function(){
         return new Notify
      }
   };

   return new Notify();
});

