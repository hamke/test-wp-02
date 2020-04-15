(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 var wpqs4c = {};
   wpqs4c.speed4china = function() {
     var $ = jQuery, _this = this;
     $(document).on('click', '#using-gravatar-yes', function() {
       $('#local-avatar-row').fadeOut('normal');
     }).on('click', '#using-gravatar-no', function() {
       $('#local-avatar-row').fadeIn('normal');
     }).on('click', '#local-avatar-row label, #local-avatar', function() {
       event.preventDefault();
       var title = $('#local-avatar img').attr('title');
       if ( typeof _this.file_frame == 'object' ) {
         _this.file_frame.open();
         return;
       }
       _this.file_frame = wp.media.frames.file_frame = wp.media({
         title: title,
         button: {
           text: title,
         },
         multiple: false
       });
       _this.file_frame.on( 'open', function() {
         var selection = _this.file_frame.state().get('selection');
         var attachment_id = $('#upload-avatar').val();
         if (attachment_id) {
           var attachment = wp.media.attachment(attachment_id);
           attachment.fetch();
           selection.add( attachment ? [ attachment ] : [] );
         }
       });
       _this.file_frame.on('select', function() {
         var attachment = _this.file_frame.state().get('selection').first().toJSON();
         var id = attachment.id;
         var url = attachment.url;
         $('#local-avatar img').attr('src', url);
         $('#upload-avatar').val(id).attr({
           'type': 'hidden',
           'name': 'qqworld-speed-4-china[local-avatar]'
         });
         $('#using-default-avatar').slideDown('normal');
       });
       _this.file_frame.open();
     }).on('click', '#using-default-avatar', function() {
       $('#upload-avatar').val('');
       $('#local-avatar img').attr('src', $('#local-avatar img').attr('default-avatar'));
       $(this).slideUp('normal');
     });

     $(document).on('click', '#qqworld-speed-4-china-tabs li', function() {
       if (!$(this).hasClass('current')) {
         var index = $('#qqworld-speed-4-china-tabs li').index(this);
         $('#qqworld-speed-4-china-tabs li').removeClass('current');
         $(this).addClass('current');
         $('.tab-content').hide().eq(index).fadeIn('normal');
       }
       return false;
     });
   }
   wpqs4c.speed4china();

})( jQuery );
