function CreateHTTPRequestObject () {
    // although IE supports the XMLHttpRequest object, but it does not work on local files.
    var forceActiveX = (window.ActiveXObject && location.protocol === "file:");
    if (window.XMLHttpRequest && !forceActiveX) {
        return new XMLHttpRequest();
    }
    else {
        try {
            return new ActiveXObject("Microsoft.XMLHTTP");
        } catch(e) {}
    }
    alert ("Your browser doesn't support XML handling!");
    return null;
}

function CreateMSXMLDocumentObject () {
    if (typeof (ActiveXObject) != "undefined") {
        var progIDs = [
            "Msxml2.DOMDocument.6.0",
            "Msxml2.DOMDocument.5.0",
            "Msxml2.DOMDocument.4.0",
            "Msxml2.DOMDocument.3.0",
            "MSXML2.DOMDocument",
            "MSXML.DOMDocument"
        ];
        for (var i = 0; i < progIDs.length; i++) {
            try {
                return new ActiveXObject(progIDs[i]);
            } catch(e) {};
        }
    }
    return null;
}

function CreateXMLDocumentObject (rootName) {
    if (!rootName) {
        rootName = "";
    }
    var xmlDoc = CreateMSXMLDocumentObject ();
    if (xmlDoc) {
        if (rootName) {
            var rootNode = xmlDoc.createElement (rootName);
            xmlDoc.appendChild (rootNode);
        }
    }
    else {
        if (document.implementation.createDocument) {
            xmlDoc = document.implementation.createDocument ("", rootName, null);
        }
    }

    return xmlDoc;
}

function ParseHTTPResponse (httpRequest) {
    var xmlDoc = httpRequest.responseXML;

    // if responseXML is not valid, try to create the XML document from the responseText property
    if (!xmlDoc || !xmlDoc.documentElement) {
        if (window.DOMParser) {
            var parser = new DOMParser();
            try {
                xmlDoc = parser.parseFromString (httpRequest.responseText, "text/xml");
            } catch (e) {
                alert ("XML parsing error");
                return null;
            };
        }
        else {
            xmlDoc = CreateMSXMLDocumentObject ();
            if (!xmlDoc) {
                return null;
            }
            xmlDoc.loadXML (httpRequest.responseText);

        }
    }

    // if there was an error while parsing the XML document
    var errorMsg = null;
    if (xmlDoc.parseError && xmlDoc.parseError.errorCode != 0) {
        errorMsg = "XML Parsing Error: " + xmlDoc.parseError.reason
            + " at line " + xmlDoc.parseError.line
            + " at position " + xmlDoc.parseError.linepos;
    }
    else {
        if (xmlDoc.documentElement) {
            if (xmlDoc.documentElement.nodeName == "parsererror") {
                errorMsg = xmlDoc.documentElement.childNodes[0].nodeValue;
            }
        }
    }
    if (errorMsg) {
        alert (errorMsg);
        return null;
    }

    // ok, the XML document is valid
    return xmlDoc;
}

// returns whether the HTTP request was successful
function IsRequestSuccessful (httpRequest) {
    // IE: sometimes 1223 instead of 204
    var success = (httpRequest.status == 0 ||
        (httpRequest.status >= 200 && httpRequest.status < 300) ||
        httpRequest.status == 304 || httpRequest.status == 1223);

    return success;
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

function getHomeProductTableCols() {
   var tempweidth=document.body.clientWidth;
   if(tempweidth<400) return 1;
   else if(tempweidth<650) return 2;
   else if(tempweidth<900) return 3;
   else if(tempweidth<1150) return 4;
   else if(tempweidth<1400) return 5;
   else return 6;
}

function getHomeProductUnitWidth() {
    var cols=getHomeProductTableCols();
    var tempweidth=document.body.clientWidth*0.8;
    var widthi=tempweidth/cols;
    if(widthi>370) widthi=370;
    return widthi;
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

function connect_to_product_list_xml(){
    var xmlDoc = CreateXMLDocumentObject ();    // defined in ajax.js

    if (!xmlDoc) {
        return;
    }

    if (typeof (xmlDoc.load) === "undefined") { // Google Chrome and Safari
        alert("Your browser does not support the load method for XML documents!");
        return;
    }
    var url = "Product_list.xml";
    xmlDoc.async = false;

    if (xmlDoc.load (url)) {
        var catalog_table=document.getElementById("catagory_table");
        var len=catalog_table.childNodes.length;
        /*
        for(var i=1;i<len;i++)
        {
            catalog_table.removeChild(catalog_table.lastChild);
        }*/

        var x=xmlDoc.getElementsByTagName("Root");
        //alert ("Before "+x.length);
        for (i=0;i<2*(x[0].childElementCount);i=i+2)
        {
            //alert ("Define ajax");
            var cata_name=x[0].childNodes[i+1].nodeName;

            var tdi=document.createElement("td");
            var product_type=document.createTextNode(cata_name);
            var ai=document.createElement("a");
            ai.setAttribute("href","Shop_host.html?catalog="+cata_name);
            ai.appendChild(product_type);
            tdi.appendChild(ai);
            var tri=document.createElement("tr");
            tri.appendChild(tdi);
            catalog_table.appendChild(tri);
        }
    }
    else {
        // display error message
        var errorMsg = null;
        if (xmlDoc.parseError && xmlDoc.parseError.errorCode != 0) {
            errorMsg = "XML Parsing Error: " + xmlDoc.parseError.reason
                + " at line " + xmlDoc.parseError.line
                + " at position " + xmlDoc.parseError.linepos;
        }
        else {
            if (xmlDoc.documentElement) {
                if (xmlDoc.documentElement.nodeName == "parsererror") {
                    errorMsg = xmlDoc.documentElement.childNodes[0].nodeValue;
                }
            }
        }
        if (errorMsg) {
            alert (errorMsg);
        }
        else {
            alert ("There was an error while loading XML file!");
        }

    }
    return xmlDoc;
}

function writeFile(filename,filecontent){//alert("write");
    //var fso, f, s ;
    var fso=new ActiveXObject(Scripting.FileSystemObject);alert("fuck");
    var f=fso.createtextfile(filename,2,true);
    f.writeLine(filecontent);alert("write");
    f.close()

}

function readFile(filename){
    var fso = new ActiveXObject("Scripting.FileSystemObject");
    var f = fso.OpenTextFile(filename,1);
    var s = "";
    while (!f.AtEndOfStream)
        s += f.ReadLine()+"/n";
    f.Close();
    return s;
}

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