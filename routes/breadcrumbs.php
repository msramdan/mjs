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

// Inventory
Breadcrumbs::for('inventory', function (BreadcrumbTrail $trail) {
    $trail->push('Inventory');
});

// Electronic Document
Breadcrumbs::for('electronic_document', function (BreadcrumbTrail $trail) {
    $trail->push('Electronic Document');
});

// Accounting
Breadcrumbs::for('accounting', function (BreadcrumbTrail $trail) {
    $trail->push('Accounting');
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

// Karyawan File
Breadcrumbs::for('berkas_karyawan_index', function (BreadcrumbTrail $trail) {
    $trail->parent('legal');
    $trail->push('Karyawan File');
});

Breadcrumbs::for('berkas_karyawan_create', function (BreadcrumbTrail $trail) {
    $trail->parent('berkas_karyawan_index');
    $trail->push('Create', route('berkas-karyawan.create'));
});

Breadcrumbs::for('berkas_karyawan_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('berkas_karyawan_index');
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


// Spal
Breadcrumbs::for('spal_index', function (BreadcrumbTrail $trail) {
    $trail->parent('legal');
    $trail->push('Spal', route('spal.index'));
});

Breadcrumbs::for('spal_create', function (BreadcrumbTrail $trail) {
    $trail->parent('spal_index');
    $trail->push('Create', route('spal.create'));
});

Breadcrumbs::for('spal_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('spal_index');
    $trail->push('Edit');
});


// Item/Good & Service
Breadcrumbs::for('item_index', function (BreadcrumbTrail $trail) {
    $trail->parent('inventory');
    $trail->push('item', route('item.index'));
});

Breadcrumbs::for('item_create', function (BreadcrumbTrail $trail) {
    $trail->parent('item_index');
    $trail->push('Create', route('item.create'));
});

Breadcrumbs::for('item_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('item_index');
    $trail->push('Edit');
});


// Document
Breadcrumbs::for('document_index', function (BreadcrumbTrail $trail) {
    $trail->parent('electronic_document');
    $trail->push('Document', route('document.index'));
});

Breadcrumbs::for('document_create', function (BreadcrumbTrail $trail) {
    $trail->parent('document_index');
    $trail->push('Create', route('document.create'));
});

Breadcrumbs::for('document_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('document_index');
    $trail->push('Edit');
});


// Category Document
Breadcrumbs::for('category_document_index', function (BreadcrumbTrail $trail) {
    $trail->parent('electronic_document');
    $trail->push('Category Document', route('category-document.index'));
});

Breadcrumbs::for('category_document_create', function (BreadcrumbTrail $trail) {
    $trail->parent('category_document_index');
    $trail->push('Create', route('category-document.create'));
});

Breadcrumbs::for('category_document_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('category_document_index');
    $trail->push('Edit');
});


// Request Form
Breadcrumbs::for('request_form_index', function (BreadcrumbTrail $trail) {
    $trail->push('Request Form', route('request-form.index'));
});

Breadcrumbs::for('request_form_create', function (BreadcrumbTrail $trail) {
    $trail->parent('request_form_index');
    $trail->push('Create', route('request-form.create'));
});

Breadcrumbs::for('request_form_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('request_form_index');
    $trail->push('Edit');
});

Breadcrumbs::for('request_form_show', function (BreadcrumbTrail $trail) {
    $trail->parent('request_form_index');
    $trail->push('Detail');
});


// COA
Breadcrumbs::for('coa_index', function (BreadcrumbTrail $trail) {
    $trail->parent('accounting');
    $trail->push('COA', route('coa.index'));
});

Breadcrumbs::for('coa_create', function (BreadcrumbTrail $trail) {
    $trail->parent('coa_index');
    $trail->push('Create', route('coa.create'));
});

Breadcrumbs::for('coa_edit', function (BreadcrumbTrail $trail) {
    $trail->parent('coa_index');
    $trail->push('Edit');
});

Breadcrumbs::for('coa_show', function (BreadcrumbTrail $trail) {
    $trail->parent('coa_index');
    $trail->push('Detail');
});
