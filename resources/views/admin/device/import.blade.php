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
                            <h3 class="mb-0">นำเข้าข้อมูลครุภัณฑ์</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('device_report_xlsm') }}"
                                class="btn btn-sm btn-outline-danger">ตัวอย่างการนำเข้าข้อมูล</a>
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
                    <form action="{{route('import-device')}}" enctype="multipart/form-data" method="post">
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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="assets/vendor/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
@endpush