@extends('layouts.app', ['class' => 'bg-neutral'])

@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12">
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">แผนก</li>
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
                                <th>ชื่อแผนก</th>
                                <th>วันที่สร้าง</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $row)
                            <tr>
                                <td>{{ $departments->firstItem()+$loop->index }}</td>
                                <td>{{ $row->department_name }}</td>
                                <td>
                                    @if ( $row->created_at == NULL)
                                    ไม่ถูกนิยาม
                                    @else
                                    {{ $row->created_at }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item"
                                                href="{{ url('/department/edit/'.$row->id) }}">แก้ไข</a>
                                            <a class="dropdown-item"
                                                href="{{ url('/department/delete/'.$row->id) }}">ลบ</a>
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
                        <h3 class="mb-0">{{ __('เพิ่มแผนก') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('addDepartment') }}" autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('แผนก') }}</label>
                                <input type="text" name="department_name" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('department_name') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('กรุณาใส่ข้อมูลแผนก') }}" autofocus>

                                @if ($errors->has('department_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('department_name') }}</strong>
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush