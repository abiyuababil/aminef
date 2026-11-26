<?php
// header
echo 'No;Name;Email;POB;DOB;Programs';
echo "\n";

// data
if(!empty($data)){

	foreach ($data as $key => $dt) {
		$join_program = '';
		if (isset($user_programs[$dt->id]))
		{
			foreach ($user_programs[$dt->id] as $up)
			{
				if (isset($programs[$up->program_id]))
					$join_program .= $programs[$up->program_id]->name;
			}
		}

		$dob = $dt->birth_date ? date('d M Y', strtotime($dt->birth_date)) : '';
		$format = 'ID';
		if ($country_id == '2')
			$format = 'US';
		$fullname = $this->User_model->get_full_name($dt, $format);

		echo ++$key.';'.$fullname.';'.$dt->email.';'.$dt->birth_place.';'.$dob.';'.$join_program;
		echo "\n";
	}
}