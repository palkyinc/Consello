<?php
return [
    'APP_VERSION' => '0.0.4',
    'PASS_EXPIRE' => 3628800,
    'PERMISSIONS_LIST_FACTORY' => array(
            'users_index',
            'users_edit',
            'users_create',
            'roles_index',
            'roles_edit',
            'roles_create',
            'permissions_index',
            'permissions_edit',
            'permissions_create',
            'dashborad_index',
            'dashborad_edit',
            'dashborad_create',
            'clientes_index',
            'clientes_edit',
            'clientes_create',
    ),
    'ROLES_LIST_FACTORY' => array(
            'Admin',
            'Cliente',
    ),
];