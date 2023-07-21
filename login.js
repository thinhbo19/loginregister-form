const wrapper = document.querySelector(".wrapper");
const loginLink = document.querySelector(".login-link");
const registerLink = document.querySelector(".register-link");
const iconClose = document.querySelector(".icon-close");
const btnLoginPopup = document.querySelector(".btnLogin-popup");
const aForgot = document.querySelector('.forgot-pass');
const Back = document.querySelector('.login-link-back');

registerLink.addEventListener("click", () => {
  wrapper.classList.add("active");
});
loginLink.addEventListener("click", () => {
  wrapper.classList.remove("active");
});

iconClose.addEventListener("click", () => {
  wrapper.classList.add("active-close");
});
btnLoginPopup.addEventListener("click", () => {
  wrapper.classList.remove("active-close");
});


aForgot.addEventListener("click", () => {
  wrapper.classList.add("active-forgot");
});
Back.addEventListener("click", () => {
  wrapper.classList.remove("active-forgot");
});