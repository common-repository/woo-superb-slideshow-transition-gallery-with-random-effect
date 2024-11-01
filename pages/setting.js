function woo_submit()
{
	if(document.form_woo.woo_path.value=="")
	{
		alert(woo_adminscripts.woo_path);
		document.form_woo.woo_path.focus();
		return false;
	}
	else if(document.form_woo.woo_link.value=="")
	{
		alert(woo_adminscripts.woo_link);
		document.form_woo.woo_link.focus();
		return false;
	}
	else if(document.form_woo.woo_target.value=="")
	{
		alert(woo_adminscripts.woo_target);
		document.form_woo.woo_target.focus();
		return false;
	}
	//	else if(document.form_woo.woo_title.value=="")
	//	{
	//		alert(woo_adminscripts.woo_title);
	//		document.form_woo.woo_title.focus();
	//		return false;
	//	}
	else if(document.form_woo.woo_type.value=="")
	{
		alert(woo_adminscripts.woo_type);
		document.form_woo.woo_type.focus();
		return false;
	}
	else if(document.form_woo.woo_status.value=="")
	{
		alert(woo_adminscripts.woo_status);
		document.form_woo.woo_status.focus();
		return false;
	}
	else if(document.form_woo.woo_order.value=="")
	{
		alert(woo_adminscripts.woo_order);
		document.form_woo.woo_order.focus();
		return false;
	}
	else if(isNaN(document.form_woo.woo_order.value))
	{
		alert(woo_adminscripts.woo_order);
		document.form_woo.woo_order.focus();
		return false;
	}
	_woo_escapeVal(document.form_woo.woo_text,'<br>');
}

function woo_delete(id)
{
	if(confirm(woo_adminscripts.woo_delete))
	{
		document.frm_woo_display.action="options-general.php?page=woo-superb-slideshow&ac=del&did="+id;
		document.frm_woo_display.submit();
	}
}	

function woo_help()
{
	window.open("http://www.gopiplus.com/work/2010/09/19/woo-superb-slideshow-transition-gallery-with-random-effect/");
}

function woo_redirect()
{
	window.location = "options-general.php?page=woo-superb-slideshow";
}

function _woo_escapeVal(textarea,replaceWith)
{
	textarea.value = escape(textarea.value) //encode textarea strings carriage returns
	for(i=0; i<textarea.value.length; i++)
	{
		//loop through string, replacing carriage return encoding with HTML break tag
		if(textarea.value.indexOf("%0D%0A") > -1)
		{
			//Windows encodes returns as \r\n hex
			textarea.value=textarea.value.replace("%0D%0A",replaceWith)
		}
		else if(textarea.value.indexOf("%0A") > -1)
		{
			//Unix encodes returns as \n hex
			textarea.value=textarea.value.replace("%0A",replaceWith)
		}
		else if(textarea.value.indexOf("%0D") > -1)
		{
			//Macintosh encodes returns as \r hex
			textarea.value=textarea.value.replace("%0D",replaceWith)
		}
	}
	textarea.value=unescape(textarea.value) //unescape all other encoded characters
}