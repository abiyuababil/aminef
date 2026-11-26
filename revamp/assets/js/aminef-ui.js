/**
 * AMINEF UI Unified Alert & Interaction Helper
 * Standardizes all alerts and confirmations on SweetAlert2 (Swal.fire).
 * Replaces native alert(), confirm(), and legacy swal() v1 calls.
 */
(function (window, $) {
  'use strict';

  var baseClasses = {
    popup: 'aminef-swal-popup',
    title: 'aminef-swal-title',
    htmlContainer: 'aminef-swal-html',
    confirmButton: 'aminef-swal-confirm',
    cancelButton: 'aminef-swal-cancel'
  };

  var AminefUI = {
    /**
     * Standardized notification alert (success | error | warning | info)
     */
    alert: function (type, title, text, timerMs) {
      if (typeof Swal === 'undefined') {
        window.alert((title ? title + ': ' : '') + (text || ''));
        return Promise.resolve();
      }
      var confirmClass = 'aminef-swal-confirm';
      if (type === 'success') confirmClass += ' aminef-swal-confirm--success';
      if (type === 'error') confirmClass += ' aminef-swal-confirm--danger';

      return Swal.fire({
        icon: type || 'info',
        title: title || '',
        text: text || '',
        timer: timerMs || undefined,
        showConfirmButton: !timerMs,
        confirmButtonText: 'OK',
        buttonsStyling: false,
        customClass: {
          popup: baseClasses.popup,
          title: baseClasses.title,
          htmlContainer: baseClasses.htmlContainer,
          confirmButton: confirmClass
        }
      });
    },

    /**
     * Standardized confirmation dialog (replaces window.confirm)
     */
    confirm: function (options, onConfirm) {
      var opts = options || {};
      var isDanger = opts.danger !== false;

      if (typeof Swal === 'undefined') {
        if (window.confirm(opts.text || 'Are you sure?')) {
          if (typeof onConfirm === 'function') onConfirm();
        }
        return Promise.resolve();
      }

      return Swal.fire({
        icon: opts.icon || 'warning',
        title: opts.title || 'Confirm',
        text: opts.text || 'Are you sure you want to proceed?',
        showCancelButton: true,
        confirmButtonText: opts.confirmText || (isDanger ? 'Yes, Delete' : 'Yes'),
        cancelButtonText: opts.cancelText || 'Cancel',
        reverseButtons: true,
        buttonsStyling: false,
        customClass: {
          popup: baseClasses.popup,
          title: baseClasses.title,
          htmlContainer: baseClasses.htmlContainer,
          confirmButton: 'aminef-swal-confirm' + (isDanger ? ' aminef-swal-confirm--danger' : ''),
          cancelButton: baseClasses.cancelButton
        }
      }).then(function (result) {
        if (result.isConfirmed && typeof onConfirm === 'function') {
          onConfirm();
        }
        return result;
      });
    }
  };

  window.AminefUI = AminefUI;

  // Global delegation for .confirm-del links/buttons when jQuery is present
  if ($) {
    $(document).on('click', 'body.aminef-revamp .confirm-del', function (e) {
      e.preventDefault();
      var href = $(this).attr('href');
      var itemLabel = $(this).data('item') || 'this item';
      AminefUI.confirm({
        title: 'Confirm Delete',
        text: 'Are you sure you want to remove ' + itemLabel + '? This action cannot be undone.',
        confirmText: 'Yes, Delete',
        danger: true
      }, function () {
        if (href && href !== '#' && href !== 'javascript:;') {
          window.location.href = href;
        }
      });
    });
  }
})(window, window.jQuery);
