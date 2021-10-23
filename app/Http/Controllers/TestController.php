<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepositoryInterface;

class TestController extends Controller
{
    private $PostRepo;
    public function __construct(ProductRepositoryInterface $PostRepo)
    {
        $this->PostRepo = $PostRepo;
    }

    public function index()
    {
        dd($this->PostRepo->getAll());
    }
}
