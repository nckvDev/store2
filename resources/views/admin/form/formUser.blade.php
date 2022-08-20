@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">ยืนยันแบบฟอร์ม</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-body">
                    <table id="table_id" class="">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อผู้ใช้งาน</th>
                                <th>วันที่</th>
                                <th>อนุมัติ</th>
                                <th>รายละเอียดการยืม-เบิก</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>เสธปอน</td>
                                <td>xx</td>
                                <td>
                                    <label class="custom-toggle">
                                        <input type="checkbox" id="chkToggle">
                                        <span class="custom-toggle-slider rounded-circle"></span>
                                    </label>
                                </td>
                                <td>
                                    <a href="{{route('form-detail')}}" class="btn btn-primary">ตรวจสอบข้อมูล</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

    function submitToggle() {
        // checkbox.checked = false;
    }
    </script>


    <script src="assets/vendor/select2/dist/js/select2.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    @endpush