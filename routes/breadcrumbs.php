<?php // routes/breadcrumbs.php

use Diglactic\Breadcrumbs\Breadcrumbs;

use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Supplier
Breadcrumbs::for('supplier_index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
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
