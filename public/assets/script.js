// Kita bungkus semua kode di sini biar dia jalan setelah semua elemen HTML siap
document.addEventListener('DOMContentLoaded', function () {

  // Ambil dulu elemen-elemen pentingnya
  const navBar = document.querySelector('.navbar');
  const navToggler = document.querySelector('.navbar-toggler');
  const navCollapse = document.querySelector('.navbar-collapse'); // Target collapse-nya

  // Kalo salah satu elemen gak ada, stop eksekusi biar gak error
  if (!navBar || !navToggler || !navCollapse) {
    return;
  }

  // Kita pasang 'kuping' buat dengerin semua klik di dokumen
  document.addEventListener('click', function (event) {
    
    // Cek dulu, menunya lagi kebuka gak? (Bootstrap nambahin class 'show' pas menu kebuka)
    const isMenuOpen = navCollapse.classList.contains('show');

    // Kalo menunya lagi kebuka...
    if (isMenuOpen) {
      // Cek apakah yang diklik itu ada di DALAM navbar atau TIDAK
      const isClickInsideNavbar = navBar.contains(event.target);

      // Kalo diklik di LUAR navbar...
      if (!isClickInsideNavbar) {
        // Kita 'klik' aja tombol hamburgernya secara paksa biar dia nutup sendiri.
        // Ini cara paling aman biar animasi tutupnya tetep jalan sesuai standar Bootstrap.
        navToggler.click();
      }
    }
  });
});// Kita bungkus semua kode di sini biar dia jalan setelah semua elemen HTML siap
document.addEventListener('DOMContentLoaded', function () {

  // Ambil dulu elemen-elemen pentingnya
  const navBar = document.querySelector('.navbar');
  const navToggler = document.querySelector('.navbar-toggler');
  const navCollapse = document.querySelector('.navbar-collapse'); // Target collapse-nya

  // Kalo salah satu elemen gak ada, stop eksekusi biar gak error
  if (!navBar || !navToggler || !navCollapse) {
    return;
  }

  // Kita pasang 'kuping' buat dengerin semua klik di dokumen
  document.addEventListener('click', function (event) {
    
    // Cek dulu, menunya lagi kebuka gak? (Bootstrap nambahin class 'show' pas menu kebuka)
    const isMenuOpen = navCollapse.classList.contains('show');

    // Kalo menunya lagi kebuka...
    if (isMenuOpen) {
      // Cek apakah yang diklik itu ada di DALAM navbar atau TIDAK
      const isClickInsideNavbar = navBar.contains(event.target);

      // Kalo diklik di LUAR navbar...
      if (!isClickInsideNavbar) {
        // Kita 'klik' aja tombol hamburgernya secara paksa biar dia nutup sendiri.
        // Ini cara paling aman biar animasi tutupnya tetep jalan sesuai standar Bootstrap.
        navToggler.click();
      }
    }
  });
});