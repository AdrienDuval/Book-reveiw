<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = $request->input('title');
        $filter = $request->input('filter', "");

        $books = book::When(
            $title,
            fn ($query, $title) => $query->title($title)
        );

        $books = match ($filter) {
            'Popular_last_month' => $books->popularLastMonth(),
            'Popular_last_6months' => $books->popular6LastMonth(),
            'Highest_rated_last_month' => $books->highestRatedLastMonth(),
            'Highest_rated_last_6months' => $books->highestRatedLast6Month(),
            default => $books->latest()
        };

        $books = $books->get();

        return view('books.index', ["books" => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return view('books.show', [
            'book' => $book->load([
                'reviews' => fn ($query) => $query->latest()
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
