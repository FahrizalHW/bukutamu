(function () {
  'use strict';

  document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
    const input = document.getElementById(button.dataset.passwordToggle);
    if (!input) return;

    button.addEventListener('click', function () {
      const shouldShow = input.type === 'password';
      input.type = shouldShow ? 'text' : 'password';
      button.setAttribute('aria-pressed', String(shouldShow));

      const label = shouldShow
        ? button.getAttribute('aria-label').replace('Tampilkan', 'Sembunyikan')
        : button.getAttribute('aria-label').replace('Sembunyikan', 'Tampilkan');
      button.setAttribute('aria-label', label);
      button.setAttribute('title', label);

      const icon = button.querySelector('i');
      if (icon) {
        icon.classList.toggle('ti-eye', !shouldShow);
        icon.classList.toggle('ti-eye-off', shouldShow);
      }
    });
  });
})();
