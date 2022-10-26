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
                                <th>รหัสผู้ใช้งาน</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th>วันที่ยืม</th>
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
                                        {{\Carbon\Carbon::parse($row->started_at)->locale('th')->isoFormat('L - LT')}}
                                    </td>
                                    @if($row->borrow_status=="2")
                                        <td class="align-middle text-sm">
                                            <span class="badge text-white bg-gradient-success">อนุมัติ</span>
                                        </td>
                                    @endif
                                    @if($row->borrow_status=="1")
                                        <td class="align-middle text-sm">
                                            <span class="badge text-white bg-gradient-warning">รออนุมัติ</span>
                                        </td>
                                    @endif
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                                data-target="#Modal{{($row->id)}}">
                                            จัดการสถานะ
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="Modal{{($row->id)}}" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="exampleModalLabel">รายการยืม</h3>
                                                        <button class="close" data-dismiss="modal"
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
                                                                {{
                                                                    \Carbon\Carbon::parse($row->started_at)->locale('th')->isoFormat('LLL')
                                                                }}
                                                            </span>
                                                            -
                                                            <span class="text-danger">
                                                                {{
                                                                    \Carbon\Carbon::parse($row->end_at)->locale('th')->isoFormat('LLL')
                                                                }}
                                                            </span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                @foreach($row->borrow_list_id as $id)
                                                                    <div class="mb-2 text-primary"> {{ $id }} </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="col-lg-4">
                                                                @if(isset($row->borrow_name))
                                                                    @foreach($row->borrow_name as $name)
                                                                        <div class="mb-2"> {{ $name }} </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="mb-2"> NULL</div>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-4">
                                                                @foreach($row->borrow_amount as $amount)
                                                                    <div class="mb-2"> {{ $amount }} </div>
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ url('/confirmform/update/'.$row->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @foreach($row->borrow_list_id as $item)
                                                                <input type="hidden" name="borrow_list_id[]"
                                                                       value="{{ $item }}">
                                                            @endforeach
                                                            <input type="hidden" name="borrow_status" value="2">
                                                            <button class="btn btn-primary btn-sm">อนุมัติ
                                                            </button>
                                                        </form>
                                                        <form action="{{ url('/confirmform/update/'.$row->id) }}"
                                                              method="POST">
                                                            @csrf
                                                            @foreach($row->borrow_list_id as $item)
                                                                <input type="hidden" name="borrow_list_id[]"
                                                                       value="{{ $item }}">
                                                            @endforeach
                                                            <input type="hidden" name="borrow_status" value="0">
                                                            <button class="btn btn-danger btn-sm" data-toggle="modal"
                                                                    data-target="#Note{{($row->id)}}">ไม่อนุมัติ
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if (session('success'))
                            <script>
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'ยืนยันรายการยืมสำเร็จ',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            </script>
                        @endif
                        @if (session('error'))
                            <script>
                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: 'ยกเลิกรายการยืมสำเร็จ',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            </script>
                        @endif
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

        function submitButton() {

        }

        function submitCheckbox() {
            checkbox.checked = true;
        }
    </script>

@endpush
