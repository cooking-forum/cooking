function func(event){
    event.preventDefault();
    console.log("not refreshed");
}

var count=1;

function setColor(but,color){
    var pro=document.getElementById(but);
    if(count==0){
        pro.style.backgroundColor="#f89c39";
        count=1;
    }else{
        pro.style.backgroundColor="red";
        count=0;
    }
}