function show_confirm(action, title)
{
	var r = confirm("Weet u zeker dat u '" + title + "' wilt verwijderen?");
	if (r == true)
	{
		document.location.href = action;
	}
}
