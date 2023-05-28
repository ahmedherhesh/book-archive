<nav class="navbar navbar-expand-lg bg-body-tertiary navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}"><img
                src="{{ asset('imgs/home_app_logo.svg') }}" alt=""><span>الصفحة الرئيسية</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('items.index') }}">
                        <img src="{{ asset('imgs/menu_book.svg') }}" alt=""> <span>جميع الكتب </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">
                        <img src="{{ asset('imgs/category.svg') }}" alt=""><span>الأقسام</span>
                    </a>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link modal-btn" data-bs-toggle="modal"
                        data-bs-target="#createCategoryModal">
                        <img src="{{ asset('imgs/library_add.svg') }}" alt=""><span>إضافة قسم</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link modal-btn" data-bs-toggle="modal"
                        data-bs-target="#createItemModal">
                        <img src="{{ asset('imgs/upload_file.svg') }}" alt=""><span>إضافة كتاب</span>
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link modal-btn" data-bs-toggle="modal"
                        data-bs-target="#seacrhModal">
                        <img src="{{ asset('imgs/quick_reference_all.svg') }}" alt=""><span>بحث</span>
                    </button>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('imgs/manage_accounts.svg') }}" alt="">
                        </a>
                        <ul class="dropdown-menu text-center" style="width:fit-content;">
                            <li><a class="dropdown-item d-inline-block" href="#">{{ $user->name }}</a></li>
                            @if ($user->role == 'admin')
                                <li><a class="dropdown-item d-inline-block" href="{{ url('register') }}">اضافة
                                        مستخدم</a></li>
                            @endif
                            <li><a class="dropdown-item d-inline-block" href="{{ url('change-password') }}">تغيير كلمة
                                    السر</a></li>
                            <li><a class="dropdown-item d-inline-block" href="{{ route('logout') }}">تسجيل خروج</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

@include('includes.modals.search-modal')
@include('includes.modals.create-category-modal')
@include('includes.modals.create-item-modal')

@if (session()->has('success'))
    <p class="alert alert-success ctm-alert fade-out text-center">{{ session()->get('success') }}</p>
@endif

@section('jquery')
    <script>
        $('.alert-success').fadeOut(3000)
    </script>
@endsection
