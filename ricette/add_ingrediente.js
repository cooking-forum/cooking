

var counter = 1;

function addIngrediente(){
    // Find a <table> element with id="myTable":
    var table = document.getElementById("ingr_table");
    
    counter ++;

    // Create an empty <tr> element and add it to the 1st position of the table:
    var row = table.insertRow(0);

    // Insert new cells (<td> elements) at the 1st and 2nd position of the "new" <tr> element:
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    // Add some text to the new cells:
    cell1.innerHTML = "<input type='text' class='label-ingr' id='i"+counter+"' name='ingrediente"+counter+"' placeholder='Ingrediente n° "+counter+"' required>";
    cell2.innerHTML = "<input type='number' class='num' id='n"+counter+"' name='numero"+counter+"' step='0.5' placeholder='Quantità' required>";
    cell3.innerHTML = "<select class='unita' id='unita"+counter+"' name='unita'><option value='gr'>gr</option><option value='kg'>kg</option><option value='l'>l</option><option value='ml'>ml</option></select>";
    cell4.innerHTML = "<input class='btn-ingr' type='button' value='Rimuovi ingrediente' onclick=deleteIngrediente('counter')>";
}

function deleteIngrediente(counter) {
    var table = document.getElementById("ingr_table");
    var row = table.deleteRow(counter);  
    counter --;
}


/*
function addIngrediente(){
    $rowno=$("#ingr_table tr").length;
    $rowno=$rowno+1;
    $("#ingr_table tr:last").after("<tr id='row"+$rowno+"'><td><input type='text' class='label-ingr' id='i"+$rowno+"' name='ingrediente"+$rowno+"' placeholder='Ingrediente n° "+$rowno+"' required></td><td><input type='number' class='num' id='i"+$rowno+"' name='numero"+$rowno+"' step='0.5' placeholder='Quantità' required></td><td><select class='unita' id='unita"+$rowno+"' name='unita'><option value='gr'>gr</option><option value='kg'>kg</option><option value='l'>l</option><option value='ml'>ml</option></select></td><td><input type='button' value='DELETE' onclick=delete_row('row"+$rowno+"')></td></tr>"); 
}

function remove_field(rowno) {
    $('#i'+rowno).remove();
}
*/

/*
var counter = 0;

function addIngrediente() {
    var total_text=document.getElementsByClassName("input_text");
    total_text=total_text.length+1;
    counter++;
    document.getElementById("field_div").innerHTML=document.getElementById("field_div").innerHTML+
    "<input type='text' class='label-ingr' id='i"+counter+"' name='ingrediente"+counter+"' placeholder='Ingrediente n° "+counter+"' required/>\
    <input type='number' class='num' id='i"+counter+"' name='numero"+counter+"' step='0.5' placeholder='  Quantità' required/>\
    <select class='unita' id='unita"+counter+"' name='unita'/>\
    <option value='gr'>gr</option>\
    <option value='kg'>kg</option>\
    <option value='l'>l</option>\
    <option value='ml'>ml</option>\
    </select>\
    <input type='button' value='Remove' onclick=remove_field('input_text"+total_text+"');><br>";
}

function remove_field(id) {
  document.getElementById(id+"_wrapper").innerHTML="";
  counter--;
}
*/



/*
function addIngrediente() {
    document.querySelector('.formIngr');
}



var counter = 2;

function addIngrediente() {
    counter +=1;
    var html='<input type="text" id="i'+ counter +'" name="ingrediente'+ counter +'" class="label-ingr" placeholder="Ingrediente n° '+ counter +'" required />\
          <input type="number" id="n'+ counter +'" name="numero'+ counter +'" class="num" step="0,5" placeholder="Quantità" required/>\
          <select name="unita" id="unita'+ counter +'" class="unita">\
            <option value="gr">gr</option>\
            <option value="kg">kg</option>\
            <option value="l">l</option>\
            <option value="ml">ml</option>\
           </select>\
           <br>';

       var form = document.getElementById('formIngr');
       form.innerHTML += html;
}
*/

/*
function addIngrediente() {
    // creazione elemento div
	var txtNewInputBox = document.createElement('div');

    // aggiungere una nuova input box all'elemento
	txtNewInputBox.innerHTML = "<input type='text' id='i3' name='ingrediente3' class='label-ingr' placeholder='Ingrediente n° 3' required>";
    txtNewInputBox.innerHTML = "<input type='number' id='n3' name='numero3' class='num' step='0,5' placeholder='Quantità' required>";
    txtNewInputBox.innerHTML = "<select name='unita' id='unita3' class='unita'>";
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
            $(wrapper).append('<input type="text" id="i3" name="ingrediente3" class="label-ingr" placeholder="Ingrediente n° 3" required><input type="number" id="n3" name="numero3" class="num" step="0,5" placeholder="Quantità" required><select name="unita3" id="unita" class="unita"><option value="gr">gr</option><option value="kg">kg</option><option value="l">l</option><option value="ml">ml</option></select>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').parent('div').remove(); x--;
        })
    });
    */