function checkRicetta() {
    if (document.myRicetta.inputEmail.value == "") {
        window.alert("Inserire email!");
    }

    if (document.myRicetta.inputPassword.value == "") {
        window.alert("Inserire password!");
    }

    else return false;
}