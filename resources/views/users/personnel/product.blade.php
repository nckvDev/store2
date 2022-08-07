@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <a href="{{route('product.create')}}" class="btn btn-primary">เพิ่มข้อมูล</a>
            </div>
        </div>
        <div class="card-body">
            <table id="myTable">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อ</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(function() {
    $('#myTable').dataTable({
        ajax: "{{route('product.index')}}",
        columns: [{
                data: 'DT_RowIndex'
            },
            {
                data: 'name'
            },
        ]
    });
});
</script>
@endpush