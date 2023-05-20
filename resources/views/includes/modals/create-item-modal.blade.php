<div class="modal fade mt-5" id="createItemModal" tabindex="-1" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h4 class="text-center mb-2">إضافة كتاب</h4>
                    <div class="mb-2">
                        <label for="title" class="form-label">عنوان الكتاب</label>
                        <input type="text" class="form-control" id="title" name="title" autocomplete="off">
                        @if ($errors->has('title'))
                            <span class="text-danger text-direction-rtl">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="description" class="form-label">وصف الكتاب</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger text-direction-rtl">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="mb-2">
                        @isset($categories)
                            @if (count($categories) > 0)
                                <label for="">اختر القسم</label>
                                <select class="form-control mt-2" name="cat_id" id="cat_id">
                                    <option value=""></option>
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
                    <div class="mb-2 sub-cats">
                        <label for="sub_cat_id" class="form-label">اختر قسم فرعي</label>
                        <select class="form-control" id="sub_cat_id" name="sub_cat_id" id="sub_cat_id"></select>
                        @if ($errors->has('sub_cat_id'))
                            <span class="text-danger text-direction-rtl">{{ $errors->first('sub_cat_id') }}</span>
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="date" class="form-label">التاريخ</label>
                        <input type="date" class="form-control" id="date" name="date" autocomplete="off">
                        @if ($errors->has('date'))
                            <span class="text-danger text-direction-rtl">{{ $errors->first('date') }}</span>
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="formFile" class="form-label d-block ctm-btn p-1 mt-3 rounded-3">
                            <img src="{{ asset('imgs/upload_file.svg') }}" alt="">
                            <span>اضغط هنا لإختيار الملف</span>
                        </label>
                        <input class="form-control d-none" type="file" id="formFile" name="file">
                    </div>
                    @if ($errors->has('file'))
                        <span class="text-danger text-direction-rtl">{{ $errors->first('file') }}</span>
                    @endif

                    <div class="text-center mt-3">
                        <button type="submit" class="btn ctm-btn">إضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    cat_id.onchange = async function() {
        let data = await fetch(`{{ url('sub_categories/${this.value}') }}`);
        let sub_cats = document.querySelector('.sub-cats');
        data = await data.json();
        if (data.length) {
            sub_cats.style.display = 'block';
            sub_cat_id.innerHTML = `<option value=''></option>`
            data.forEach(item => sub_cat_id.innerHTML += `<option value='${item.id}'>${item.name}</option>`);
        } else {
            sub_cat_id.innerHTML = '';
            sub_cats.style.display = 'none';
        }
    }
</script>
