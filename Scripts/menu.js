function menu_hover(label_id, active)
{
	if(active)
	{
		$('#'+label_id).removeClass('menu_hover');
		//el.className = 'menu_hover';
		
	}
	else
	{
		$('#'+label_id).addClass('menu_hover');
		//el.className = 'topmenu';
	}
} 


function menu_activ(label_id, active, submenu_id)
{
	menu_hover(label_id, active);
	if (submenu_id !=null)
	{
		activate_submenu(active, submenu_id);
	}
}

function activate_submenu(active, submenu_id)
{
	
	if(active)
	{
		document.getElementById(submenu_id).style.display = 'block';
	}
	else
	{
		document.getElementById(submenu_id).style.display = 'none';
	}	
}