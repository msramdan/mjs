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
