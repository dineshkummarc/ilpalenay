if(document.createStyleSheet)
        {
            document.createStyleSheet('http://api.aggregateknowledge.com/2007/01/15/css');
        } else {
            var styles = "@import url(' http://api.aggregateknowledge.com/2007/01/15/css ');";
            var akStylesheet = document.createElement('link');
            akStylesheet.rel = 'stylesheet';
            akStylesheet.href = 'data:text/css,' + escape(styles);
            document.getElementsByTagName('head')[0].appendChild(akStylesheet);
        }
function execScripts(documentElement) {
var scriptElements = documentElement.getElementsByTagName('script'); 
var scriptElementsCount = scriptElements.length;
for (var i = scriptElementsCount-1; i >= 0;i--){
var scriptElement = scriptElements[i]; 
var agkn = scriptElement.getAttribute("agkn");
if (agkn == 'agkn' && scriptElement.id != 'akfooterscript'){
if (scriptElement.innerHTML != '')
eval(scriptElement.innerHTML);
else {
var createdScriptElement = document.createElement('script');
createdScriptElement.src = scriptElement.src;
createdScriptElement.type = 'text/javascript';
if(scriptElement.parentNode != null)
scriptElement.parentNode.removeChild(scriptElement);
documentElement.appendChild(createdScriptElement); 
}}else if (agkn == 'agkn' && scriptElement.id == 'akfooterscript'){
if(scriptElement.parentNode != null)
scriptElement.parentNode.removeChild(scriptElement);
}}};

if (!window.ak) var ak = function() {};
ak.getAKContent = function() {
return '<!--\r\n'
+ '    <link rel="stylesheet" HREF="http://api.aggregateknowledge.com/2007/01/15/css" TYPE="text/css" MEDIA=screen>\r\n'
+ '-->\r\n'
+ '    <scr' + 'ipt agkn=\'agkn\' type = "text/javascript" id = "akheaderscript">\r\n'
+ '        if(document.createStyleSheet)\r\n'
+ '        {\r\n'
+ '            document.createStyleSheet(\'http://api.aggregateknowledge.com/2007/01/15/css\');\r\n'
+ '        } else {\r\n'
+ '            var styles = "@import url(\' http://api.aggregateknowledge.com/2007/01/15/css \');";\r\n'
+ '            var akStylesheet = document.createElement(\'link\');\r\n'
+ '            akStylesheet.rel = \'stylesheet\';\r\n'
+ '            akStylesheet.href = \'data:text/css,\' + escape(styles);\r\n'
+ '            document.getElementsByTagName(\'head\')[0].appendChild(akStylesheet);\r\n'
+ '        }\r\n'
+ '    </scr' + 'ipt>\r\n'
+ '<table>\r\n'
+ '	<tr>\r\n'
+ '		<td>\r\n'
+ '			<div class="sidebar-item">\r\n'
+ '				<h3>Recommended for You</h3>\r\n'
+ '				<div class="sidebar-item-content" style="text-align: center">\r\n'
+ '                        				                        <p>\r\n'
+ '		                        	<a href="http://api.aggregateknowledge.com/cp?t=oreilly.com%2Fcatalog%2F9780596002527%3fCMP%3dAFC-ak_book%26ATT%3dXML%2bSchema%252c&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=0&s=DE&rt=RECOMMENDATION&i=443"><img src="http://covers.oreilly.com/images/9780596002527/bkt.gif" border="0" alt="XML Schema," style="padding-bottom: 6px;" /></a>\r\n'
+ '	                        		<br />\r\n'
+ '	                        												<a href="http://api.aggregateknowledge.com/cp?t=oreilly.com%2Fcatalog%2F9780596002527%3fCMP%3dAFC-ak_book%26ATT%3dXML%2bSchema%252c&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=0&s=DE&rt=RECOMMENDATION&i=443"><strong>XML Schema,</strong></a>\r\n'
+ '										<br>\r\n'
+ '										Format: Print, \r\n'
+ '																												$39.95\r\n'
+ '									                        		</p>\r\n'
+ '                        		                        			<hr /> <!-- 2 -->\r\n'
+ '		                        		                        <p>\r\n'
+ '		                        	<a href="http://api.aggregateknowledge.com/cp?t=www.oreillyschool.com%2Fcourses%2Fxml%2Findex.php%3fCMP%3dAFC-ak_course%26ATT%3dLearn%2bXML&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=1&s=DE&rt=RECOMMENDATION&i=443"><img src="http://www.oreillyschool.com/images/ost-course.gif" border="0" alt="Learn XML" style="padding-bottom: 6px;" /></a>\r\n'
+ '	                        		<br />\r\n'
+ '	                        												<a href="http://api.aggregateknowledge.com/cp?t=www.oreillyschool.com%2Fcourses%2Fxml%2Findex.php%3fCMP%3dAFC-ak_course%26ATT%3dLearn%2bXML&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=1&s=DE&rt=RECOMMENDATION&i=443"><strong>Learn XML</strong></a>\r\n'
+ '										<br>\r\n'
+ '										Online, Self-paced Course - 1:1 Coaching, Free Book.  Get Certified Experience!\r\n'
+ '																												$398\r\n'
+ '									                        		</p>\r\n'
+ '                        		                        			<hr /> <!-- 3 -->\r\n'
+ '		                        		                        <p>\r\n'
+ '		                        	<a href="http://api.aggregateknowledge.com/cp?t=oreilly.com%2Fcatalog%2F9780596527709%3fCMP%3dAFC-ak_book%26ATT%3dBeyond%2bSchemas%253A%2bPlanning%2bYour%2bXML%2bModel%252c&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=2&s=DE&rt=RECOMMENDATION&i=443"><img src="http://covers.oreilly.com/images/9780596527709/bkt.gif" border="0" alt="Beyond Schemas: Planning Your XML Model," style="padding-bottom: 6px;" /></a>\r\n'
+ '	                        		<br />\r\n'
+ '	                        												<a href="http://api.aggregateknowledge.com/cp?t=oreilly.com%2Fcatalog%2F9780596527709%3fCMP%3dAFC-ak_book%26ATT%3dBeyond%2bSchemas%253A%2bPlanning%2bYour%2bXML%2bModel%252c&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=2&s=DE&rt=RECOMMENDATION&i=443"><strong>Beyond Schemas: Planning Your XML Model,</strong></a>\r\n'
+ '										<br>\r\n'
+ '										Format: PDF, \r\n'
+ '																												$9.99\r\n'
+ '									                        		</p>\r\n'
+ '                        		                        			<hr /> <!-- 4 -->\r\n'
+ '		                        		                        <p>\r\n'
+ '		                        	<a href="http://api.aggregateknowledge.com/cp?t=www.web2expo.com%2Fwebexny2009%2Fpublic%2Fschedule%2Fdetail%2F10526%3fCMP%3dAFC-ak_conference%26ATT%3dWeb%253AA%2bSite%2bFor%2bYour%2bDev%2bCommunity&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=3&s=DE&rt=RECOMMENDATION&i=443"><img src="http://assets.en.oreilly.com/1/event/31/webexny2009_logo_ak.png" border="0" alt="" style="padding-bottom: 6px;" /></a>\r\n'
+ '	                        		<br />\r\n'
+ '	                        												<a href="http://api.aggregateknowledge.com/cp?t=www.web2expo.com%2Fwebexny2009%2Fpublic%2Fschedule%2Fdetail%2F10526%3fCMP%3dAFC-ak_conference%26ATT%3dWeb%253AA%2bSite%2bFor%2bYour%2bDev%2bCommunity&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=3&s=DE&rt=RECOMMENDATION&i=443"><strong>A Site For Your Dev Community</strong></a>\r\n'
+ '																		                        		</p>\r\n'
+ '                        		                        			<hr /> <!-- 5 -->\r\n'
+ '		                        		                        <p>\r\n'
+ '		                        	<a href="http://api.aggregateknowledge.com/cp?t=oreilly.com%2Fcatalog%2F9781593271831%2F%3fCMP%3dAFC-ak_book%26ATT%3dGrowing%2bSoftware%252c&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=4&s=DE&rt=RECOMMENDATION&i=443"><img src="http://covers.oreilly.com/images/9781593271831/bkt.gif" border="0" alt="Growing Software," style="padding-bottom: 6px;" /></a>\r\n'
+ '	                        		<br />\r\n'
+ '	                        												<a href="http://api.aggregateknowledge.com/cp?t=oreilly.com%2Fcatalog%2F9781593271831%2F%3fCMP%3dAFC-ak_book%26ATT%3dGrowing%2bSoftware%252c&f=www.xml.com%2Fpub%2Fa%2F2000%2F11%2F29%2Fschemas%2Fpart1.html&rg=926&sid=0&rid=0&a=9564&p=4&s=DE&rt=RECOMMENDATION&i=443"><strong>Growing Software,</strong></a>\r\n'
+ '										<br>\r\n'
+ '										 Format: Print, Ebook, \r\n'
+ '																												$31.95\r\n'
+ '									                        		</p>\r\n'
+ '																						</div>	\r\n'
+ '			</div>\r\n'
+ '		</td>\r\n'
+ '	</tr>\r\n'
+ '</table>\r\n'
+ '<scr' + 'ipt agkn=\'agkn\' type="text/javascript" id = "akfooterscript">\r\n'
+ '</scr' + 'ipt>\r\n'
+ '<scr' + 'ipt agkn=\'agkn\' type="text/javascript" id="akfooterscript">\r\n'
+ 'if(!window.ak) var ak = function() {};\r\n'
+ 'function getIFrameDocument(iframe)\r\n'
+ '{\r\n'
+ '    var document = iframe.contentWindow || iframe.contentDocument;\r\n'
+ '    if(document.document)\r\n'
+ '        document = document.document;\r\n'
+ '    return document;\r\n'
+ '}\r\n'
+ 'ak.getIFrameDocument = function(iframe)\r\n'
+ '{\r\n'
+ '    var document = iframe.contentWindow || iframe.contentDocument;\r\n'
+ '    if(document.document)\r\n'
+ '        document = document.document;\r\n'
+ '    return document;\r\n'
+ '};\r\n'
+ '</scr' + 'ipt>\r\n'
+ '<scr' + 'ipt agkn=\'agkn\' type="text/javascript" id = "akfooterscript">\r\n'
+ '    if(!window.ak) var ak = function() {};\r\n'
+ '    if(window.onAKLoad) onAKLoad(); \r\n'
+ '    if(ak.onLoad) ak.onLoad(); \r\n'
+ '    if(ak.notifyAKDebugConsoleOfLoading) ak.notifyAKDebugConsoleOfLoading(); \r\n'
+ '</scr' + 'ipt>\r\n'
;
};

if (ak.recordRoundTripExecutionTime) ak.recordRoundTripExecutionTime();

ak.anchor = document.getElementById('akAPI');
ak.discoveryWindowContent = ak.getAKContent();
if (ak.discoveryWindowContent != null && ak.anchor != null) {
ak.anchor.innerHTML = ak.discoveryWindowContent;
setTimeout('execScripts(ak.anchor)', 2000);
}


if(!window.ak) var ak = function() {};

function getIFrameDocument(iframe)
{
    
    var document = iframe.contentWindow || iframe.contentDocument;
    
    if(document.document)
        document = document.document;
    return document;
}

ak.getIFrameDocument = function(iframe)
{
    
    var document = iframe.contentWindow || iframe.contentDocument;
    
    if(document.document)
        document = document.document;
    return document;
};
if(!window.ak) var ak = function() {};

    
    if(window.onAKLoad) onAKLoad(); 
    if(ak.onLoad) ak.onLoad(); 
    if(ak.notifyAKDebugConsoleOfLoading) ak.notifyAKDebugConsoleOfLoading();
