@extends('base')
@section('content')
    @include('includes.nav')
    <div class="custom-form m-auto mt-5">
        <form action="{{ route('item.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h4 class="text-center mb-2">تعديل الكتاب</h4>
            <div class="mb-2">
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <label for="title" class="form-label">عنوان الكتاب</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $item->title }}"
                    autocomplete="off">
                @if ($errors->has('title'))
                    <span class="text-danger text-direction-rtl">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="mb-2">
                <label for="description" class="form-label">وصف الكتاب</label>
                <textarea class="form-control" id="description" name="description"> {{ $item->description }}</textarea>
                @if ($errors->has('description'))
                    <span class="text-danger text-direction-rtl">{{ $errors->first('description') }}</span>
                @endif
            </div>
            <div class="mb-2">
                @isset($categories)
                    @if (count($categories) > 0)
                        <label for="">اختر التصنيف</label>
                        <select class="form-control mt-2 " name="cat_id" id="edit_cat_id">
                            <option value="{{ $item->category->id }}">{{ $item->category->name }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('cat_id'))
                            <span class="text-danger text-direction-rtl">{{ $errors->first('cat_id') }}</span>
                        @endif
                    @endif
                @endisset
            </div>
            <div class="mb-2" id="sub_cat"
                style="display: @isset($item->subCategory->id) block @else none @endisset">
                <label for="edit_sub_cat_id" class="form-label">اختر تصنيف فرعي</label>
                <select class="form-control" id="edit_sub_cat_id" name="sub_cat_id">
                    @if ($item->subCategory)
                        <option value="{{ $item->subCategory->id }}">{{ $item->subCategory->name }}</option>
                    @endif
                </select>
                @if ($errors->has('sub_cat_id'))
                    <span class="text-danger text-direction-rtl">{{ $errors->first('sub_cat_id') }}</span>
                @endif
            </div>
            <div class="mb-2">
                <label for="date" class="form-label">التاريخ</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ $item->date }}"
                    autocomplete="off">
                @if ($errors->has('date'))
                    <span class="text-danger text-direction-rtl">{{ $errors->first('date') }}</span>
                @endif
            </div>
            <div class="mb-2">
                <label for="formUpdateFile" class="form-label d-block ctm-btn p-1 mt-3 rounded-3">
                    <img src="{{ asset('imgs/upload_file.svg') }}" alt="">
                    <span>اضغط هنا لإختيار الملف</span>
                </label>
                <input class="form-control d-none" type="file" id="formUpdateFile" name="file">
            </div>
            @if ($errors->has('file'))
                <span class="text-danger text-direction-rtl">{{ $errors->first('file') }}</span>
            @endif
            <div class="text-center mt-3">
                <button type="submit" class="btn ctm-btn">حفظ</button>
            </div>
        </form>
    </div>
    <script>
        edit_cat_id.onchange = async function() {
            let data = await fetch(`{{ url('sub_categories/${this.value}') }}`);
            data = await data.json();
            if (data.length) {
                sub_cat.style.display = 'block';
                edit_sub_cat_id.innerHTML = `<option value=''></option>`
                data.forEach(item => edit_sub_cat_id.innerHTML +=
                    `<option value='${item.id}'>${item.name}</option>`);
            } else {
                edit_sub_cat_id.innerHTML = '';
                sub_cat.style.display = 'none';
            }
        }
    </script>
@endsection
