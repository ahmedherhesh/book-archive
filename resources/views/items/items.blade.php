@extends('base')
@section('content')
    @include('includes.nav')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center mt-3">
            @foreach ($items as $item)
                <div class="card book mb-2 me-2">
                    @if ($user->id == $item->user_id || in_array($user->role, ['super-admin', 'admin']))
                        <div class="links text-start">
                            <a class="text-secondary" href="{{ route('items.edit', $item->id) }}" class="edit-btn"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <a class="text-secondary delete-btn" data-type="الكتاب"
                                href="{{ route('item.delete', $item->id) }}" class="delete-btn"><i
                                    class="fa-solid fa-trash"></i></a>
                        </div>
                    @endif
                    <div class="book-img bg-dark text-center">
                        <img src="{{ asset('imgs/menu_book.svg') }}" class="card-img-top" alt="...">
                    </div>
                    <div class="card-body .bg-light">
                        <h5 class="card-title">{{ $item->title }} </h5>
                        <p class="card-text">{{ $item->description }}</p>
                        <a href="{{ $item->file }}" class="btn ctm-btn">فتح الكتاب</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5 d-flex justify-content-center">
            {{ $items->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
@endsection
