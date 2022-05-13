// var counter = substr_count($html,'<td>')/4;

function checkRicetta() {
    if (document.myRicetta.nomeRicetta.value == "") {
        alert("Inserire nome ricetta!");
    }

    if (document.myRicetta.nomeAutore.value == "") {
        alert("Inserire nome autore!");
    }

    if (document.myRicetta.ingrediente1.value == "") {
        alert("Inserire nome ingrediente!");
    }

    if (document.myRicetta.numero1.value == "") {
        alert("Inserire quantità ingrediente!");
    }

    if (document.myRicetta.unita1.value == "") {
        alert("Inserire unità ingrediente!");
    }

    if (document.myRicetta.procedimento.value == "") {
        alert("Inserire descrizione del procedimento!");
    }

    else return false;
}
