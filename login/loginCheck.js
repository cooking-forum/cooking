function checkLogin() {
    if (document.myLogin.inputEmail.value == "") {
        alert("Inserire email!");
    }

    if (document.myLogin.inputPassword.value == "") {
        alert("Inserire password!");
    }

    else return false;
}