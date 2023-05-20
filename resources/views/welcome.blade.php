@extends('base')
@section('css')
    <style>
        swiper-container {
            width: 100%;
            height: fit-content;
            margin: 20px;
        }
    </style>
@endsection
@section('content')
    @include('includes.nav')
    <div class="container mt-3" id="swipers">
        {{ $empty = false }}
        @foreach ($categories as $category)
            @if ($category->items->count() > 5)
                {{ $empty = true }}
                <h4 class="pe-5">{{ $category->name }}</h4>
                <swiper-container class="mySwiper" space-between="20" slides-per-view="5">
                    @foreach ($category->items as $item)
                        <swiper-slide>
                            <div class="card book mb-2 me-2">
                                @if ($user->id == $item->user_id || in_array($user->role, ['super-admin', 'admin']))
                                    <div class="links text-start">
                                        <a class="text-secondary" href="{{ route('items.edit', $item->id) }}"
                                            class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a class="text-secondary delete-btn" href="{{ route('item.delete', $item->id) }}"
                                            class="delete-btn"><i class="fa-solid fa-trash"></i></a>
                                    </div>
                                @endif
                                <div class="book-img bg-dark text-center">
                                    <img src="{{ asset('imgs/menu_book.svg') }}" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body .bg-light">
                                    <h5 class="card-title">{{ $item->title }}</h5>
                                    <p class="card-text">{{ $item->description }} </p>
                                    <a href="{{ $item->file }}" class="btn ctm-btn">فتح الكتاب</a>
                                </div>
                            </div>
                        </swiper-slide>
                    @endforeach
                </swiper-container>
            @endif
        @endforeach
        @if (!$empty)
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img class="empty-box" id="emptyBox" src="{{ asset('imgs/box.png') }}" alt="">
                <h4 class="mt-3">لا يوجد ما يعرض هنا</h4>
            </div>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/swiper.min.js') }}"></script>
    <script>
        let screens = {
            1200: [5, 1050],
            1050: [4, 900],
            900: [3, 700],
            700: [2, 450],
            500: [1, 0],
        }

        function fixSwiper() {
            for (screen in screens) {
                if (swipers.clientWidth < screen && swipers.clientWidth > screens[screen][1])
                    swipers.querySelectorAll('swiper-container').forEach(el => {
                        el.setAttribute('slides-per-view', screens[screen][0]);
                    });
            }
        }
        window.onload = fixSwiper;
        window.onresize = fixSwiper;

        if (!swipers.querySelectorAll('swiper-container').length) {
            emptyBox.style.display = 'block'
        }

        $('.delete-btn').on('click', function(e) {
            let result = confirm('هل انت متأكد من حذف هذا الكتاب');
            if (!result) e.preventDefault();
        })
    </script>
@endsection
