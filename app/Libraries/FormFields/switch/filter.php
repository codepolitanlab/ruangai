<?= form_dropdown("filter[{$config['name']}]", [''=>'Semua'] + $config['options'], $this->input->get("filter[{$config['name']}]", true), 'class="form-select form-select-sm" placeholder="filter by {$config[\'field\']}"'); ?>

