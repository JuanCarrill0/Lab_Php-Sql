// Buttons
const formSesion = document.getElementById("formSesion")
const formRegister = document.getElementById("formRegister")
const ButtonRegister = document.getElementById("button-register")
const register = document.getElementById("register")

//Identification Data //

const userName = document.getElementById("userName")
const userNameRegister = document.getElementById("userNameRegister")
const password = document.getElementById("password")
const passwordRegister = document.getElementById("passwordRegister")
const confirmPassword = document.getElementById("confirmPassword")
const email = document.getElementById("email")
const login = document.getElementById("login")

//PHP


ButtonRegister.addEventListener("click", (e) => {
  document.getElementById("topBox").innerHTML =
    "<p><span class='text-White'> Create your account- </span> <span class='text-Green'>Taking care of your economy starts now</span> </p> "
  document.getElementById("form-sesion").style.display = "none"
  document.getElementById("form-register").style.display = "initial"
})



login.addEventListener("click", (e) => {
  e.preventDefault()
   let Sesion = '<?= $Sesion?>';
   alert(Sesion);
})

register.addEventListener("click", (e) => {
  e.preventDefault()
  if (
    userNameRegister.value == "" ||
    email.value == "" ||
    passwordRegister.value == ""
  ) {
    Swal.fire({
      icon: "warning",
      title: "Pay attention...",
      text: "No box in the registry should be empty",
    })
  } else {
    if (passwordRegister.value != confirmPassword.value) {
      Swal.fire({
        icon: "warning",
        title: "Pay attention...",
        text: "The passwords are not the same",
      })
    } else {
      if (ValidateEmail()) {
        formRegister.submit()
      }
    }
  }
})

function ValidateEmail() {
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
    return true
  }
  Swal.fire({
    icon: "warning",
    title: "Pay attention...",
    text: "You have entered an invalid email address!",
  })
  return false
}