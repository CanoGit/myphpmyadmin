
var input1 = false;
var input2 = false;
var input3 = false;

$('#host').keyup(function()
{
	if ($('#host').val().match(/^.+/))
	{
		input1 = true;
	}
	else
	{
		input1 = false;
	}
	check();
});

$('#loggin').keyup(function()
{
	if ($('#loggin').val().match(/^.+$/))
	{
		input2 = true;
	}
	else
	{
		input2 = false;
	}
	check();
});

$('#pass').keyup(function()
{
	if ($('#pass').val().match(/^.+$/))
	{
		input3 = true;
	}
	else
	{
		input3 = false;
	}
	check();
});

function	check()
{
	if (input1 && input2 && input3)
		$('button[name=connexion]').prop('disabled', false);
	else
		$('button[name=connexion]').prop('disabled', true);
}
