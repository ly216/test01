new_element=document.createElement("script");
new_element.setAttribute("type","text/javascript");
new_element.setAttribute("src","ajax.js");// 在这里引入了a.js
document.body.appendChild(new_element);

function FillTable () {
    var xmlDoc=connect_to_product_list_xml();

    var catagory_index=getParameterByName("catalog");//alert(catagory_index);
    //var switcher=getAllUrlParams().img_link_qury;
    //if(!(switcher==="undefined")) show_product_page();
    if(catagory_index==null) catagory_index="Snack";  // set the default home page
    else
    {
        var a2=document.createElement("a");
        a2.setAttribute("href","Shop_host.html?catalog="+catagory_index);//alert("343");
        var text2=document.createTextNode(" >> "+catagory_index);
        a2.appendChild(text2);
        var pi=document.getElementById("path");//alert("66");
        var tri=document.createElement("td");
        tri.appendChild(a2);//alert(pi[0].nodeName);
        pi.childNodes[0].appendChild(tri);
        //pi.appendChild(a2);
    }
    var y=xmlDoc.getElementsByTagName("Root");
    var yy=y[0].childNodes;
    //alert(yy[1].nodeName);
    var target_catagory=yy[0];
    for(i=0;i<2*(yy.length);i++)
    {
        if(yy[i].nodeName==catagory_index)
        {/*alert("bingo "+yy[i].childNodes.length);*/
            target_catagory=yy[i];
            break;
        }
    }
    /*var test_text=document.getElementById("path");
    var tmep_test=document.createTextNode(window_size);
    test_text.appendChild(tmep_test);*/
    var product_items=target_catagory.getElementsByTagName("BD");
    //alert(" "+product_items.length);
    var cols=getHomeProductTableCols();//alert(""+cols);
    var product_item_width=getHomeProductUnitWidth();
    var Product_table=document.getElementById("product_table");//alert("table");
    Product_table.setAttribute("border","1px");
    var col_counter=0;
    var item_counter=0;
    var xx=0;
    while(item_counter<product_items.length)
    {  //alert(Math.ceil(product_items.length/cols));
        xx=xx+1;
        var out_tr=document.createElement("tr");
        out_tr.setAttribute("height","200");
        out_tr.setAttribute("width","95%");
        out_tr.setAttribute("border","1px");
        var inner_img_link="";
        var inner_product_name="";
        var inner_product_price="";
        var inner_product_description="";
        //alert("out table");
        while(col_counter<cols) {//alert("go to seconary loop");
            var out_td=document.createElement("td");
            out_td.setAttribute("height","100%");
            out_td.setAttribute("width","250");//alert("xml info. transform start.");
            out_td.setAttribute("border","1px")
            inner_img_link = product_items[item_counter].getElementsByTagName("Image_link")[0].childNodes[0].nodeValue;
            inner_product_name = product_items[item_counter].getElementsByTagName("Name")[0].childNodes[0].nodeValue;
            inner_product_price = product_items[item_counter].getElementsByTagName("Price")[0].childNodes[0].nodeValue;
            inner_product_description=product_items[item_counter].getElementsByTagName("Description")[0].childNodes[0].nodeValue;
//                   alert(inner_product_name);
            if(!inner_img_link){Product_table.appendChild(out_tr);break;}
            var iner_img = document.createElement("img");
            iner_img.setAttribute("width", "80%");
            iner_img.setAttribute("height", "80%");
            iner_img.setAttribute("src", inner_img_link);
            //setTimeout(show_product_page(),1000);
            //iner_img.setAttribute("onClick","show_product_page(''inner_img_link'',''inner_product_name'',''inner_product_price'',''inner_product_description'')");
            var home_img_a=document.createElement("a");
            home_img_a.setAttribute("href","Shop_product.html?img_link_qury="+inner_img_link+"&name_qury="+inner_product_name+"&price_qury="+inner_product_price+"&Description="+inner_product_description+"&catagory_qury="+catagory_index);
            home_img_a.appendChild(iner_img);
            //alert("get xml info");
            var iner_img_td = document.createElement("td");
            iner_img_td.setAttribute("width","100%");
            iner_img_td.setAttribute("height","100%");
            iner_img_td.appendChild(home_img_a);
            var iner_img_tr=document.createElement("tr");
            iner_img_tr.setAttribute("width","100%");
            iner_img_tr.setAttribute("height","60%");
            iner_img_tr.appendChild(iner_img_td);   // alert("img inserted");
            var iner_name_td=document.createElement("td");
            iner_name_td.setAttribute("width","50%");
            iner_name_td.setAttribute("height","100%");//alert("name td");
            var iner_namei=document.createTextNode(inner_product_name);
            iner_name_td.appendChild(iner_namei);//alert("name inserted");
            var iner_name_tr=document.createElement("tr");
            iner_name_tr.setAttribute("width","100%");
            iner_name_tr.setAttribute("height","20%");
            var cart_button=document.createElement("input");
            cart_button.setAttribute("type","button");
            cart_button.setAttribute("value","add to cart");
            cart_button.setAttribute("style","background-color:#FFD4D4");//alert("hey");
//                    inner_product_name = "aa";
//                    x = "add_to_cart("+inner_product_name+")";
//                    alert(x)
            cart_button.setAttribute("onclick", "add_to_cart('"+inner_product_name+"','"+inner_product_price+"')");// alert("button");
//                   cart_button.addEventListener("click","add_to_cart(inner_product_name,inner_product_price)"); alert("button");


            var cart_button_td=document.createElement("td");
            cart_button_td.setAttribute("width","50%");
            cart_button_td.setAttribute("height","100%");
            cart_button_td.setAttribute("rowspan","2");//alert("table span");
            cart_button_td.appendChild(cart_button);
            iner_name_tr.appendChild(cart_button_td);
            iner_name_tr.appendChild(iner_name_td);  //alert("name inserted");
            var iner_price_td=document.createElement("td");
            iner_price_td.setAttribute("width","100%");
            iner_price_td.setAttribute("height","100%");
            var iner_price=document.createTextNode(inner_product_price);
            iner_price_td.appendChild(iner_price);//alert("price inserted");
            var iner_price_tr=document.createElement("tr");
            iner_price_tr.setAttribute("width","100%");
            iner_price_tr.setAttribute("height","20%");
            iner_price_tr.appendChild(iner_price_td);//alert("the price");
            var iner_table=document.createElement("table");
            iner_table.setAttribute("width","100%");
            iner_table.setAttribute("height","100%");
            iner_table.appendChild(iner_img_tr);
            iner_table.appendChild(iner_name_tr);
            iner_table.appendChild(iner_price_tr);
            out_td.appendChild(iner_table);
            out_tr.appendChild(out_td);
            col_counter=col_counter+1;
            item_counter=item_counter+1;
            //alert("unit complete");
            if(item_counter==product_items.length)
            {
                //col_counter=0;
                //item_counter=0;
                Product_table.appendChild(out_tr);
                //alert("!!");
                break;

            }

            //alert(""+item_counter);
        }
        col_counter=0;

        Product_table.appendChild(out_tr);
        //alert("continue");
        if(item_counter<product_items){continue;}

        if(item_counter>=product_items.length)
        {
            col_counter=0;
            item_counter=0;
            Product_table.appendChild(out_tr);//alert("item_conter: "+item_counter+" total: "+product_items.length);
            break;
        }

    }//alert("end loop");
}

function show_product_page(){
    var xmlDoc=connect_to_product_list_xml();
    var page2=document.getElementById("product_table_main");

    //page2.setAttribute("visibility","visible");
    page2.setAttribute("border","1px");
    var img_show_linke=getQueryString("img_link_qury");//alert(img_show_linke);
    var show_name=getParameterByName("name_qury");//alert(show_name);
    var show_price=getParameterByName("price_qury");
    var show_description=getParameterByName("Description");
    var show_catagory=getParameterByName("catagory_qury");
//alert("info");
    var a2=document.createElement("a");
    a2.setAttribute("href","Shop_host.html?catalog="+show_catagory);//alert("343");
    var text2=document.createTextNode(" >> "+show_catagory);
    a2.appendChild(text2);
    var pi=document.getElementById("path");//alert("66");
    var tri=document.createElement("td");
    tri.appendChild(a2);//alert(pi[0].nodeName);
    pi.childNodes[0].appendChild(tri);
    //pi.appendChild(a2);
    //alert("cata");

    var a3=document.createElement("a");
    a3.setAttribute("href","Shop_product.html?img_link_qury="+img_show_linke+"&name_qury="+show_name+"&price_qury="+show_price+"&Description="+show_description+"&catagory_qury="+show_catagory);//alert("343");
    var text3=document.createTextNode(" >> "+show_name);
    a3.appendChild(text3);
    //var pi=document.getElementById("path");alert("66");
    var tri2=document.createElement("td");
    tri2.appendChild(a3);//alert(pi[0].nodeName);
    pi.childNodes[0].appendChild(tri2);
    //pi.appendChild(a2);

    var upper_tr=document.createElement("tr");//alert("get the qury");
    upper_tr.setAttribute("height","300");
    upper_tr.setAttribute("width","100%");
    upper_tr.setAttribute("border","1px");
    var img_td=document.createElement("td");
    img_td.setAttribute("height","100%");
    img_td.setAttribute("width","50%");
    img_td.setAttribute("border","1px");
    var big_img=document.createElement("img");
    big_img.setAttribute("height","80%");
    big_img.setAttribute("width","70%");
    big_img.setAttribute("src",img_show_linke);
    img_td.appendChild(big_img); //alert("insert img");
    var price_name_td=document.createElement("td");
    price_name_td.setAttribute("height","80%");
    price_name_td.setAttribute("width","50%");
    price_name_td.setAttribute("text-align","center");
    price_name_td.setAttribute("front-size","8px");//alert("seting");
    price_name_td.setAttribute("border","1px");
    var price_name=document.createTextNode("Name: "+show_name+"\n "+"\n "+"Price: "+show_price);

    price_name_td.appendChild(price_name);//alert("name price");
    upper_tr.appendChild(img_td);
    upper_tr.appendChild(price_name_td);
    var lower_td=document.createElement("td");
    lower_td.setAttribute("height","100%");
    lower_td.setAttribute("width","100%");
    lower_td.setAttribute("text-align","left");
    lower_td.setAttribute("border","1px");
    var desprition1=document.createTextNode("Description: "+show_description);
    lower_td.appendChild(desprition1);

    var cart_button=document.createElement("input");
    cart_button.setAttribute("type","button");
    cart_button.setAttribute("value","add to cart");
    cart_button.setAttribute("style","background-color:#FFD4D4");
    cart_button.setAttribute("onclick","add_to_cart('"+show_name+"','"+show_price+"')"); //alert("button");
    var cart_button_td=document.createElement("td");
    cart_button_td.setAttribute("width","50%");
    cart_button_td.setAttribute("height","100%");
    //cart_button_td.setAttribute("rowspan","2");//alert("table span");
    cart_button_td.appendChild(cart_button);

    var lower_tr=document.createElement("tr");
    lower_tr.setAttribute("height","200");
    lower_tr.setAttribute("width","100%");
    lower_tr.setAttribute("border","1px");
    lower_tr.appendChild(lower_td);
    lower_tr.appendChild(cart_button_td);
    page2.appendChild(upper_tr);
    page2.appendChild(lower_tr);//alert("finish");

}