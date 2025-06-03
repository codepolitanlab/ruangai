<?php
$checked = json_decode($result[$config['name']]);
if($checked)
	echo $final_content = implode(", ", $checked);
