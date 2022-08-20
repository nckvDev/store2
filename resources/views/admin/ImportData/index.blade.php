@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">นำเข้าข้อมูล</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="col-xl-12 mb-4">
        <div class="card bg-secondary shadow">
            <div class="card-body">
                <form action="{{route('import-list')}}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="form-group">
                        <lable for="file" name="file">Import Excel</lable>
                        <input type="file" name="file" class="form-control" />
                    </div>
                    <button type="submit" class="btn btn-primary">ยืนยัน</button>
                </form>
                <div class="row">
                    <div class="col-xl-12 mb-4">
                        <div class="card bg-secondary shadow">
                            <div class="card-body">
                                <table id="table_id" class="">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รหัสผู้ใช้งาน</th>
                                            <th>ชื่อ</th>
                                            <th>นามสกุล</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($masterusers as $row)
                                        <tr>
                                            <td>{{ $row->id}}</td>
                                            <td>{{ $row->user_id}}</td>
                                            <td>{{ $row->firstname}}</td>
                                            <td>{{ $row->lastname}}</td>
                                            </form>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(function() {
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sFilterInput": "form-control form-control-sm",
        "sLengthSelect": "form-control form-control-sm"
    });
    $('#table_id').dataTable({
        "language": {
            "search": "ค้นหา ",
            "lengthMenu": "จำนวนข้อมูลที่แสดง _MENU_",
            "zeroRecords": "ไม่พบข้อมูล - ขออภัย",
            "info": "หน้าที่ _PAGE_ ถึง _PAGES_",
            "infoEmpty": "ไม่มีข้อมูล",
            "infoFiltered": "(ค้นหาจาก _MAX_ ข้อมูลทั้งหมด)",
            "paginate": {
                "previous": "ปัจจุบัน",
                "next": "หน้า"
            }
        }
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
</script>

<script src="assets/vendor/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush