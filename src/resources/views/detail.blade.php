@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=delete" />

@endsection

@section('content')
<div class="form-container">
    <div class="form-card">
        <div class="breadcrumb">
            <a href="{{ route('products.index') }}">商品一覧</a> > {{ $product->name }}
        </div>

        <form action="{{ route('products.update', ['productId' => $product->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-main-content">
                <div class="image-area">
                    <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="file-input-wrapper">
                        <input type="file" id="image" name="image" accept="image/*" style="display:none;">
                        <label for="image" class="file-label">ファイルを選択</label>
                        <span id="file-name-display">{{ $product->image }}</span>
                    </div>
                    @if ($errors->has('image'))
                        @foreach ($errors->get('image') as $message)
                            <div class="error">{{ $message }}</div>
                        @endforeach
                    @endif
                </div>

                <div class="form-fields-area">
                    <div class="form-group">
                        <label for="name">商品名</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}">
                        @if ($errors->has('name'))
                            @foreach ($errors->get('name') as $message)
                                <div class="error">{{ $message }}</div>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="price">値段</label>
                        <input type="text" id="price" name="price" value="{{ old('price', $product->price) }}">
                        @if ($errors->has('price'))
                            @foreach ($errors->get('price') as $message)
                                <div class="error">{{ $message }}</div>
                            @endforeach
                        @endif
                    </div>

                    <div class="form-group">
                        <label>季節</label>
                        <div class="checkbox-group">
                            @foreach($seasons as $season)
                                <label>
                                    <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                        {{ (is_array(old('seasons')) && in_array($season->id, old('seasons'))) || (empty(old('seasons')) && $product->seasons->contains($season->id)) ? 'checked' : '' }}>
                                    {{ $season->name }}
                                </label>
                            @endforeach
                        </div>
                        @if ($errors->has('seasons'))
                            @foreach ($errors->get('seasons') as $message)
                                <div class="error">{{ $message }}</div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">商品説明</label>
                <textarea id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                @if($errors->has('description'))
                    @foreach ($errors->get('description') as $message)
                        <div class="error">{{ $message }}</div>
                    @endforeach
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
                <button type="submit" class="btn btn-primary">変更を保存</button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('products.destroy', ['productId' => $product->id]) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete" onclick="return confirm('本当に削除しますか？')">
                <span class="material-symbols-outlined">delete</span>
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById('image-preview');
        const fileNameDisplay = document.getElementById('file-name-display');

        if (file) {
            fileNameDisplay.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection