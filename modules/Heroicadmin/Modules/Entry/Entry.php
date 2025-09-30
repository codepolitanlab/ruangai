<?php

namespace Heroicadmin\Modules\Entry;

use CodeIgniter\Exceptions\PageNotFoundException;

class Entry
{
    protected $schema;
    protected $request;

    public function __construct($schema)
    {
        $this->request = \Config\Services::request();

        $this->schema = $schema;
    }

    /**
     * Generate table template
     */
    public function table(array $options = [])
    {
        $data['schema'] = $this->schema;

        return view('Heroicadmin\Modules\Entry\Views\table', array_merge($data, $options));
    }

    /**
     * Generate table body, serve for ajax request
     */
    public function tableBody(array $options = [])
    {
        $page    = max(1, (int) $this->request->getGet('page'));
        $filters = $this->request->getGet('filter') ?? [];
        $visible = $this->request->getGet('visible') ?? [];
        $perPage = $this->request->getGet('perpage') ?? 5;
        $orderBy = $this->request->getGet('orderby') ?? 'id';
        $sort    = $this->request->getGet('sort') ?? 'desc';

        $db      = \Config\Database::connect();
        $builder = $db->table($this->schema['table']);

        // Find all schema fields with relation for joins
        foreach ($this->schema['show_on_table'] as $field) {
            if (isset($this->schema['fields'][$field]['relation'])) {
                $builder->join(
                    $this->schema['fields'][$field]['relation']['table'],
                    $this->schema['fields'][$field]['relation']['table'] . '.' . $this->schema['fields'][$field]['relation']['foreignKey'] . ' = ' . $this->schema['table'] . '.' . $this->schema['fields'][$field]['relation']['localKey'],
                    'left',
                    false
                );
            }
        }

        // Prepare select column
        $builder->select($this->prepSelectColumn($visible));

        // Filter by chosen
        foreach ($filters as $ffield => $fvalue) {
            if (! empty($fvalue)) {
                $whereTable = $this->schema['fields'][$ffield]['relation']['table'] ?? $this->schema['table'];
                $whereField = $this->schema['fields'][$ffield]['name'] ?? $ffield;

                if (strpos($fvalue, '|') === false) {
                    $builder->like($whereTable . '.' . $whereField, $fvalue);
                } else {
                    $temp     = explode('|', $fvalue);
                    $operator = $temp[0];
                    $fvalue   = trim($temp[1]);
                    $builder->where($whereTable . '.' . $whereField . ' ' . $operator, $fvalue);
                }
            }
        }

        // Hitung total
        $total = $builder->countAllResults(false);
        $builder->orderBy($orderBy, $sort);
        $builder->limit($perPage, ($page - 1) * $perPage);
        $row['rows'] = $builder->get()->getResultArray();

        $row['perpage']     = $perPage;
        $row['totalRows']   = $total;
        $row['currentPage'] = $page;
        $row['totalPages']  = ceil($total / $perPage);
        $row['visible']     = $visible;
        $row['base_url']    = $this->schema['base_url'];
        $row['primary_key'] = $this->schema['primary_key'] ?? 'id';

        return view('Heroicadmin\Modules\Entry\Views\tableBody', array_merge($row, $options));
    }

    /**
     * Generate form template
     */
    public function form($id = null)
    {
        $FormBuilder = new \Heroicadmin\Libraries\FormBuilder\FormBuilder();
        $FormBuilder->schemaArray($this->schema['fields']);

        // Supply data for edit
        $values = [];
        if ($id) {
            $db      = \Config\Database::connect();
            $builder = $db->table($this->schema['table']);
            $values  = $builder->where($this->schema['primary_key'] ?? 'id', $id)->get()->getRowArray();
            if (! $values) {
                throw new PageNotFoundException('Data not found');
            }
        }

        // Apply error if exists
        if (validation_errors()) {
            $FormBuilder->applyValidationErrors(validation_errors());
        }

        $data['schema'] = $this->schema;
        $data['form']   = $FormBuilder->render($values);

        return view('Heroicadmin\Modules\Entry\Views\form', $data);
    }

    /**
     * Insert new record
     */
    public function insert($postData)
    {
        $FormBuilder = new \Heroicadmin\Libraries\FormBuilder\FormBuilder();
        $FormBuilder->schemaArray($this->schema['fields']);

        // Validate data
        $validation = \Config\Services::validation();
        $validation->setRules($FormBuilder->getValidationRules(), $FormBuilder->getValidationMessages());
        if (! $validation->run($postData)) {
            return false;
        }

        // Insert data to database based on schema
        $db      = \Config\Database::connect();
        $builder = $db->table($this->schema['table']);

        // Get only value which is fillable
        $fillable = $this->getFillableFields();
        $postData = array_intersect_key($postData, $fillable);
        $builder->insert($postData);

        if ($id = $db->insertID()) {
            session()->setFlashdata('success_message', 'Data berhasil disimpan.');

            return $id;
        }
    }

    /**
     * Update existing record
     */
    public function update($id, $postData)
    {
        $FormBuilder = new \Heroicadmin\Libraries\FormBuilder\FormBuilder();
        $FormBuilder->schemaArray($this->schema['fields']);

        // Validate data
        $validation = \Config\Services::validation();
        $validation->setRules($FormBuilder->getValidationRules(), $FormBuilder->getValidationMessages());
        if (! $validation->run($postData)) {
            return false;
        }

        // Update data to database based on schema
        $db      = \Config\Database::connect();
        $builder = $db->table($this->schema['table']);

        // Get only value which is fillable
        $fillable = $this->getFillableFields();
        $postData = array_intersect_key($postData, $fillable);
        $builder->where($this->schema['primary_key'] ?? 'id', $id)->update($postData);

        if ($result = $db->affectedRows()) {
            session()->setFlashdata('success_message', 'Data berhasil diperbaharui.');

            return $result;
        }
    }

    /**
     * Delete existing record
     */
    public function delete($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->schema['table']);
        $builder->where($this->schema['primary_key'] ?? 'id', $id)->delete();

        if ($result = $db->affectedRows()) {
            session()->setFlashdata('success_message', 'Data berhasil dihapus.');

            return $result;
        }
    }

    private function getFillableFields(): array
    {
        return array_filter($this->schema['fields'], static fn($field) => $field['type'] ?? false);
    }

    private function prepSelectColumn(array $visible): array
    {
        // id of current table must be included
        $select[] = $this->schema['table'] . '.' . ($this->schema['primary_key'] ?? 'id');

        foreach ($this->schema['show_on_table'] as $field) {
            // Select only column requested
            if (! empty($visible[$field])) {
                // Select with options
                if (isset($this->schema['fields'][$field]['options'])) {
                    $tempSelect = 'CASE ';

                    foreach ($this->schema['fields'][$field]['options'] as $key => $value) {
                        $tempSelect .= "WHEN {$this->schema['table']}.{$field} = '{$key}' THEN '{$value}' ";
                    }
                    $tempSelect .= "ELSE '-' END as {$field}";

                    $select[] = $tempSelect;
                }

                // Select with relation table
                elseif (isset($this->schema['fields'][$field]['relation'])) {
                    $select[] = $this->schema['fields'][$field]['relation']['table'] . '.' . $this->schema['fields'][$field]['name'] . ' as ' . $field;
                } else {
                    $select[] = $this->schema['table'] . '.' . $this->schema['fields'][$field]['name'] . ' as ' . $field;
                }
            }
        }

        return $select;
    }
}
