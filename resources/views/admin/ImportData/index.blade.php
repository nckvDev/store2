@extends('layouts.app', ['class' => 'bg-neutral'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">นำเข้าข้อมูลผู้ใช้งาน</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('user_report_xlsm') }}"
                                class="btn btn-sm btn-outline-danger">ตัวอย่างการนำเข้าข้อมูล</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 mb-3">
            <div class="card bg-secondary shadow">
                <div class="card-body">
                    <form method="post" action="{{ route('addUserData') }}" autocomplete="off">
                        @csrf
                        <h3>เพิ่มข้อมูลผู้ใช้งาน</h3>
                        <div class="pl-lg-2">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('รหัสผู้ใช้งาน') }}</label>
                                <input type="text" name="user_id" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('user_id') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('รหัสผู้ใช้งาน') }}" autofocus>

                                @if ($errors->has('user_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('user_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('ชื่อ') }}</label>
                                        <input type="text" name="firstname" id="input-name"
                                            class="form-control form-control-alternative{{ $errors->has('firstname') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('ชื่อจริง') }}" autofocus>
                                        @if ($errors->has('firstname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('firstname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('นามสกุล') }}</label>
                                        <input type="text" name="lastname" id="input-name"
                                            class="form-control form-control-alternative{{ $errors->has('lastname') ? ' is-invalid' : '' }}"
                                            placeholder="{{ __('นามสกุล') }}" autofocus>
                                        @if ($errors->has('lastname'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('lastname') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-2">{{ __('บันทึก') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mb-3">
            <div class="card bg-secondary shadow">
                <div class="card-body">
                    <form action="{{route('import-list')}}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <h3>นำเข้าข้อมูลสกุล .xlsx หรือ .csv</h3>
                            <input type="file" name="file" class="form-control" />
                            @if ($errors->has('file'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">ยืนยัน</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    @if (session('delete'))
    <script>
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: 'ลบข้อมูลเรียบร้อย',
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
                                <th>จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($masterusers as $row)
                            <tr>
                                <td>{{ $row->id}}</td>
                                <td>{{ $row->user_id}}</td>
                                <td>{{ $row->firstname}}</td>
                                <td>{{ $row->lastname}}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item"
                                                href="{{ url('/dataimport/edit/'.$row->id) }}">แก้ไข</a>
                                            <a class="dropdown-item delete-confirm"
                                                href="/dataimport/delete/{{$row->id}}">ลบข้อมูล</a>
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