function copy(inElement, el) {
  if (inElement.createTextRange) {
    var range = inElement.createTextRange();
    if (range && BodyLoaded==1)
      range.execCommand('Copy');
  } else {
    var flashcopier = 'flashcopier';
    if(!document.getElementById(flashcopier)) {
      var divholder = document.createElement('div');
      divholder.id = flashcopier;
      document.body.appendChild(divholder);
    }
    document.getElementById(flashcopier).innerHTML = '';
    var divinfo = '<embed src="http://localhost/kissabe/assets/flashes/_clipboard.swf" FlashVars="clipboard='+encodeURIComponent(inElement)+'" width="0" height="0" type="application/x-shockwave-flash"></embed>';
    document.getElementById(flashcopier).innerHTML = divinfo;
  }

		var e=document.getElementById(el); 
		var coors= findPos(e); 
		var em=document.getElementById("blip"); 
		em.style.left = coors[0]+"px"; 
		em.style.top = (coors[1]+25)+"px"; 
		em.style.display=""; 
		setTimeout('hB()', 2000);
}

function hB() { var em=document.getElementById('blip');em.style.display="none"; }

function findPos(obj) { var curleft = curtop = 0;if (obj.offsetParent) { curleft = obj.offsetLeft; curtop = obj.offsetTop; while (obj = obj.offsetParent) { curleft += obj.offsetLeft; curtop += obj.offsetTop; } } return [curleft,curtop];}




function writeCookie(name, value, days) {
    //Fix Days
    if(days==null || days=="")days=365;
    
    // Set Date
    var d=new Date(); 
    d.setTime(d.getTime()+(days*24*60*60*1000));  
    var expires="; expires="+d.toGMTString();  
    
    // Write Cookie
    document.cookie = name+"="+value+expires+"; path=/"; 
}

function readCookie(name){
    var c=document.cookie ; 
    if (c.indexOf(name)!=-1) { 
        pos1=c.indexOf("=", c.indexOf(name))+1; 
        pos2=c.indexOf(";",pos1);  
            // If last cookie
            if(pos2==-1)    pos2=c.length;;
        
        data=c.substring(pos1,pos2); 
        
        return data;
    }
}  
function checkform (form)
{
	if (form.url.length == 0)
	{
		alert ("Lütfen kıssaltmak istediğiniz web adresini metin kutusuna yazın yada yapıştırın.");
		form.url.focus();
		return false;
	}

	var myMatch = form.url.value.search(/\./);
	if(myMatch == -1)
	{
		alert ("Lütfen geçerli bir web adresi giriniz!.");
        form.url.focus();
        return false;
	}
}

function start_page() 
{
	$('.menuitem').click(function() { go_menu(this); return false;});
	$('.menuitem_selected').click(function() { go_menu(this); return false;});
//	$('#content').load("kissa_url.php");
	$('#language').change(function() { $('#current_lang').submit();  })
	
	curtab = readCookie("curtab");
	
	if (curtab == undefined)
	{
		curtab = "kissa_url";
		writeCookie("curtab", "kissa_url", 1);
	}
	
	go_menu(document.getElementById(curtab));
}


function getElementsByClassName(oElm, strTagName, strClassName) 
{

	var arrElements = (strTagName == "*" && oElm.all)
    			? oElm.all 
			: oElm.getElementsByTagName(strTagName);

	var arrReturnElements = new Array();

	strClassName = strClassName.replace(/\-/g, "\\-");
	var oRegExp = new RegExp("(^|\\s)" + strClassName + "(\\s|$)");
	var oElement;

	for (var i=0; i<arrElements.length; i++) {
		oElement = arrElements[i];     
		if (oRegExp.test(oElement.className)) {
			arrReturnElements.push(oElement);
		}   
	}

	return (arrReturnElements)
}


function go_menu(menuitem)
{
	writeCookie("curtab", menuitem.id, 1);

	$.ajax({
		type: "GET",
		url: menuitem.href,
		success: function(content) {
			obj = getElementsByClassName(document, "a", "menuitem_selected");
			y = obj[0];
			obj[0].className = "menuitem";
			menuitem.className = "menuitem_selected";
			$('#content').html(content);
			}
	});
}
