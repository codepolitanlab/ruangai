<?php 
if (isset($config['relation'])){
	$relEntry = $config['relation']['entry'];
    if(isset($config['relation']['model'])){
        $modelName = $config['relation']['model'];
        if(! isset($this->{$config['relation']['model']}))
        	$this->load->model($config['relation']['model_path']);
    }
    else {
        $modelName = ucfirst($relEntry);
        $modelName .= isset($this->{$modelName.'_model'}) ? '_model' : 'Model';
        if(isset($config['relation']['foreign_key']))
            $this->$modelName->primary_key = $config['relation']['foreign_key'];
    }

    $caption = is_array($config['relation']['caption']) 
               ? $config['relation']['caption'][0] 
               : $config['relation']['caption'];
    $config['options'] = $this->$modelName->as_dropdown($caption)->getAll();
}

if(empty($config['options']))
	$config['options'] = [""=>""];
else
	$config['options'] = [""=>""] + $config['options'];
?>

<?= form_dropdown("filter[".$config['name']."]", $config['options'], $this->input->get("filter[{$config['name']}]", true), 'class="form-select form-select-sm form-filter-dropdown" placeholder="filter by '.$config['name'].'" id="filter-'. $config['name'].'"'); ?>

