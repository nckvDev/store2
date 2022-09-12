@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h3 class="mb-0">รายงานข้อมูล</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-body">
                    <table id="table_id" class="">
                        <thead>
                            <tr>
                                <th style="width:50%">หัวข้อ</th>
                                <th style="width:50%">ข้อมูล</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>รายงานข้อมูลรายวัน</td>
                                <td>
                                    <form action="{{route('report-days')}}" enctype="multipart/form-data" method="get">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">เลือก</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>รายงานข้อมูลรายเดือน</td>
                                <td>
                                    <form action="{{route('report-months')}}" enctype="multipart/form-data"
                                        method="get">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">เลือก</button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>รายงานข้อมูลรายภาคเรียน</td>
                                <td>
                                    <form action="{{route('report-terms')}}" enctype="multipart/form-data" method="get">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">เลือก</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(function() {
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control form-control-sm",
        "sLengthSelect": "form-control form-control-sm"
    });
    $('#table_id').dataTable({
        "responsive": true,
        "searching": false,
        "lengthChange": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
    });
    $('[type=search]').each(function() {
        +
        $(this).attr("placeholder", "Search...");
        $(this).before('<span class="fa fa-search"></span>');
    });
    $('#button').click(function() {
        alert(table.rows('.selected').data().length + ' row(s) selected');
    });
});

$('.delete-confirm').on('click', function(event) {
    event.preventDefault();
    const url = $(this).attr('href');
    Swal.fire({
        title: 'คุณแน่ใจ?',
        text: "คุณต้องการลบข้อมูลนี้หรือไม่!",
        icon: 'warning',
        focusCancel: true,
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'ลบข้อมูลเรียบร้อย',
                showConfirmButton: false,
                timer: 1500
            })
        }
    });
});
</script>
<script src="{{ asset('js/app.js') }}"></script>
@endpush