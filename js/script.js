/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {

// This toggles the menu checkboxes which are used in the mobile display/layout
Drupal.behaviors.mobileMenuVisibility = {
  attach: function (context, settings) {
    var allMenuCheckBoxes = $('.menus input[type="checkbox"]');
    allMenuCheckBoxes.change(function(){
      console.log('checkbox', this);
      if($(this).is(':checked')) {
        $(allMenuCheckBoxes).attr('checked', false);
        $(this).attr('checked', true);
      }
    });
  },
  detach: function (context, settings) { }
};


// This modifies the text format display to help prevent data loss when
// switching between text formats
Drupal.behaviors.textFormatHack = {
  attach: function (context, settings) {
    $(".filter-guidelines .tips").addClass('bobo');
  },
  detach: function (context, settings) { }
};

})(jQuery, Drupal, this, this.document);
