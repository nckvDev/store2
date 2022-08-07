@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container">
    <div class="card">
        <div class="card-body">
            <form action="{{route('product.store')}}" method="post">
                @csrf
                <label for="name">ชื่อสินค้า</label>
                <input type="text" name="name" id="name" class="form-control">
                <label for="price">ราคา</label>
                <input type="number" name="price" id="price" class="form-control">
                <div class="mt-2">
                    <a href="{{route('product.index')}}" class="btn btn-secondary">ย้อนกลับ</a>
                    <button class="btn btn-primary">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection