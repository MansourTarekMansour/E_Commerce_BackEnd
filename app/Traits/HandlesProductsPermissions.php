<?php

namespace App\Traits;

trait HandlesProductsPermissions
{
    protected function setupProductsPermissions()
    {
        $this->middleware('permission:products-list|products-create|products-edit|products-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:products-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:products-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:products-delete', ['only' => ['destroy']]);
    }
}
