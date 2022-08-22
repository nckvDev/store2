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
                            <h3 class="mb-0">รายการครุภัณฑ์</h3>
                        </div>
                        <div class="col-4 text-right">
                            <a href="{{ route('add_device') }}" class="btn btn-sm btn-primary">เพิ่มครุภัณฑ์</a>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">รหัสครุภัณฑ์</th>
                                <th scope="col">ชื่อครุภัณฑ์</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col" class="text-center">รูปภาพ</th>
                                <th scope="col">ตำแหน่ง</th>
                                <th scope="col">ปี</th>
                                <th scope="col">ประเภท</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($devices as $row)
                            <tr>
                                <td>{{ $row->device_num }}</td>
                                <td>{{ $row->device_name }}</td>
                                @if($row->device_status == 1)
                                <td>
                                    <div class="rounded text-white bg-green text-center">ปกติ</div>
                                </td>
                                @endif
                                <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block " width="80"
                                        height="80" /></td>
                                <td>{{ $row->location }}</td>
                                <td>{{ $row->device_year }}</td>
                                <td>{{ $row->device_type->type_detail }}</td>
                                <td class="text-right">
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item"
                                                href="{{ url('/device/edit/'.$row->id) }}">แก้ไขข้อมูล</a>
                                            <a class="dropdown-item"
                                                href="{{ url('/device/delete/'.$row->id) }}">ลบข้อมูล</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

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
                </div>

            </div>
            <div class="mt-4">
                {{ $devices->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
