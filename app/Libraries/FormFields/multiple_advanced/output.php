<?php 
// Mutation.
if (isset($config['relation']))
{
	$field = $config['name'];
	$config['name'] = $config['relation']['caption'];
	
	if(!empty($result[$field])){
		$value = [];
		foreach ($result[$field] as $resId => $res)
			foreach ($config['name'] as $caption)
				$value[$resId][] = $res[$caption];
		
		foreach ($value as $val)
			echo "<span class='badge badge-secondary'>".implode(' - ', $val)."</span>&nbsp;";
	}
}
else 
{
    echo $config['options'][$result[$config['name']]];
}