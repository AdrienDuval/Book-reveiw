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
            default => $books->latest()->withAvgRating()->withReviewsCount()
        };

        $books = $books->paginate(5);

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
    public function show(int $id)
    {
        $cachKey = 'book:' . $id;

        $book = cache()->remember(
            $cachKey,
            3600, 
            fn () => Book::with([
                'reviews' => fn ($query) => $query->latest()
            ])->withAvgRating()->withReviewsCount()->findOrFail($id)
        );
        return view('books.show', ['book' => $book]);
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
