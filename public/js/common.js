function getNodeValue(xmlDoc, nodeName) {
    var elements = xmlDoc.getElementsByTagName(nodeName);
                
    if (elements != null && elements.length > 0) {
        var children = elements[0].childNodes;
                    
        if (children != null && children.length > 0) {
            return children[0].nodeValue;                        
        }
    }
                
    return null;
}


function isEmpty(source, replacement) {
    if (source == null || source == "") {
        return replacement;
    }
    else {
        return source;
    }
}
function addCommas(nStr) {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                
                return x1 + x2;
            }
            
function daysInMonth(month,year) {
var dd = new Date(year, month, 0);
return dd.getDate();
} 

function showGraph(xmldata){
    
   $.plot($("#chart-demo"),
                [
                  {
                        label:'Mall Rat',
                        data:xmldata[0],
                        lines:{ show:true, fill:0.4 },
                        color:"#8AB4B5",
                        hoverable:true
                    },
                    {
                        label:'Mall Session',
                        data:xmldata[1],
                        lines:{ show:true, fill:0.4 },
                        color:"#FC354C",
                        hoverable:true
                    }
                ],

                {
                    series:{ lines:{ show:true }, points:{ show:true }, curvedLines:{ active:true } },
                    grid:{ hoverable:true, clickable:true },
                    legend:{ show:false },
                    yaxis:{ position:"right" }
                }
            );

$("#chart-demo").tooltipColor();

}

