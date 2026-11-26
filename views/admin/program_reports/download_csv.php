<?php

if ($this->Program_report_model->field_order)
{
	foreach ($this->Program_report_model->field_order as $idx => $fo)
	{
		$label = '';
		if ($fo[0] == 'ud')
			$label = $user_fields[$fo[1]];
		if ($fo[0] == 'up')
			$label = $user_properties[$fo[1]]->field_name;
		if ($fo[0] == 'pp')
			$label = $program_properties[$fo[1]]->field_name;
		
		echo '"'.$fo[0].'",';
	}
}
echo "\n";
	
// data
if (isset($users))
{
	foreach ($users as $user)
	{
		foreach ($this->Program_report_model->field_order as $idx => $fo)
		{
			$label = '';
			if ($fo[0] == 'ud' && isset($user->$fo[1]))
				$label = $user->$fo[1];
			if ($fo[0] == 'up' && isset($user_property_values[$user->id][$fo[1]]))
				$label = $user_property_values[$user->id][$fo[1]]->property_value;
			if ($fo[0] == 'pp' && isset($user_program_properties[$user->id][$fo[1]]))
				$label = $user_program_properties[$user->id][$fo[1]]->property_value;
			
			echo '"'.$label.'",';
		}
		echo "\n";
	}
}