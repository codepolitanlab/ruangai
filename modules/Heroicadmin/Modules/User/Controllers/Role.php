<?php

namespace Heroicadmin\Modules\User\Controllers;

use Heroicadmin\Controllers\AdminController;

class Role extends AdminController
{
    public function __construct()
    {
        $this->data['module']    = 'user';
        $this->data['submodule'] = 'role';
    }

    public function index()
    {
        $this->data['page_title'] = 'Role Management';

        // Get all roles
        $roleModel           = new \Heroicadmin\Modules\User\Models\RoleModel();
        $this->data['roles'] = $roleModel->findAll();

        return pageView('Heroicadmin\Modules\User\Views\role\index', $this->data);
    }

    public function form($id = null)
    {
        $this->data['page_title'] = 'Role Form';

        // Get id from query string if edit
        if ($id) {
            if ($id === 1) {
                session()->setFlashdata('error_message', 'You cannot edit this role');

                return redirect()->to(urlScope() . '/user/role');
            }

            $roleModel          = new \Heroicadmin\Modules\User\Models\RoleModel();
            $this->data['role'] = $roleModel->find($id);
        }

        return pageView('Heroicadmin\Modules\User\Views\role\form', $this->data);
    }

    // Save role
    public function save()
    {
        // Get id from query string if edit
        $id = $this->request->getPost('id');

        $data['role_name'] = trim($this->request->getPost('role_name'));
        $data['role_slug'] = url_title($this->request->getPost('role_slug'), '_', true);
        $data['status']    = ($this->request->getPost('status') ?? 'active') === 'active' ? 'active' : 'inactive';

        $roleModel = new \Heroicadmin\Modules\User\Models\RoleModel();
        if ($id) {
            // Check by slug if role exists
            if ($roleModel->where('role_slug', $data['role_slug'])
                ->where('id !=', $id)
                ->countAllResults()) {
                session()->setFlashdata('error_message', 'Role slug already exists with another ID');

                return redirect()->back()->withInput();
            }

            $roleModel->update($id, $data);
        } else {
            // Check by slug if role exists
            if ($roleModel->where('role_slug', $data['role_slug'])->countAllResults()) {
                session()->setFlashdata('error_message', 'Role slug already exists');

                return redirect()->back()->withInput();
            }

            $roleModel->insert($data);
        }

        return redirect()->to(urlScope() . '/user/role');
    }

    public function delete($id)
    {
        // TODO: check if role has any users

        // Delete role
        $roleModel = new \Heroicadmin\Modules\User\Models\RoleModel();
        $roleModel->delete($id);

        return redirect()->to(urlScope() . '/user/role');
    }
}
