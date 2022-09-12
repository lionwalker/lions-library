<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CheckinBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Book $book
     */
    public function store(Book $book)
    {
        try {
            $book->checkin(auth()->user());
        } catch (\Exception $e) {
            return response([], 404);
        }
    }
}
