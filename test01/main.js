
function add_to_cart(name,price) {
    // alert("11");
    //alert(name+" "+price);
    //writeFile("cart.txt",name);
    // writeFile("cart.txt",price);
    alert("add the "+name+" to the cart! ");
}

function show_cart()
{
    var s=readFile("cart.txt");
    for(var i;i<s.length;i++)
        alert(s[i]);

}

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function getAllUrlParams(url) {

    // 从url(可选)或window对象获取查询字符串
    var queryString = url ? url.split('?')[1] : window.location.search.slice(1);

    // 我们把参数保存在这里
    var obj = {};

    // 如果查询字符串存在
    if (queryString) {

        // 查询字符串不包含#后面的部分，因此去掉它
        queryString = queryString.split('#')[0];

        // 把查询字符串分割成各部分
        var arr = queryString.split('&');

        for (var i=0; i<arr.length; i++) {
            // 分离出key和value
            var a = arr[i].split('=');

            // 考虑到这样的参数：list[]=thing1&list[]=thing2
            var paramNum = undefined;
            var paramName = a[0].replace(/\[\d*\]/, function(v) {
                paramNum = v.slice(1,-1);
                return '';
            });

            // 设置参数值（如果为空则设置为true）
            var paramValue = typeof(a[1])==='undefined' ? true : a[1];

            // （可选）保持大小写一致
            paramName = paramName.toLowerCase();
            paramValue = paramValue.toLowerCase();

            // 如果参数名已经存在
            if (obj[paramName]) {
                // 将值转成数组（如果还是字符串）
                if (typeof obj[paramName] === 'string') {
                    obj[paramName] = [obj[paramName]];
                }
                // 如果没有指定数组索引
                if (typeof paramNum === 'undefined') {
                    // 将值放到数组的末尾
                    obj[paramName].push(paramValue);
                }
                // 如果指定了数组索引
                else {
                    // 将值放在索引位置
                    obj[paramName][paramNum] = paramValue;
                }
            }
            // 如果参数名不存在则设置它
            else {
                obj[paramName] = paramValue;
            }
        }
    }

    return obj;
}

function getQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
    var result = window.location.search.substr(1).match(reg);
    if (result!=null) {
        return result[2];
    } else {
        return null;
    };
}

function show_product_page(){
    alert("shit");
    var page2=document.getElementById("product_table_main");

    //page2.setAttribute("visibility","visible");
    page2.setAttribute("border","1px");
    var img_show_linke=getQueryString("img_link_qury");//alert(img_show_linke);
    var show_name=getParameterByName("name_qury");//alert(show_name);
    var show_price=getParameterByName("price_qury");
    var show_description=getParameterByName("Description");



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