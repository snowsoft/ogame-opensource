(function(c){c.fn.dump=function(){return c.dump(this)};c.dump=function(f){var e=function(l,m){if(!m){m=0}var k="",j="";for(i=0;i<m;i++){j+="\t"}t=g(l);switch(t){case"string":return'"'+l+'"';break;case"number":return l.toString();break;case"boolean":return l?"true":"false";case"date":return"Date: "+l.toLocaleString();case"array":k+="Array ( \n";c.each(l,function(o,n){k+=j+"\t"+o+" => "+e(n,m+1)+"\n"});k+=j+")";break;case"object":k+="Object { \n";c.each(l,function(o,n){k+=j+"\t"+o+": "+e(n,m+1)+"\n"});k+=j+"}";break;case"jquery":k+="jQuery Object { \n";c.each(l,function(o,n){k+=j+"\t"+o+" = "+e(n,m+1)+"\n"});k+=j+"}";break;case"regexp":return"RegExp: "+l.toString();case"error":return l.toString();case"document":case"domelement":k+="DOMElement [ \n"+j+"\tnodeName: "+l.nodeName+"\n"+j+"\tnodeValue: "+l.nodeValue+"\n"+j+"\tinnerHTML: [ \n";c.each(l.childNodes,function(o,n){if(o<1){var p=0}if(g(n)=="string"){if(n.textContent.match(/[^\s]/)){k+=j+"\t\t"+(o-(p||0))+" = String: "+a(n.textContent)+"\n"}else{p--}}else{k+=j+"\t\t"+(o-(p||0))+" = "+e(n,m+2)+"\n"}});k+=j+"\t]\n"+j+"]";break;case"function":var h=l.toString().match(/^(.*)\(([^\)]*)\)/im);h[1]=a(h[1].replace(new RegExp("[\\s]+","g")," "));h[2]=a(h[2].replace(new RegExp("[\\s]+","g")," "));return h[1]+"("+h[2]+")";case"window":default:k+="N/A: "+t;break}return k};var g=function(j){var h=typeof(j);if(h!="object"){return h}switch(j){case null:return"null";case window:return"window";case document:return"document";case window.event:return"event";default:break}if(j.jquery){return"jquery"}switch(j.constructor){case Array:return"array";case Boolean:return"boolean";case Date:return"date";case Object:return"object";case RegExp:return"regexp";case ReferenceError:case Error:return"error";case null:default:break}switch(j.nodeType){case 1:return"domelement";case 3:return"string";case null:default:break}return"Unknown"};return e(f)};function a(e){return d(b(e))}function d(e){return e.replace(new RegExp("^[\\s]+","g"),"")}function b(e){return e.replace(new RegExp("[\\s]+$","g"),"")}})(jQuery);