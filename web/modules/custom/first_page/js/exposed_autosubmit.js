(function ($, Drupal, once) {
  Drupal.behaviors.manualAutosubmit = {
    attach: function (context) {
      const elements = once('manual-autosubmit', '.views-exposed-form', context);

      $(elements).each(function () {
        const $form = $(this);

        $form.find('select').on('change', function () {
          const $submit = $form.find('.form-submit');
          if ($submit.length) {
            $submit.click();
          }
        });
      });
    }
  };
})(jQuery, Drupal, once);
