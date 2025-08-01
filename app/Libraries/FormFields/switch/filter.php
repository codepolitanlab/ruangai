<?= form_dropdown("filter[{$config['field']}]", ['' => 'Semua'] + $config['options'], $this->input->get("filter[{$config['field']}]", true), 'class="form-select form-select-sm" placeholder="filter by {$config[\'field\']}"'); ?>

