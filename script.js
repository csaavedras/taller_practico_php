const registerArea = document.querySelector(".insertar_registro");
const btnShow = document.querySelector(".button_show");
const btnHidden = document.querySelector(".button_hidden");
const title = document.querySelector(".title");
const form = document.getElementById("userForm");


console.log(registerArea)
console.log(btnShow)
console.log(btnHidden)

const showRegisterArea = () => {
    registerArea.classList.remove("d-none")
    registerArea.style.display = "block"
    btnShow.classList.add("d-none")
}

const hiddenRegisterArea = () => {
    registerArea.style.display = "none"
    btnShow.classList.remove("d-none")
    form.reset()

}

btnShow.addEventListener("click", showRegisterArea);
btnHidden.addEventListener("click", hiddenRegisterArea);


