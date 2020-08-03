function ajaxGet(url, callBack){
    var req = new XMLHttpRequest(); 
    req.open("GET", url);
    req.addEventListener("load", function () {
    callBack(req.responseText);
    
});
req.send(null);

}
