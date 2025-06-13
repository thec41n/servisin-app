const adminWrapper = document.querySelector(".admin-wrapper");
const sidebar = document.querySelector(".sidebar");
const toggleBtn = document.querySelector("#sidebar-toggle-btn");
const closeBtn = document.querySelector("#sidebar-close-btn");
const overlay = document.querySelector("#page-overlay");

const openSidebar = () => {
  adminWrapper.classList.add("sidebar-open");
  if (window.innerWidth <= 991) {
    overlay.classList.add("active");
  }
};

const closeSidebar = () => {
  adminWrapper.classList.remove("sidebar-open");
  overlay.classList.remove("active");
};

toggleBtn.addEventListener("click", () => {
  if (adminWrapper.classList.contains("sidebar-open")) {
    closeSidebar();
  } else {
    openSidebar();
  }
});

closeBtn.addEventListener("click", closeSidebar);
overlay.addEventListener("click", closeSidebar);
