<?php 
// Mutation.
if (isset($config['relation']))
{
	$entry = $config['relation']['entry'];
	$config['name'] = $config['relation']['caption'];
	
	if(!empty($result[$entry])){
		$value = array_column($result[$entry], $config['name']);
		foreach ($value as $val)
			echo "<span class='badge badge-info'>$val</span>&nbsp;";
	}
}
else 
{
    echo $config['options'][$result[$config['name']]];
}