function add_to_cart(prod_id) {

    prod_id=prod_id.toString();
    if(localStorage.getItem("shopList"))
    {
        var text=localStorage.getItem("shopList");
        var obj=JSON.parse(text);
        if(obj[prod_id])
            obj[prod_id]++;
        else
            obj[prod_id]=1;

        var myJson=JSON.stringify(obj);
        localStorage.setItem("shopList",myJson);
    }

show_shop_list();
   // alert("end add");
}

function set_quant(str,str2) {
    var text=localStorage.getItem("shopList");
    var obj=JSON.parse(text);
    //alert(str+" "+str2);
    obj[str]=parseInt(str2);
    var myJson=JSON.stringify(obj);
    localStorage.setItem("shopList",myJson);
}

function deleteFromCart(str) {
    var text=localStorage.getItem("shopList");
    var obj=JSON.parse(text);
    delete obj[str];
    var myJson=JSON.stringify(obj);
    localStorage.setItem("shopList",myJson);
    show_shop_list();
}

function show_shop_list() {
    document.getElementById("host_shopList").innerHTML="";
    var text=localStorage.getItem("shopList");
   var myObj=JSON.parse(text);
   var i=0;
   var quant=[];

   for(x in myObj)
       quant.push(myObj[x]);/*
   for(var j=0;j<quant.length;j++)
       alert(quant[j]);*/
   for(ir in myObj) {

       var total=parseFloat(document.getElementById("money").value);
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var name_price=JSON.parse(this.responseText);
               var temp_id=Object.keys(name_price)[0];
               the_li="<li>"+Object.keys(name_price)[1]+" $"+Object.values(name_price)[1]+"<input type='text' size='3' onkeyup='set_quant("+temp_id+",this.value)' value='"+Object.values(name_price)[0]+"' maxlength='3' pattern='^(0|([1-9]\\d{0,2}))$'/>"+"<br/>"+"<input type='button' value='Delete' onclick='deleteFromCart("+temp_id+")'>"+"</li>";
               total+=(parseInt(Object.values(name_price)[1])*parseInt(Object.values(name_price)[0]));
               document.getElementById("host_shopList").innerHTML+=(the_li);
               document.getElementById("money").value=total.toString();
               document.getElementById("total_price").innerHTML="<li>"+"Total: $"+total+"</li>";
           }
       };
       var kki=ir;
       xmlhttp.open("GET", "getNamePrice.php?q=" + kki+"&qnt="+quant[i], true);
       xmlhttp.send();

       i++;
   }

/*
   for( kk in myObji)
   {   alert(kk);
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function() {
           if (this.readyState == 4 && this.status == 200) {
               var name_price=JSON.parse(this.responseText);

               the_li="<li>"+Object.keys(name_price)[0]+" "+Object.values(name_price)[0]+"<input type='text' size='3' value='"+myObji[kk]+"' maxlength='3' pattern='^(0|([1-9]\\d{0,2}))$'/>"+"</li>";
               document.getElementById("host_shopList").innerHTML+=(the_li);
           }

       };
       var kki=kk;
       xmlhttp.open("GET", "getNamePrice.php?q=" + kki, true);
       xmlhttp.send();


   }*/
}

function upload_page() {
    if(!localStorage.getItem("shopList"))
    {
        var myobj = {};
        var myJson = JSON.stringify(myobj);
        localStorage.setItem("shopList", myJson);
    }
    show_shop_list();
}