/**
 * @file tooltip_textfield.js
 */

(function ($, Drupal, window, document) {

  'use strict';

  /**
   * Attaches tooltip_textfield behaviors.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches event listeners for webform dialogs.
   */
  Drupal.behaviors.tooltipTextfield = {
    attach: function () {
      $(window).once('tooltip-textfield--initialized').each(function () {
        // Apply a qTip2 tooltip event listener.
        $('.js-tooltip-textfield').children().qtip({
          content: {
            text: 'Learn more at Drupal.org!'
          }
        });
      });
    }
  }

})(jQuery, Drupal, window, window.document);
