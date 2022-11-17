@extends('layouts.app', ['class' => 'bg-neutral'])
@inject('thaiDateHelper', 'App\Services\ThaiDateFormat')
@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">ตรวจสอบสถานะอนุมัติ</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <table id="table_id" class="">
                            <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>รหัสผู้ใช้งาน</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>วันที่คืน</th>
                                <th>สถานะ</th>
                                <th>อนุมัติ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($conforms as $row)
                                <tr>
                                    <td>{{ $row->id}}</td>
                                    <td>{{ $row->borrow_user->user_id}}</td>
                                    <td>{{ $row->borrow_user->firstname}}</td>
                                    <td>{{ $row->borrow_user->lastname}}</td>
                                    <td>
                                        {{ $thaiDateHelper->DateFormat($row->created_at) }}
                                    </td>
                                    @if($row->borrow_status=="2")
                                        <td class="align-middle text-sm">
                                            <span class="badge text-white bg-gradient-success">อนุมัติ</span>
                                        </td>
                                    @else
                                        <td class="align-middle text-sm">
                                            <span class="badge text-white bg-gradient-warning">พร้อมใช้งาน</span>
                                        </td>
                                    @endif

                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#Modal{{($row->id)}}">
                                            รายละเอียด
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="Modal{{($row->id)}}" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel"> รายการยืม </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-2">
                                                            <div class="col-lg-6"> วันที่ยืม</div>
                                                            <div class="col-lg-6"> วันที่คืน</div>
                                                        </div>
                                                        <div class="mb-4 flex-row justify-content-between">
                                                            <span class="text-gray">
                                                                  {{ $thaiDateHelper->DateThaiFormat($row->started_at) }}
                                                            </span>
                                                            -
                                                            <span class="text-danger">
                                                                 {{ $thaiDateHelper->DateThaiFormat($row->end_at) }}
                                                            </span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                @foreach($row->borrow_list_id as $item)
                                                                    <div class="mb-2 text-primary"> {{ $item }} </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="col-lg-4">
                                                                @if(isset($row->borrow_name))
                                                                    @foreach($row->borrow_name as $name)
                                                                        <div class="mb-2"> {{ $name }} </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="mb-2"> NULL </div>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-4">
                                                                @foreach($row->borrow_amount as $amount)
                                                                    <div class="mb-2"> {{ $amount }} </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
                $(function () {
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
                    $('[type=search]').each(function () {
                        +
                            $(this).attr("placeholder", "Search...");
                        $(this).before('<span class="fa fa-search"></span>');
                    });
                    $('#button').click(function () {
                        alert(table.rows('.selected').data().length + ' row(s) selected');
                    });
                });
            </script>


            <script src="assets/vendor/select2/dist/js/select2.min.js"></script>
            <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
            <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
            <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    @endpush
