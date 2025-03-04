@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sửa Sản Phẩm</h1>
    <form action="{{ route('seller.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên Sản Phẩm</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Mô Tả</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="price">Giá</label>
            <input type="number" name="price" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
            @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Hình Ảnh</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Hình ảnh sản phẩm" width="100" class="mt-2">
            @endif
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cập Nhật Sản Phẩm</button>
    </form>
</div>
@endsection
