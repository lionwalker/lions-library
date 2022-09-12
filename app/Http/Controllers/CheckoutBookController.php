<?php

namespace App\Http\Controllers;

use App\Models\Book;

class CheckoutBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Book $book
     */
    public function store(Book $book)
    {
        $book->checkout(auth()->user());
    }
}
