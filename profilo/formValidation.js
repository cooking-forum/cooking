function validaForm() {
    
    var con=/^([a-zA-Z]\s?)+$/;
    if((document.myForm.inputName.value=="") || !(con.test(document.myForm.inputName.value))){
        window.alert("Inserire nome valido");
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
    if(document.myForm.remember.checked){
        window.alert("Hai scelto di ricordarti per i prossimi accessi" );
    }
    else{
        window.alert("Hai scelto di non ricordarti per i prossimi accessi" );
    }


}


function validator() {
    var x = 0;
    var password = document.getElementById('txt').value;
    var bar = document.getElementById("bar");
    var al = document.getElementById("alert");
  
    //controllo numeri
    var check=/[0-9]/;
    if(check.test(password)){
      x = x + 40;
    }
    //controllo minuscole
    var check2=/[a-z]/;
    if(check2.test(password)){
      x = x + 20;
    }
    //controllo maiuscole
    var check3=/[A-Z]/;
    if(check3.test(password)){
      x = x + 20;
    }
    //controllo simboli
    var check4=/^[\_\*\-\+\!\?\,\:\;\.]{6,12}/;
    if(check4.test(password)){
      x = x + 40;
    }
    // controllo lunghezza (minore o uguale a 10 caratteri)
    if(password.length >=10){
      x = x + 40;
    }
  
    // risultato
    bar.style.width = x + "%";
    // voto massimo 100
    if(x==100){
        bar.style.backgroundColor = "green";
        al.innerHTML = "Password molto sicura";
    }
    if (x >60) {
      bar.style.backgroundColor = "green";
      al.innerHTML = "Password sicura";
    }
    if (x <=40) {
      bar.style.backgroundColor = "yellow";
      al.innerHTML = "Buona, puoi ancora migliorarla";
    }
    //voto minimo 20
    if (x <=20) {
      bar.style.backgroundColor = "red";
      al.innerHTML = "Scegli una password più sicura";
    }
  
    if(password.length == 0){
      x == 0;
      al.innerHTML = "";
    }
  
    //controllo spazi bianchi
    var check5=/\s\S/;
    if(check5.test(password)){
      al.innerHTML = "Password must not contain white spaces";
      bar.style.backgroundColor = "red";
    }
  }


  
  
 