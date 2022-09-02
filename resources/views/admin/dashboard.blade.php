@extends('layouts.app', ['class' => 'bg-neutral'])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12">
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">พัสดุทั้งหมด</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                               href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                               aria-selected="true"><i class="ni ni-settings mr-2"></i>วัสดุ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                               href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                               aria-selected="false"><i class="fa fa-toolbox mr-2"></i>ครุภัณฑ์</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                               href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                               aria-selected="false"><i class="fa fa-toolbox mr-3"></i>วัสดุสิ้นเปลือง</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                         aria-labelledby="tabs-icons-text-1-tab">
                        <div class="card shadow mb-3">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">รหัสวัสดุ</th>
                                        <th scope="col">ชื่อวัสดุ</th>
                                        <th scope="col" class="text-center">สถานะ</th>
                                        <th scope="col" class="text-center">รูปภาพ</th>
                                        <th scope="col">ตำแหน่ง</th>
                                        <th scope="col">ประเภท</th>
{{--                                        <th scope="col"></th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($stocks as $row)
                                        <tr>
                                            <td>{{ $row->stock_num }}</td>
                                            <td>{{ $row->stock_name }}</td>
                                            @if($row->stock_status == 0)
                                                <td>
                                                    <div class="rounded text-white bg-green text-center">พร้อมใช้งาน
                                                    </div>
                                                </td>
                                            @elseif($row->stock_status == 1)
                                                <td>
                                                    <div class="rounded text-white bg-orange text-center"> รออนุมัติ
                                                    </div>
                                                </td>
                                            @elseif($row->stock_status == 2)
                                                <td>
                                                    <div class="rounded text-white bg-red text-center"> ถูกยืม</div>
                                                </td>
                                            @endif
                                            <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block "
                                                     width="80" height="80"/></td>
                                            <td>{{ $row->position }}</td>
                                            <td>{{ $row->stock_type->type_detail }}</td>
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
                    </div>
                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                         aria-labelledby="tabs-icons-text-2-tab">
                        <div class="card shadow mb-3">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">รหัสคุรภัณฑ์</th>
                                        <th scope="col">ชื่อคุรภัณฑ์</th>
                                        <th scope="col" class="text-center">สถานะ</th>
                                        <th scope="col" class="text-center">รูปภาพ</th>
                                        <th scope="col">ตำแหน่ง</th>
                                        <th scope="col">ประเภท</th>
{{--                                        <th scope="col"></th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($devices as $row)
                                        <tr>
                                            <td>{{ $row->device_num }}</td>
                                            <td>{{ $row->device_name }}</td>
                                            @if($row->device_status == 0)
                                                <td>
                                                    <div class="rounded text-white bg-green text-center">พร้อมใช้งาน
                                                    </div>
                                                </td>
                                            @elseif($row->device_status == 1)
                                                <td>
                                                    <div class="rounded text-white bg-orange text-center"> รออนุมัติ
                                                    </div>
                                                </td>
                                            @elseif($row->device_status == 2)
                                                <td>
                                                    <div class="rounded text-white bg-red text-center"> ถูกยืม</div>
                                                </td>
                                            @endif
                                            <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block "
                                                     width="80" height="80"/></td>
                                            <td>{{ $row->location }}</td>
                                            <td>{{ $row->device_type->type_detail }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                         aria-labelledby="tabs-icons-text-3-tab">
                        <div class="card shadow mb-3">
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col">รหัสวัสดุสิ้นเปลือง</th>
                                        <th scope="col">ชื่อวัสดุสิ้นเปลือง</th>
                                        <th scope="col" class="text-center">สถานะ</th>
                                        <th scope="col" class="text-center">รูปภาพ</th>
                                        <th scope="col">ตำแหน่ง</th>
                                        <th scope="col">ประเภท</th>
{{--                                        <th scope="col"></th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($disposables as $row)
                                        <tr>
                                            <td>{{ $row->disposable_num }}</td>
                                            <td>{{ $row->disposable_name }}</td>
                                            @if($row->disposable_status == 0)
                                                <td>
                                                    <div class="rounded text-white bg-green text-center"> พร้อมใช้งาน
                                                    </div>
                                                </td>
                                            @elseif($row->disposable_status == 1)
                                                <td>
                                                    <div class="rounded text-white bg-orange text-center"> รออนุมัติ
                                                    </div>
                                                </td>
                                            @elseif($row->disposable_status == 2)
                                                <td>
                                                    <div class="rounded text-white bg-red text-center"> ถูกยืม</div>
                                                </td>
                                            @endif
                                            <td><img src="{{ asset($row->image) }}" class="rounded mx-auto d-block "
                                                     width="80" height="80"/></td>
                                            <td>{{ $row->position }}</td>
                                            <td>{{ $row->disposable_type->type_detail }}</td>
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
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
