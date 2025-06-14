document.addEventListener('DOMContentLoaded', function () {

  const navBar = document.querySelector('.navbar');
  const navToggler = document.querySelector('.navbar-toggler');
  const navCollapse = document.querySelector('.navbar-collapse');

  if (!navBar || !navToggler || !navCollapse) {
    return;
  }

  document.addEventListener('click', function (event) {
    
    const isMenuOpen = navCollapse.classList.contains('show');

    if (isMenuOpen) {
      const isClickInsideNavbar = navBar.contains(event.target);

      if (!isClickInsideNavbar) {
        navToggler.click();
      }
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {

  const navBar = document.querySelector('.navbar');
  const navToggler = document.querySelector('.navbar-toggler');
  const navCollapse = document.querySelector('.navbar-collapse');

  if (!navBar || !navToggler || !navCollapse) {
    return;
  }

  document.addEventListener('click', function (event) {
    
    const isMenuOpen = navCollapse.classList.contains('show');

    if (isMenuOpen) {
      const isClickInsideNavbar = navBar.contains(event.target);

      if (!isClickInsideNavbar) {
        navToggler.click();
      }
    }
  });
});