@extends('layouts.app', ['class' => 'bg-neutral'])
@inject('thaiDateHelper', 'App\Services\ThaiDateFormat')
@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">คำนำหน้า</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-8 mb-4">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <table id="table_id" class="">
                            <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อคำนำหน้า</th>
                                <th>วันที่สร้าง</th>
                                <th>จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($prefixs as $row)
                                <tr>
                                    <td>{{ $prefixs->firstItem()+$loop->index }}</td>
                                    <td>{{ $row->prefix_name }}</td>
                                    <td>
                                        @if ( $row->created_at == NULL)
                                            ไม่ถูกนิยาม
                                        @else
{{--                                            {{ \Carbon\Carbon::parse($row->created_at)->locale('th')->isoFormat('L - LT') }}--}}
                                            {{ $thaiDateHelper->DateFormat($row->created_at) }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                   href="{{ url('/prefix/edit/'.$row->id) }}">แก้ไข</a>
                                                <a class="dropdown-item delete-confirm"
                                                   href="{{ url('/prefix/delete/'.$row->id) }}">ลบข้อมูล</a>
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

            <div class="col-xl-4 mb-4">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('เพิ่มคำนำหน้า') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('addPrefix') }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-2">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('คำนำหน้า') }}</label>
                                    <input type="text" name="prefix_name" id="input-name"
                                           class="form-control form-control-alternative{{ $errors->has('prefix_name') ? ' is-invalid' : '' }}"
                                           placeholder="{{ __('กรุณาใส่คำนำหน้า') }}" autofocus>
                                    @if ($errors->has('prefix_name'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('prefix_name') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-2">{{ __('บันทึก') }}</button>
                                </div>
                            </div>
                        </form>
                        @if (session('success'))
                            <script>
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'บันทึกข้อมูลเรียบร้อย',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            </script>
                        @endif
                        @if (session('update'))
                            <script>
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: 'แก้ไขข้อมูลเรียบร้อย',
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
    <script>
        $(function () {
            $.extend($.fn.dataTableExt.oStdClasses, {
                "sFilterInput": "form-control form-control-sm",
                "sLengthSelect": "form-control form-control-sm"
            });
            $('#table_id').dataTable({
                "lengthChange": false,
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

        $('.delete-confirm').on('click', function (event) {
            event.preventDefault();
            const url = $(this).attr('href');
            Swal.fire({
                title: 'คุณแน่ใจ?',
                text: "คุณต้องการลบข้อมูลนี้หรือไม่!",
                icon: 'warning',
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
