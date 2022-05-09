function validaForm() {
    if(document.myForm.remember.checked){
        window.alert("Hai scelto di ricordarti per i prossimi accessi" );
    }
    else{
        window.alert("Hai scelto di non ricordarti per i prossimi accessi" );
    }
    if(document.myForm.inputName.value==""){
        alert("Inserire nome");
        return false;
    }
    if(document.myForm.inputEmail.value==""){
        alert("Inserire email");
        return false;
    }
    if(document.myForm.inputPassword.value==""){
        alert("Inserire password");
        return false;
    }


}