@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <a href="{{ route('books.index') }}" class="flex mb-4 text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">Back</a>
        <h1 class="sticky top-0 mb-2 text-2xl">{{ $book->title }}</h1>

        <div class="book-info">
            <div class="book-author mb-4 text-lg font-semibold">by {{ $book->author }}</div>
            <div class="book-rating flex items-center">
                <div class="mr-2 text-sm font-medium text-slate-700">
                    {{ number_format($book->reviews_avg_rating, 1) }}
                    <x-star-rating :rating="$book->reviews_avg_rating" />
                </div>
                <span class="book-review-count text-sm text-gray-500">
                    {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                </span>
            </div>
        </div>
    </div>
<div class="mb-4">
    <a href="{{ route('books.reviews.create', $book) }}" class="btn btn-primary">Add a Review!</a>
</div>
    <div>
        <h2 class="mb-4 text-xl font-semibold">Reviews</h2>
        <ul>
            @forelse ($book->reviews as $review)
                <li class="book-item mb-4"> 
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            {{-- <div class="font-semibold">{{ $review->rating }}</div> --}}
                            <x-star-rating :rating="$book->reviews_avg_rating" />
                            <div class="book-review-count">
                                {{ $review->created_at->format('M j, Y') }}</div>
                        </div>
                        <p class="text-gray-700">{{ $review->review }}</p>
                    </div>
                </li>
            @empty
                <li class="mb-4">
                    <div class="empty-book-item">
                        <p class="empty-text text-lg font-semibold">No reviews yet</p>
                    </div>
                </li>
            @endforelse
        </ul>
    </div>
@endsection
