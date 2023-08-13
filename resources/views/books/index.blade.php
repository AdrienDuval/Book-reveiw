@extends('Layouts.app')

@section('content')
    <h1 class="mb-10 text-2xl font-bold text-gray-900 dark:text-white">Books</h1>
    <form method="GET" action="{{ route('books.index') }}" class="mb-4 flex items-center space-x-2">
        <input type="text" class="input h-10" name="title" placeholder="Search by book title"
            value="{{ request('title') }}">
            <input type="hidden" name="filter" value="{{ request('filter') }}">
        <button class="btn h-10">Search</button>
        <a href="{{ route('books.index') }}" class="btn btn-ghost h-10">Clear</a>
    </form>
    <div class="filter-container mb-4 flex">
        @php
            $filters = [
                '' => 'latest',
                'Popular_last_month' => 'popular Last Month',
                'Popular_last_6months' => 'popular Last 6 Months',
                'Highest_rated_last_month' => 'Highest Rated Last Month',
                'Highest_rated_last_6months' => 'Highest Rated Last 6 Months',
            ];
        @endphp

        @foreach ($filters as $key => $label)
        <a href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}" class="{{ request('filter') === $key || (request('filter') === null && $key === '')  ? 'filter-item-active' : 'filter-item' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>
    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a href="{{ route('books.index', $book) }}" class="book-title">{{ $book->title }}</a>
                            <span class="book-author">By {{ $book->author }}</span>
                        </div>
                        <div>
                            <div class="book-rating">
                                {{ number_format($book->reviews_avg_rating, 1) }}
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }} {{ Str::plural('review', $book->reviews_count) }}
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a href="{{ route('books.index') }}" class="reset-link">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
