(function (factory) {
  /* global define */
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as an anonymous module.
    define(['jquery'], factory);
  } else if (typeof module === 'object' && module.exports) {
    // Node/CommonJS
    module.exports = factory(require('jquery'));
  } else {
    // Browser globals
    factory(window.jQuery);
  }
}(function ($) {

  // minimal dialog plugin
  $.extend($.summernote.plugins, {
    /**
     * @param {Object} context - context object has status of editor.
     */
    'SximoMedia': function (context) {
      var self = this;

      // ui has renders to build ui elements.
      //  - you can create a button with `ui.button`
      var ui = $.summernote.ui;

      var $editor = context.layoutInfo.editor;
      var options = context.options;
      
      // add context menu button
      context.memo('button.SximoMedia', function () {
        return ui.button({
          contents: '<i class="fa fa-plus"/> Insert Media',
          tooltip: 'Sximo 5 Media',
          click: context.createInvokeHandler('SximoMedia.showDialog')
        }).render();
      });


      // This methods will be called when editor is destroyed by $('..').summernote('destroy');
      // You should remove elements on `initialize`.
      self.destroy = function () {
        self.$dialog.remove();
        self.$dialog = null;
      };

      self.showDialog = function () {        
        SximoMedia();
      };
      
     

    }
  });

}));
