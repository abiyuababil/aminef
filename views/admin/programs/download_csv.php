<?php
// header
echo 'No;Name;Email;POB;DOB;Program';
echo "\n";

// data
if(!empty($data)){

	//echo $program_info->name;exit;

	foreach($data as $row) {
								
		$format = 'ID';
		if ($country_id == '2')
			$format = 'US';

		$fullname = $this->User_model->get_full_name($row, $format);
		$dob = $row->birth_date ? date('d M Y', strtotime($row->birth_date)) : '';

		echo ++$key.';'.$fullname.';'.$row->email.';'.$row->birth_place.';'.$dob.';'.$program_info->name;
		echo "\n";
	}
}