<?php

namespace App\Controllers;

class RoleController extends BaseController
{
    /**
     * Tampilkan daftar role/group
     */
    public function index()
    {
        $authGroups = config('AuthGroups');

        $data = [
            'title'         => 'Manajemen Role',
            'page_title'    => 'Daftar Role',
            'page_pretitle' => 'Administrasi',
            'groups'        => $authGroups->groups,
            'matrix'        => $authGroups->matrix,
            'permissions'   => $authGroups->permissions,
        ];

        return $this->renderView('roles/index', $data);
    }

    /**
     * Tampilkan daftar permissions
     */
    public function permissions()
    {
        $authGroups = config('AuthGroups');

        $data = [
            'title'         => 'Daftar Permission',
            'page_title'    => 'Daftar Permission',
            'page_pretitle' => 'Administrasi',
            'permissions'   => $authGroups->permissions,
            'groups'        => $authGroups->groups,
            'matrix'        => $authGroups->matrix,
        ];

        return $this->renderView('roles/permissions', $data);
    }
}
