function randId()
{
	return "id" + Math.round(1000000 * Math.random());
}

var wait;

/* Override HTML elements default behavior for given event with AJAX function
 */
function attachAjax(id, evt, fn, context)
{
	if (document.getElementById(id))
	{
		eval("document.getElementById(id).on" + evt +"=function(){return false;}");

		if (typeof context == 'undefined')
		{
			YAHOO.util.Event.addListener(id, evt, fn);
		}
		else
		{
			YAHOO.util.Event.addListener(id, evt, fn, context, true);
		}
	}
}
/* Resizing Ajax windows if too tall
 */
function checkPanelHeight(ID, link)
{
	if (document.getElementById(ID).clientHeight > (YAHOO.util.Dom.getViewportHeight() - 50))
	{
		var newHeight = YAHOO.util.Dom.getViewportHeight() - 50;
		link.cfg.setProperty("height", newHeight + "px");
		var bodyHeight = (newHeight - link.footer.offsetHeight - link.header.offsetHeight - 15);
		if (bodyHeight < 0) bodyHeight = 0;
		link.body.style.height = bodyHeight + "px";
		var innerHeight = link.innerElement.offsetHeight;
		var headerHeight = link.header.offsetHeight;
		if (innerHeight < headerHeight) link.innerElement.style.height = headerHeight + "px";
		link.footer.style.height = "0px";
	}
}

/* Finds links to code samples in the main content div
 */
function findCodeSampleLinks()
{
	// Code examples links from main text
	var a = YAHOO.util.Dom.getElementsByClassName("Local", "A", "main");

	for (i = 0; i < a.length; i++)
	{
		YAHOO.util.Event.addListener(a[i], "click", function() {
			var title = this.innerHTML;

			YAHOO.util.Connect.asyncRequest('GET', this.href, {success: function(o) {
				var newID = randId();
				panel = new YAHOO.widget.ResizePanel(newID, {width: "600px", visible: true, close: true, draggable: true, constraintoviewport: true, fixedcenter: true, effect: {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.5}});
				panel.setHeader(title);
				panel.setBody(o.responseText);
				panel.render(document.body);

				// Adjust panel's size if taller than screen
				checkPanelHeight(newID, panel);
			}}, null);
		});

		// Keep the link from being followed
		a[i].onclick = function() {return false;};
	}
}

var loginFunction = function()
{
	u = document.getElementById("formLogin").Username.value;
	p = document.getElementById("formLogin").Password.value;
	YAHOO.util.Connect.asyncRequest('POST', "login.php?mode=ajax", logInObj, "Username=" + u + "&Password=" + p);
}

/* Attach AJAX events
 */
YAHOO.util.Event.addListener(window, "load", function() {
	findCodeSampleLinks();

	// Log in link
	attachAjax("LinkLogin", "click", loginFunction);
	attachAjax("formLogin", "submit", loginFunction);

	// Register link
	attachAjax("LinkRegister", "click", function() {
		YAHOO.util.Connect.asyncRequest('GET', document.getElementById("LinkRegister").href + "?mode=ajax", registerObj, null);
	});

	// Account page link
	attachAjax("LinkAccount", "click", function() {
		YAHOO.util.Connect.asyncRequest('GET', document.getElementById("LinkAccount").href + "mode=ajax", accountObj, null);
	});

	// Submit Resources link
	attachAjax("LinkResource", "click", function() {
		YAHOO.util.Connect.asyncRequest('GET', document.getElementById("LinkResource").href + "?mode=ajax", submitResource, null);
	});

	// Logout link
	attachAjax("LinkLogout", "click", function() {
		YAHOO.util.Connect.asyncRequest('GET', "logout.php?mode=ajax", logOutObj, null);
	});

	wait = new YAHOO.widget.Panel("wait", {width: "240px", visible: true, draggable: false, close: false, modal: true, fixedcenter: true});
	wait.setHeader("Loading");
	wait.setBody("Please wait...");
	wait.render(document.body);
	wait.hide();
});


/* AJAX handler objects...
 */

var logInObj = 
{
	success: function(o)
	{
		if (o.responseText == "0")
		{
			alert("Login failed. Check email/password.");
		}
		else if (o.responseText == "-1")
		{
			alert("Please confirm your email address before you can log in. Your registration email has been re-sent to the address you provided.");
		}
		else
		{
			document.getElementById("divLogin").innerHTML = o.responseText;

			// Account page link
			attachAjax("LinkAccount", "click", function() {
				YAHOO.util.Connect.asyncRequest('GET', document.getElementById("LinkAccount").href + "mode=ajax", accountObj, null);
			});

			// Logout link
			attachAjax("LinkLogout", "click", function() {
				YAHOO.util.Connect.asyncRequest('GET', "logout.php?mode=ajax", logOutObj, null);
			});
		}
	}
}

var logOutObj =
{
	success: function(o)
	{
		document.getElementById("divLogin").innerHTML = o.responseText;

		// Log in link
		attachAjax("LinkLogin", "click", loginFunction);
		attachAjax("formLogin", "submit", loginFunction);

		// Register link
		attachAjax("LinkRegister", "click", function() {
			YAHOO.util.Connect.asyncRequest('GET', document.getElementById("LinkRegister").href + "?mode=ajax", registerObj, null);
		});

		// Account page link
		attachAjax("LinkAccount", "click", function() {
			YAHOO.util.Connect.asyncRequest('GET', document.getElementById("LinkAccount").href + "&mode=ajax", accountObj, null);
		});
	}
}

var registerObj = 
{
	success: function(o)
	{
		var newID = randId();
		panel = new YAHOO.widget.ResizePanel(newID, {width: "600px", visible: true, draggable: true, close: true, modal: true, fixedcenter: true, effect: {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.5}});
		panel.setHeader("Register");
		panel.setBody(o.responseText);
		wait.hide();
		panel.render(document.body);

		// Adjust panel's size if taller than screen
		checkPanelHeight(newID, panel);

		attachAjax("LinkAccountY", "click", function()
		{
			YAHOO.util.Connect.asyncRequest('GET', 'account.php?page=forgot&mode=ajax', accountObj);
			this.hide();
			wait.show();
		}, panel);

		attachAjax("LinkGoBack", "click", function()
		{
			YAHOO.util.Connect.asyncRequest('GET', 'register.php?page=1&mode=ajax', registerObj);
			this.hide();
			wait.show();
		}, panel);

		attachAjax("Register3", "submit", function()
		{
			postData = "agree="		+ (document.getElementById("Register3").agree.checked ? "on" : "");
			YAHOO.util.Connect.asyncRequest('POST', 'register.php?page=register&mode=ajax', registerObj, postData);
			this.hide();
			wait.show();
		}, panel);

		attachAjax("Register2", "submit", function()
		{
			var count = parseInt(document.getElementById("Register2").count.value);
			for (postData = "", i = 1; i <= count; i++)
			{
				if (document.getElementById("t[" + i +"]") && document.getElementById("t[" + i +"]").checked)
				{
					postData += "t[" + i + "]=on&";
				}
			}
			YAHOO.util.Connect.asyncRequest('POST', 'register.php?page=3&mode=ajax', registerObj, postData);
			this.hide();
			wait.show();
		}, panel);

		attachAjax("Register1", "submit", function()
		{
			postData = "First_Name="	+ document.getElementById("Register1").First_Name.value
				 + "&Last_Name="	+ document.getElementById("Register1").Last_Name.value
				 + "&Company="		+ document.getElementById("Register1").Company.value
				 + "&Job_Title="	+ document.getElementById("Register1").Job_Title.value
				 + "&Phone_Number="	+ document.getElementById("Register1").Phone_Number.value
				 + "&Email="		+ document.getElementById("Register1").Email.value
				 + "&Email2="		+ document.getElementById("Register1").Email2.value
				 + "&Password="		+ document.getElementById("Register1").Password.value
				 + "&Password2="	+ document.getElementById("Register1").Password2.value
				 + "&online="		+ (document.getElementById("Register1").online[0].checked ? "Yes" : document.getElementById("Register1").online[1].checked ? "No" : "Maybe")
				 + "&onsite="		+ (document.getElementById("Register1").onsite[0].checked ? "Yes" : document.getElementById("Register1").onsite[1].checked ? "No" : "Maybe")
				 + "&contactPref="	+ (document.getElementById("Register1").contactPref[0].checked ? "Phone" : "Email");
			YAHOO.util.Connect.asyncRequest('POST', 'register.php?page=2&mode=ajax', registerObj, postData);
			this.hide();
			wait.show();
		}, panel);
	}
}

var accountObj = 
{
	success: function(o)
	{
		var newID = randId();
		panel = new YAHOO.widget.ResizePanel(newID, {width: "440px", visible: true, draggable: true, close: true, modal: true, fixedcenter: true, effect: {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.5}});
		panel.setHeader("Manage Account");
		panel.setBody(o.responseText);
		wait.hide();
		panel.render(document.body);

		// Adjust panel's size if taller than screen
		checkPanelHeight(newID, panel);

		//LinkAccount
		attachAjax("LinkAccountX", "click", function()
		{
			YAHOO.util.Connect.asyncRequest('GET', 'account.php?page=account&mode=ajax', accountObj, null);
			this.hide();
			wait.show();
		}, panel);

		//LinkChanges
		attachAjax("LinkChanges", "click", function()
		{
			YAHOO.util.Connect.asyncRequest('GET', 'account.php?page=changes&mode=ajax', accountObj, null);
			this.hide();
			wait.show();
		}, panel);

		//LinkSuggest
		attachAjax("LinkSuggest", "click", function()
		{
			YAHOO.util.Connect.asyncRequest('GET', 'account.php?page=suggest&mode=ajax', accountObj, null);
			this.hide();
			wait.show();
		}, panel);

		//AccountSuggest
		attachAjax("AccountSuggest", "submit", function()
		{
			postData = "ChangeType="	+ document.getElementById("AccountSuggest").ChangeType.options[document.getElementById("AccountSuggest").ChangeType.selectedIndex].value
				 + "&Priority="		+ document.getElementById("AccountSuggest").Priority.options[document.getElementById("AccountSuggest").Priority.selectedIndex].value
				 + "&Suggestion="	+ document.getElementById("AccountSuggest").Suggestion.value;
			YAHOO.util.Connect.asyncRequest('POST', 'account.php?do=send&page=suggest&mode=ajax', accountObj, postData);
			this.hide();
			wait.show();
		}, panel);

		//AccountAccount
		attachAjax("AccountAccount", "submit", function()
		{
			postData = "First_Name="	+ document.getElementById("AccountAccount").First_Name.value
				 + "&Last_Name="	+ document.getElementById("AccountAccount").Last_Name.value
				 + "&Company="		+ document.getElementById("AccountAccount").Company.value
				 + "&Job_Title="	+ document.getElementById("AccountAccount").Job_Title.value
				 + "&Phone_Number="	+ document.getElementById("AccountAccount").Phone_Number.value;
			YAHOO.util.Connect.asyncRequest('POST', 'account.php?do=send&page=account&mode=ajax', accountObj, postData);
			this.hide();
			wait.show();
		}, panel);

		//AccountEmail
		attachAjax("AccountEmail", "submit", function()
		{
			postData = "Email="		+ document.getElementById("AccountEmail").Email.value
				 + "&Email2="		+ document.getElementById("AccountEmail").Email2.value;
			YAHOO.util.Connect.asyncRequest('POST', 'account.php?do=send&page=email&mode=ajax', accountObj, postData);
			this.hide();
			wait.show();
		}, panel);

		//AccountPassword
		attachAjax("AccountPassword", "submit", function()
		{
			postData = "OldPass="		+ document.getElementById("AccountPassword").OldPass.value
				 + "&Password="		+ document.getElementById("AccountPassword").Password.value
				 + "&Password2="	+ document.getElementById("AccountPassword").Password2.value;
			YAHOO.util.Connect.asyncRequest('POST', 'account.php?do=send&page=password&mode=ajax', accountObj, postData);
			this.hide();
			wait.show();
		}, panel);

		//AccountForgot
		attachAjax("AccountForgot", "submit", function()
		{
			postData = "Last_Name="		+ document.getElementById("AccountForgot").Last_Name.value
				 + "&Email="		+ document.getElementById("AccountForgot").Email.value;
			YAHOO.util.Connect.asyncRequest('POST', 'account.php?do=send&page=forgot&mode=ajax', accountObj, postData);
			this.hide();
			wait.show();
		}, panel);
	}
}

var submitResource =
{
	success: function(o)
	{
		var newID = randId();
		panel = new YAHOO.widget.ResizePanel(newID, {width: "320px", visible: true, close: true, modal: true, fixedcenter: true, effect: {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.5}});
		panel.setHeader("Submit a Resource");
		panel.setBody(o.responseText);
		wait.hide();
		panel.render(document.body);
		// Adjust panel's size if taller than screen
		checkPanelHeight(newID, panel);

		attachAjax("FormResource", "submit", function()
		{
			postData = "LinkName="		+ document.getElementById("FormResource").LinkName.value
				 + "&URL="		+ document.getElementById("FormResource").URL.value
				 + "&Comment="		+ document.getElementById("FormResource").Comment.value
				 + "&ContactName="	+ document.getElementById("FormResource").ContactName.value
				 + "&Phone="		+ document.getElementById("FormResource").Phone.value
				 + "&Email="		+ document.getElementById("FormResource").Email.value
				 + "&LinkedToPage="	+ document.getElementById("FormResource").LinkedToPage.value;

			YAHOO.util.Connect.asyncRequest('POST', 'resource.php?do=submit&mode=ajax', submitResource, postData);

			this.hide();
			wait.show();
		}, panel);
	}
}

function showPanel(content) {
	var newID = randId();
	panel = new YAHOO.widget.ResizePanel(newID, {width: "600px", visible: true, draggable: true, close: true, modal: true, fixedcenter: true, effect: {effect: YAHOO.widget.ContainerEffect.FADE, duration: 0.5}});
	panel.setHeader("Register");
	panel.setBody(content);
	wait.hide();
	panel.render(document.body);

	// Adjust panel's size if taller than screen
	checkPanelHeight(newID, panel);
}