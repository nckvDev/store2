@extends('layouts.app', ['class' => 'bg-gradient-neutral'])
@inject('thaiDateHelper', 'App\Services\ThaiDateFormat')
@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--9 mb-4">
        <div class="row">
            <div class="col-xl-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page"> รายการยืม</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-5 mb-xl-0">
                <div class="card shadow">
                    <div class="table-responsive">
                        <div class="card-body">
                            {{--                            <table class="table align-items-center table-flush">--}}
                            <table id="borrow-student" class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">รหัส</th>
                                    <th scope="col">รายการ</th>
                                    <th scope="col">เวลา</th>
                                    <th scope="col">สถานะ</th>
                                    <th scope="col">ส่งคืน</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($borrowList as $row)
                                    @if($row->borrow_status == 1 || $row->borrow_status == 2 || $row->borrow_status == 4)
                                        <tr>
                                            <td>
                                                @foreach($row->borrow_list_id as $number => $id)
                                                    <h5> {{ $id }} </h5>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($row->borrow_name as $number => $name)
                                                    <h5> {{ $name }} </h5>
                                                @endforeach
                                            </td>
                                            <td class="align-middle">
                                                {{ $thaiDateHelper->DateFormat($row->created_at) }}
                                            </td>

                                            @if($row->borrow_status=="1")
                                                <td class="align-middle text-sm">
                                                    <span class="badge text-white bg-gradient-warning">รออนุมัติ</span>
                                                </td>
                                            @endif
                                            @if($row->borrow_status=="2")
                                                <td class="align-middle text-sm">
                                                    <span class="badge text-white bg-gradient-success">อนุมัติ</span>
                                                </td>
                                            @endif
                                            @if($row->borrow_status=="4")
                                                <td class="align-middle text-sm">
                                                    <span class="badge text-white bg-gradient-gray">ส่งคืนแล้ว</span>
                                                </td>
                                            @endif
                                            <td class="align-middle">
                                                <form action="{{ url('/student_dashboard/update/'.$row->id) }}"
                                                      method="post">
                                                    @csrf
                                                    @foreach($row->borrow_list_id as $item)
                                                        <input type="hidden" name="borrow_list_id[]"
                                                               value="{{ $item }}">
                                                    @endforeach
                                                    <input type="hidden" name="borrow_status" value="4">
                                                    <button type="submit"
                                                            class="btn btn-primary btn-sm" {{$row->borrow_status != 2 ? 'disabled' : null}} >
                                                        ส่งคืน
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'ส่งคืนเรียบร้อย',
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
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>

    <script>
        $(function () {
            $.extend($.fn.dataTableExt.oStdClasses, {
                "sFilterInput": "form-control form-control-sm",
                "sLengthSelect": "form-control form-control-sm"
            });

            $('#borrow-student').dataTable({
                "responsive": true,
                "lengthChange": true,
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
@endpush
