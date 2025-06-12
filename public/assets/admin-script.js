const adminWrapper = document.querySelector(".admin-wrapper");
const sidebar = document.querySelector(".sidebar");
const toggleBtn = document.querySelector("#sidebar-toggle-btn");
const closeBtn = document.querySelector("#sidebar-close-btn");
const overlay = document.querySelector("#page-overlay");

// Fungsi buat buka sidebar
const openSidebar = () => {
  adminWrapper.classList.add("sidebar-open");
  // Hanya aktifkan overlay di mode mobile
  if (window.innerWidth <= 991) {
    overlay.classList.add("active");
  }
};

// Fungsi buat nutup sidebar
const closeSidebar = () => {
  adminWrapper.classList.remove("sidebar-open");
  overlay.classList.remove("active");
};

toggleBtn.addEventListener("click", () => {
  // Cek kalo sidebar sudah kebuka, maka tutup. Kalo ketutup, maka buka.
  if (adminWrapper.classList.contains("sidebar-open")) {
    closeSidebar();
  } else {
    openSidebar();
  }
});

closeBtn.addEventListener("click", closeSidebar);
overlay.addEventListener("click", closeSidebar);
