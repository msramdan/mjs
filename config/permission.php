<?php

return [
    'models' => [

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your permissions. Of course, it
         * is often just the "Permission" model but you may use whatever you like.
         *
         * The model you want to use as a Permission model needs to implement the
         * `Spatie\Permission\Contracts\Permission` contract.
         */

        'permission' => Spatie\Permission\Models\Permission::class,

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * Eloquent model should be used to retrieve your roles. Of course, it
         * is often just the "Role" model but you may use whatever you like.
         *
         * The model you want to use as a Role model needs to implement the
         * `Spatie\Permission\Contracts\Role` contract.
         */

        'role' => Spatie\Permission\Models\Role::class,

    ],

    'table_names' => [

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'roles' => 'roles',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your permissions. We have chosen a basic
         * default value but you may easily change it to any table you like.
         */

        'permissions' => 'permissions',

        /*
         * When using the "HasPermissions" trait from this package, we need to know which
         * table should be used to retrieve your models permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_permissions' => 'model_has_permissions',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your models roles. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'model_has_roles' => 'model_has_roles',

        /*
         * When using the "HasRoles" trait from this package, we need to know which
         * table should be used to retrieve your roles permissions. We have chosen a
         * basic default value but you may easily change it to any table you like.
         */

        'role_has_permissions' => 'role_has_permissions',
    ],

    'column_names' => [
        /*
         * Change this if you want to name the related pivots other than defaults
         */
        'role_pivot_key' => null, //default 'role_id',
        'permission_pivot_key' => null, //default 'permission_id',

        /*
         * Change this if you want to name the related model primary key other than
         * `model_id`.
         *
         * For example, this would be nice if your primary keys are all UUIDs. In
         * that case, name this `model_uuid`.
         */

        'model_morph_key' => 'model_id',

        /*
         * Change this if you want to use the teams feature and your related model's
         * foreign key is other than `team_id`.
         */

        'team_foreign_key' => 'team_id',
    ],

    /*
     * When set to true, the method for checking permissions will be registered on the gate.
     * Set this to false, if you want to implement custom logic for checking permissions.
     */

    'register_permission_check_method' => true,

    /*
     * When set to true the package implements teams using the 'team_foreign_key'. If you want
     * the migrations to register the 'team_foreign_key', you must set this to true
     * before doing the migration. If you already did the migration then you must make a new
     * migration to also add 'team_foreign_key' to 'roles', 'model_has_roles', and
     * 'model_has_permissions'(view the latest version of package's migration file)
     */

    'teams' => false,

    /*
     * When set to true, the required permission names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_permission_in_exception' => false,

    /*
     * When set to true, the required role names are added to the exception
     * message. This could be considered an information leak in some contexts, so
     * the default setting is false here for optimum safety.
     */

    'display_role_in_exception' => false,

    /*
     * By default wildcard permission lookups are disabled.
     */

    'enable_wildcard_permission' => false,

    'cache' => [

        /*
         * By default all permissions are cached for 24 hours to speed up performance.
         * When permissions or roles are updated the cache is flushed automatically.
         */

        'expiration_time' => \DateInterval::createFromDateString('24 hours'),

        /*
         * The cache key used to store all permissions.
         */

        'key' => 'spatie.permission.cache',

        /*
         * You may optionally indicate a specific cache driver to use for permission and
         * role caching using any of the `store` drivers listed in the cache.php config
         * file. Using 'default' here means to use the `default` set in cache.php.
         */

        'store' => 'default',
    ],

    'list_permissions' => [
        [
            'group' => 'jabatan',
            'lists' => [
                'view jabatan',
                'create jabatan',
                'edit jabatan',
                'delete jabatan',
            ],
        ],
        [
            'group' => 'divisi',
            'lists' => [
                'view divisi',
                'create divisi',
                'edit divisi',
                'delete divisi',
            ],
        ],
        [
            'group' => 'lokasi',
            'lists' => [
                'view lokasi',
                'create lokasi',
                'edit lokasi',
                'delete lokasi',
            ],
        ],
        [
            'group' => 'karyawan',
            'lists' => [
                'view karyawan',
                'create karyawan',
                'edit karyawan',
                'delete karyawan',
                'upload berkas karyawan'
            ],
        ],
        [
            'group' => 'status karyawan',
            'lists' => [
                'view status karyawan',
                'create status karyawan',
                'edit status karyawan',
                'delete status karyawan',
            ],
        ],
        [
            'group' => 'category',
            'lists' => [
                'view category',
                'create category',
                'edit category',
                'delete category',
            ],
        ],
        [
            'group' => 'category request',
            'lists' => [
                'view category request',
                'create category request',
                'edit category request',
                'delete category request',
            ],
        ],
        [
            'group' => 'category potongan',
            'lists' => [
                'view category potongan',
                'create category potongan',
                'edit category potongan',
                'delete category potongan',
            ],
        ],
        [
            'group' => 'category benefit',
            'lists' => [
                'view category benefit',
                'create category benefit',
                'edit category benefit',
                'delete category benefit',
            ],
        ],
        [
            'group' => 'unit',
            'lists' => [
                'view unit',
                'create unit',
                'edit unit',
                'delete unit',
            ],
        ],
        [
            'group' => 'user',
            'lists' => [
                'view user',
                'create user',
                'edit user',
                'delete user',
            ],
        ],
        [
            'group' => 'supplier',
            'lists' => [
                'view supplier',
                'create supplier',
                'edit supplier',
                'delete supplier',
            ],
        ],
        [
            'group' => 'customer',
            'lists' => [
                'view customer',
                'create customer',
                'edit customer',
                'delete customer',
            ],
        ],
        [
            'group' => 'role',
            'lists' => [
                'view role',
                'create role',
                'edit role',
                'delete role',
            ],
        ],
        [
            'group' => 'request form purchase',
            'lists' => [
                'view request form purchase',
                'create request form purchase',
                'edit request form purchase',
                'delete request form purchase',
                'approve request form purchase',
            ],
        ],
        [
            'group' => 'request form peminjaman',
            'lists' => [
                'view request form peminjaman',
                'create request form peminjaman',
                'edit request form peminjaman',
                'delete request form peminjaman',
            ],
        ],
        [
            'group' => 'invoice',
            'lists' => [
                'view invoice',
                'create invoice',
                'edit invoice',
                'delete invoice',
            ],
        ],
        [
            'group' => 'billing',
            'lists' => [
                'view billing',
                'create billing',
                'edit billing',
                'delete billing',
            ],
        ],
        [
            'group' => 'account group',
            'lists' => [
                'view account group',
                'create account group',
                'edit account group',
                'delete account group',
            ],
        ],
        [
            'group' => 'account header',
            'lists' => [
                'view account header',
                'create account header',
                'edit account header',
                'delete account header',
            ],
        ],
        [
            'group' => 'coa',
            'lists' => [
                'view coa',
                'create coa',
                'edit coa',
                'delete coa',
            ],
        ],
        [
            'group' => 'jurnal umum',
            'lists' => [
                'view jurnal umum',
                'create jurnal umum',
                'edit jurnal umum',
                'delete jurnal umum',
            ],
        ],
        [
            'group' => 'purchase',
            'lists' => [
                'view purchase',
                'create purchase',
                'edit purchase',
                'delete purchase',
                'approve purchase'
            ],
        ],
        [
            'group' => 'sale',
            'lists' => [
                'view sale',
                'create sale',
                'edit sale',
                'delete sale',
            ],
        ],
        [
            'group' => 'spal',
            'lists' => [
                'view spal',
                'create spal',
                'edit spal',
                'delete spal',
            ],
        ],
        [
            'group' => 'item',
            'lists' => [
                'view item',
                'create item',
                'edit item',
                'delete item',
            ],
        ],
        [
            'group' => 'bac terima',
            'lists' => [
                'view bac terima',
                'create bac terima',
                'edit bac terima',
                'delete bac terima',
            ],
        ],
        [
            'group' => 'bac pakai',
            'lists' => [
                'view bac pakai',
                'create bac pakai',
                'edit bac pakai',
                'delete bac pakai',
            ],
        ],
        [
            'group' => 'received',
            'lists' => [
                'view received',
                'create received',
                'edit received',
                'delete received',
            ],
        ],
        [
            'group' => 'aso',
            'lists' => [
                'view aso',
                'create aso',
                'edit aso',
                'delete aso',
            ],
        ],
        [
            'group' => 'potongan',
            'lists' => [
                'view potongan',
                'create potongan',
                'edit potongan',
                'delete potongan',
            ],
        ],
        [
            'group' => 'benefit',
            'lists' => [
                'view benefit',
                'create benefit',
                'edit benefit',
                'delete benefit',
            ],
        ],
        [
            'group' => 'dokumen',
            'lists' => [
                'view dokumen',
                'create dokumen',
                'edit dokumen',
                'delete dokumen',
            ],
        ],
        [
            'group' => 'category dokumen',
            'lists' => [
                'view category dokumen',
                'create category dokumen',
                'edit category dokumen',
                'delete category dokumen',
            ],
        ],
        [
            'group' => 'dokumen hrga',
            'lists' => [
                'view dokumen hrga',
                'create dokumen hrga',
                'edit dokumen hrga',
                'delete dokumen hrga',
            ],
        ],
        [
            'group' => 'buku besar',
            'lists' => [
                'view buku besar',
            ],
        ],
        [
            'group' => 'neraca',
            'lists' => [
                'view neraca',
            ],
        ],
        [
            'group' => 'aplikasi',
            'lists' => [
                'setting aplikasi',
            ],
        ],

    ]
];
