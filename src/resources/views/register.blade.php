@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="form-container">
    <div class="form-card">
        <h1>商品登録</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">商品名 <span class="required">必須</span></label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
                <div class="form__error">
                @error('name')
                    <ul class="error-messages">
                        @foreach ($errors->get('name') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="price">値段 <span class="required">必須</span></label>
                <input type="text" id="price" name="price" value="{{ old('price') }}" placeholder="値段を入力">
                <div class="form__error">
                @error('price')
                    <ul class="error-messages">
                        @foreach ($errors->get('price') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @enderror
                </div>
            </div>

            <div class="form-group">
                <label>商品画像 <span class="required">必須</span></label>
                <div id="image-preview" class="image-preview" style="display: none;"></div>
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" accept="image/*">
                        <label for="image" class="file-label">ファイルを選択</label>
                        <span id="file-name-display" class="file-name-display"></span>
                    </div>
                <div class="form__error">
                @error('image')
                    <ul class="error-messages">
                        @foreach ($errors->get('image') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @enderror
                </div>
            </div>

            <div class="form-group">
                <label>季節 <span class="required">必須</span><span class="any">複数選択可</span></label>
                <div class="checkbox-group">
                @foreach($seasons as $season)
                <label>
                <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                    {{ is_array(old('seasons')) && in_array($season->id, old('seasons')) ? 'checked' : '' }}>
                    {{ $season->name }}
                </label>
                @endforeach
                </div>
                <div class="form__error">
                @error('seasons')
                    <ul class="error-messages">
                        @foreach ($errors->get('seasons') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">商品説明 <span class="required">必須</span></label>
                <textarea id="description" name="description" rows="5" placeholder="商品説明を入力">{{ old('description') }}</textarea>
                <div class="form__error">
                @error('description')
                    <ul class="error-messages">
                        @foreach ($errors->get('description') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>

                @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
                <button type="submit" class="btn btn-primary">登録</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('image-preview');
        const fileNameDisplay = document.getElementById('file-name-display');
        const files = event.target.files;
        previewContainer.innerHTML = '';
        fileNameDisplay.textContent = '';
        previewContainer.style.display = 'none';
        
        if (files && files[0]) {
            const file = files[0];
            fileNameDisplay.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = '商品画像プレビュー';
                img.classList.add('preview-image');
                previewContainer.appendChild(img);
                previewContainer.style.display = 'flex';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection