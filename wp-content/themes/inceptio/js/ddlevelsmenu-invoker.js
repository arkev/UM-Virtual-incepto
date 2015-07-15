var scripts = document.getElementsByTagName("script");
for(var i=0; i<scripts.length; i++){
    var src = scripts[i].src;
    if(src && src.length > 0 && src.indexOf('/js/ddlevelsmenu-invoker.js') >= 0 && src.indexOf('https://') >= 0){
        ddlevelsmenu.httpsiframesrc = src.replace('/js/ddlevelsmenu-invoker.js', '/blank.htm');
        break;
    }
}
ddlevelsmenu.setup("nav", "topbar");