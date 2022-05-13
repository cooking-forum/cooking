

var counter = 1;

function addIngrediente(){
    // Find a <table> element with id="myTable":
    var table = document.getElementById("ingr-table");
    
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
    cell3.innerHTML = "<select class='unita' id='u"+counter+"' name='unita"+counter+"'><option value='gr'>gr</option><option value='kg'>kg</option><option value='l'>l</option><option value='ml'>ml</option></select>";
    cell4.innerHTML = "<input class='btn-ingr' type='button' value='Rimuovi ingrediente' onclick=deleteIngrediente('counter')>";
}

function deleteIngrediente(counter) {
    var table = document.getElementById("ingr-table");
    var row = table.deleteRow(counter);  
    counter --;
}