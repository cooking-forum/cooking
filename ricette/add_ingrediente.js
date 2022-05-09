/*
function addIngrediente() {
    document.querySelector('.formIngr');
}
*/


var counter = 2;

function addIngrediente() {
    counter +=1;
    var html='<input type="text" id="i'+ counter +'" name="ingrediente'+ counter +'" class="label-ingr" placeholder="Ingrediente n° '+ counter +'" required />\
          <input type="number" id="n'+ counter +'" name="ingrediente'+ counter +'" class="num" step="0,5" placeholder="Quantità" required/>\
          <select name="unita" id="unita" class="unita">\
            <option value="gr">gr</option>\
            <option value="kg">kg</option>\
            <option value="l">l</option>\
            <option value="ml">ml</option>\
           </select>\
           <br>';

       var form = document.getElementById('formIngr');
       form.innerHTML += html;
}


/*
function addIngrediente() {
    // creazione elemento div
	var txtNewInputBox = document.createElement('div');

    // aggiungere una nuova input box all'elemento
	txtNewInputBox.innerHTML = "<input type='text' id='i3' name='ingrediente3' class='label-ingr' placeholder='Ingrediente n° 3' required>";
    txtNewInputBox.innerHTML = "<input type='number' id='n3' name='ingrediente3' class='num' step='0,5' placeholder='Quantità' required>";
    txtNewInputBox.innerHTML = "<select name='unita' id='unita' class='unita'>";
    txtNewInputBox.innerHTML = "<option id='gr' value='gr'>gr</option>";
    txtNewInputBox.innerHTML = "<option id='kg' value='kg'>kg</option>";
    txtNewInputBox.innerHTML = "<option id='l' value='l'>l</option>";
    txtNewInputBox.innerHTML = "<option id='ml' value='ml'>ml</option>";
    txtNewInputBox.innerHTML = "</select>";

    // posizionarla dove dave comparire
	document.getElementById("i3").appendChild(txtNewInputBox);
    document.getElementById("n3").appendChild(txtNewInputBox);
    document.getElementById("unita").appendChild(txtNewInputBox);
    document.getElementById("gr").appendChild(txtNewInputBox);
    document.getElementById("kg").appendChild(txtNewInputBox);
    document.getElementById("l").appendChild(txtNewInputBox);
    document.getElementById("ml").appendChild(txtNewInputBox);
}

$(document).ready(function() {
    var max_fields      = 50; //maximum input boxes allowed
    var wrapper   		= $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".btn-ingr"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
    e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<input type="text" id="i3" name="ingrediente3" class="label-ingr" placeholder="Ingrediente n° 3" required><input type="number" id="n3" name="numero3" class="num" step="0,5" placeholder="Quantità" required><select name="unita" id="unita" class="unita"><option value="gr">gr</option><option value="kg">kg</option><option value="l">l</option><option value="ml">ml</option></select>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
        })
    });
    */