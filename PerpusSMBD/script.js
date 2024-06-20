// const adminButton = document.getElementById("admin");
// const memberButton = document.getElementById("member");
// const loginButton = document.getElementById("login");
// const container1 = document.getElementById("container1");
// const container2 = document.getElementById("container2");

// adminButton.addEventListener("click", () => {
//   container1.classList.add("right-panel-active");
// });

// memberButton.addEventListener("click", () => {
//   container2.classList.add("right-panel-active");
// });

// loginButton.addEventListener("click", () => {
//   container1.classList.remove("right-panel-active");
// });

const formAdmin = document.getElementById('form-admin');
const formMember = document.getElementById('form-member');
const adminButton = document.getElementById('adminButton');
const memberButton = document.getElementById('memberButton');
const container = document.getElementById('container')
const back1Button = document.getElementById("back1");
const back2Button = document.getElementById("back2");
const adminOverlay = document.getElementById('admin-overlay');
const memberOverlay = document.getElementById('member-overlay');

adminButton.addEventListener('click', () => {
  formAdmin.style.display = 'block';
  formMember.style.display = 'none';
  container.classList.add("right-panel-active");
  adminOverlay.style.display = 'block';
  memberOverlay.style.display = 'none';
});

memberButton.addEventListener('click', () => {
  formAdmin.style.display = 'none';
  formMember.style.display = 'block';
  container.classList.add("right-panel-active");
  adminOverlay.style.display = 'none';
  memberOverlay.style.display = 'block';
});

back1Button.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

back2Button.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});