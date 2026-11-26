<?php
// header

$dlmtr = $this->config->item('csv_delimiter');

if ($user_fields) {
	if ($user_fields) {
		echo "ud|id".$dlmtr;
		echo "ud|email".$dlmtr;
		echo "ud|name".$dlmtr;
		echo "ud|first_name".$dlmtr;
		echo "ud|midle_name".$dlmtr;
		echo "ud|last_name".$dlmtr;
		echo "ud|gender".$dlmtr;
		echo "ud|birth_place".$dlmtr;
		echo "ud|birth_date".$dlmtr;
		echo "ud|phone_mobile".$dlmtr;
		echo "ud|phone_home".$dlmtr;
		echo "ud|provinci".$dlmtr;
		echo "ud|city".$dlmtr;
		echo "ud|address".$dlmtr;
		echo "ud|bank_info".$dlmtr;
		echo "ud|passport_number".$dlmtr;
		echo "ud|passport_date_issue".$dlmtr;
		echo "ud|passport_date_expired".$dlmtr;
		echo "ud|img_passport".$dlmtr;
		echo "ud|img_certificate".$dlmtr;
		echo "ud|img_photo".$dlmtr;
		echo "ud|active_program_id".$dlmtr;
		echo "ud|email_verified".$dlmtr;
		echo "ud|last_login".$dlmtr;
		echo "ud|date_insert".$dlmtr;
		echo "ud|date_modified".$dlmtr;
	}
}
if ($user_properties) {
	foreach ($user_properties as $up) {
		echo '"up|'.$up->field_slug.'"'.$dlmtr;
	}	
}
if ($program_properties) {
	foreach ($program_properties as $pp) {	
		echo '"pp|'.$pp->field_slug.'"'.$dlmtr;
	}
}

echo "\n";
if ($users) {
	foreach($users as $rowData){
		echo '"'.$rowData->id.'"'.$dlmtr;
		echo '"'.$rowData->email.'"'.$dlmtr;
		echo '"'.$rowData->name.'"'.$dlmtr;
		echo '"'.$rowData->first_name.'"'.$dlmtr;
		echo '"'.$rowData->midle_name.'"'.$dlmtr;
		echo '"'.$rowData->last_name.'"'.$dlmtr;
		echo '"'.$rowData->gender.'"'.$dlmtr;
		echo '"'.$rowData->birth_place.'"'.$dlmtr;
		echo '"'.$rowData->birth_date.'"'.$dlmtr;
		echo '"'.$rowData->phone_mobile.'"'.$dlmtr;
		echo '"'.$rowData->phone_home.'"'.$dlmtr;
		echo '"'.$rowData->provinci.'"'.$dlmtr;
		echo '"'.$rowData->city.'"'.$dlmtr;
		echo '"'.$rowData->address.'"'.$dlmtr;
		echo '"'.$rowData->bank_info.'"'.$dlmtr;
		echo '"'.$rowData->passport_number.'"'.$dlmtr;
		echo '"'.$rowData->passport_date_issue.'"'.$dlmtr;
		echo '"'.$rowData->passport_date_expired.'"'.$dlmtr;
		echo '"'.$rowData->img_passport.'"'.$dlmtr;
		echo '"'.$rowData->img_certificate.'"'.$dlmtr;
		echo '"'.$rowData->img_photo.'"'.$dlmtr;
		echo '"'.$rowData->active_program_id.'"'.$dlmtr;
		echo '"'.$rowData->email_verified.'"'.$dlmtr;
		echo '"'.$rowData->last_login.'"'.$dlmtr;
		echo '"'.$rowData->date_insert.'"'.$dlmtr;
		echo '"'.$rowData->date_modified.'"'.$dlmtr;

		foreach($user_properties as $keys => $up){
			$label = '';
			foreach ($user_property_values as $property_id => $upv) {
				if($upv->user_id == $rowData->id && $up->id == $upv->property_id){
					$label = $upv->property_value;	break;
				}
			}
			echo '"'.$label.'"'.$dlmtr;
		}
		
		foreach($program_properties as $keys => $pp){
			$label = '';
			foreach ($user_program_properties as $property_id => $upp) {
				if($upp->user_id == $rowData->id && $pp->id == $upp->property_id){
					$label = $upp->property_value;	break;
				}
			}
			echo '"'.$label.'"'.$dlmtr;
		}

		echo "\n";
	}
}
