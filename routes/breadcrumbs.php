<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Master Data
Breadcrumbs::for('master_data', function (BreadcrumbTrail $trail) {
    $trail->push('Master Data');
});

// Contact
Breadcrumbs::for('contact', function (BreadcrumbTrail $trail) {
    $trail->push('Contact');
});

// Legal
Breadcrumbs::for('legal', function (BreadcrumbTrail $trail) {
    $trail->push('HR-Legal');
});

// setting
Breadcrumbs::for('setting', function (BreadcrumbTrail $trail) {
    $trail->push('Setting');
});


// Supplier
Breadcrumbs::for('supplier_index', function (BreadcrumbTrail $trail) {
    $trail->parent('contact');
    $trail->push('Supplier', route('supplier.index'));
});

Breadcrumbs::for('supplier_create', function (BreadcrumbTrail $trail) {
    $trail->parent('supplier_index');
    $trail->push('Create', route('supplier.create'));
});

Breadcrumbs::for('supplier_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('supplier_index');
    $trail->push('Edit');
});

// Customer
Breadcrumbs::for('customer_index', function (BreadcrumbTrail $trail) {
    $trail->parent('contact');
    $trail->push('Customer', route('customer.index'));
});

Breadcrumbs::for('customer_create', function (BreadcrumbTrail $trail) {
    $trail->parent('customer_index');
    $trail->push('Create', route('customer.create'));
});

Breadcrumbs::for('customer_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('customer_index');
    $trail->push('Edit');
});


// Category
Breadcrumbs::for('category_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Category', route('category.index'));
});

Breadcrumbs::for('category_create', function (BreadcrumbTrail $trail) {
    $trail->parent('category_index');
    $trail->push('Create', route('category.create'));
});

Breadcrumbs::for('category_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('category_index');
    $trail->push('Edit');
});

// Category Request
Breadcrumbs::for('category_request_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Category Request', route('category-request.index'));
});

Breadcrumbs::for('category_request_create', function (BreadcrumbTrail $trail) {
    $trail->parent('category_request_index');
    $trail->push('Create', route('category-request.create'));
});

Breadcrumbs::for('category_request_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('category_request_index');
    $trail->push('Edit');
});

// Category Potongan
Breadcrumbs::for('category_potongan_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Category Potongan', route('category-potongan.index'));
});

Breadcrumbs::for('category_potongan_create', function (BreadcrumbTrail $trail) {
    $trail->parent('category_potongan_index');
    $trail->push('Create', route('category-potongan.create'));
});

Breadcrumbs::for('category_potongan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('category_potongan_index');
    $trail->push('Edit');
});

// Category Benefit
Breadcrumbs::for('category_benefit_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Category Benefit', route('category-benefit.index'));
});

Breadcrumbs::for('category_benefit_create', function (BreadcrumbTrail $trail) {
    $trail->parent('category_benefit_index');
    $trail->push('Create', route('category-benefit.create'));
});

Breadcrumbs::for('category_benefit_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('category_benefit_index');
    $trail->push('Edit');
});


// Unit
Breadcrumbs::for('unit_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Unit', route('unit.index'));
});

Breadcrumbs::for('unit_create', function (BreadcrumbTrail $trail) {
    $trail->parent('unit_index');
    $trail->push('Create', route('unit.create'));
});

Breadcrumbs::for('unit_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('unit_index');
    $trail->push('Edit');
});

// Lokasi
Breadcrumbs::for('lokasi_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Lokasi', route('lokasi.index'));
});

Breadcrumbs::for('lokasi_create', function (BreadcrumbTrail $trail) {
    $trail->parent('lokasi_index');
    $trail->push('Create', route('lokasi.create'));
});

Breadcrumbs::for('lokasi_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('lokasi_index');
    $trail->push('Edit');
});


// Jabatan
Breadcrumbs::for('jabatan_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Jabatan', route('jabatan.index'));
});

Breadcrumbs::for('jabatan_create', function (BreadcrumbTrail $trail) {
    $trail->parent('jabatan_index');
    $trail->push('Create', route('jabatan.create'));
});

Breadcrumbs::for('jabatan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('jabatan_index');
    $trail->push('Edit');
});

// Status Karyawan
Breadcrumbs::for('status_karyawan_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Status Karyawan', route('status-karyawan.index'));
});

Breadcrumbs::for('status_karyawan_create', function (BreadcrumbTrail $trail) {
    $trail->parent('status_karyawan_index');
    $trail->push('Create', route('status-karyawan.create'));
});

Breadcrumbs::for('status_karyawan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('status_karyawan_index');
    $trail->push('Edit');
});

// Divisi
Breadcrumbs::for('divisi_index', function (BreadcrumbTrail $trail) {
    $trail->parent('master_data');
    $trail->push('Divisi', route('status-karyawan.index'));
});

Breadcrumbs::for('divisi_create', function (BreadcrumbTrail $trail) {
    $trail->parent('divisi_index');
    $trail->push('Create', route('status-karyawan.create'));
});

Breadcrumbs::for('divisi_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('divisi_index');
    $trail->push('Edit');
});


// karyawan
Breadcrumbs::for('karyawan_index', function (BreadcrumbTrail $trail) {
    $trail->parent('legal');
    $trail->push('Karyawan', route('karyawan.index'));
});

Breadcrumbs::for('karyawan_create', function (BreadcrumbTrail $trail) {
    $trail->parent('karyawan_index');
    $trail->push('Create', route('karyawan.create'));
});

Breadcrumbs::for('karyawan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('karyawan_index');
    $trail->push('Edit');
});


// Profile
Breadcrumbs::for('profile_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Profile', route('profile.index'));
});


// Role
Breadcrumbs::for('role_index', function (BreadcrumbTrail $trail) {
    $trail->parent('setting');
    $trail->push('Role', route('role.index'));
});

Breadcrumbs::for('role_create', function (BreadcrumbTrail $trail) {
    $trail->parent('role_index');
    $trail->push('Create', route('role.create'));
});

Breadcrumbs::for('role_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('role_index');
    $trail->push('Edit');
});

// Permission
Breadcrumbs::for('permission_index', function (BreadcrumbTrail $trail) {
    $trail->parent('setting');
    $trail->push('Permission', route('permission.index'));
});

Breadcrumbs::for('permission_create', function (BreadcrumbTrail $trail) {
    $trail->parent('permission_index');
    $trail->push('Create', route('permission.create'));
});

Breadcrumbs::for('permission_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('permission_index');
    $trail->push('Edit');
});

// User
Breadcrumbs::for('user_index', function (BreadcrumbTrail $trail) {
    $trail->parent('setting');
    $trail->push('User', route('user.index'));
});

Breadcrumbs::for('user_create', function (BreadcrumbTrail $trail) {
    $trail->parent('user_index');
    $trail->push('Create', route('user.create'));
});

Breadcrumbs::for('user_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('user_index');
    $trail->push('Edit');
});
