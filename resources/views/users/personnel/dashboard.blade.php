@extends('layouts.app', ['class' => 'bg-gradient-neutral'])

@section('content')
    @include('layouts.headers.cards')

    <div class="container-fluid mt--9">
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
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">รายการยืม</h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                    </div>


                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">รายการ</th>
                                <th scope="col">เวลา</th>
                                <th scope="col">สถานะ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($borrowList as $row)
                                <tr>
                                    <td>
                                    @foreach($row->borrow_name as $item)
                                            @foreach( $item as $items)
                                               {{ $items }},
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>{{ $row->created_at }}</td>
                                    @if($row->borrow_status=="1")
                                        <td class="align-middle text-sm">
                                            <span class="badge text-white bg-gradient-success">อนุมัติ</span>
                                        </td>
                                    @endif
                                    @if($row->borrow_status=="0")
                                        <td class="align-middle text-sm">
                                            <span class="badge text-white bg-gradient-warning">ไม่อนุมัติ</span>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        {{--                    @if (session('delete'))--}}
                        {{--                        <script>--}}
                        {{--                            Swal.fire({--}}
                        {{--                                position: 'center',--}}
                        {{--                                icon: 'error',--}}
                        {{--                                title: 'ลบข้อมูลเรียบร้อย',--}}
                        {{--                                showConfirmButton: false,--}}
                        {{--                                timer: 1500--}}
                        {{--                            })--}}
                        {{--                        </script>--}}
                        {{--                    @endif--}}
                    </div>

                </div>
            </div>
        </div>
        {{--        <div class="row mt-5"> --}}
        {{--            <div class="col-xl-8 mb-5 mb-xl-0">--}}
        {{--                <div class="card shadow">--}}
        {{--                    <div class="card-header border-0">--}}
        {{--                        <div class="row align-items-center">--}}
        {{--                            <div class="col">--}}
        {{--                                <h3 class="mb-0">Page visits</h3>--}}
        {{--                            </div>--}}
        {{--                            <div class="col text-right">--}}
        {{--                                <a href="#!" class="btn btn-sm btn-primary">See all</a>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="table-responsive">--}}
        {{--                        <!-- Projects table -->--}}
        {{--                        <table class="table align-items-center table-flush">--}}
        {{--                            <thead class="thead-light">--}}
        {{--                            <tr>--}}
        {{--                                <th scope="col">Page name</th>--}}
        {{--                                <th scope="col">Visitors</th>--}}
        {{--                                <th scope="col">Unique users</th>--}}
        {{--                                <th scope="col">Bounce rate</th>--}}
        {{--                            </tr>--}}
        {{--                            </thead>--}}
        {{--                            <tbody>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row">/argon/</th>--}}
        {{--                                <td>4,569</td>--}}
        {{--                                <td>340</td>--}}
        {{--                                <td><i class="fas fa-arrow-up text-success mr-3"></i> 46,53% </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row">/argon/index.html</th>--}}
        {{--                                <td> 3,985 </td>--}}
        {{--                                <td> 319 </td>--}}
        {{--                                <td> <i class="fas fa-arrow-down text-warning mr-3"></i> 46,53% </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row">/argon/charts.html</th>--}}
        {{--                                <td> 3,513 </td>--}}
        {{--                                <td> 294 </td>--}}
        {{--                                <td><i class="fas fa-arrow-down text-warning mr-3"></i> 36,49% </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row">/argon/tables.html </th>--}}
        {{--                                <td> 2,050 </td>--}}
        {{--                                <td>147 </td>--}}
        {{--                                <td><i class="fas fa-arrow-up text-success mr-3"></i> 50,87%</td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row">/argon/profile.html</th>--}}
        {{--                                <td> 1,795 </td>--}}
        {{--                                <td> 190 </td>--}}
        {{--                                <td> <i class="fas fa-arrow-down text-danger mr-3"></i> 46,53% </td>--}}
        {{--                            </tr>--}}
        {{--                            </tbody>--}}
        {{--                        </table>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            <div class="col-xl-4">--}}
        {{--                <div class="card shadow">--}}
        {{--                    <div class="card-header border-0">--}}
        {{--                        <div class="row align-items-center">--}}
        {{--                            <div class="col">--}}
        {{--                                <h3 class="mb-0">Social traffic</h3>--}}
        {{--                            </div>--}}
        {{--                            <div class="col text-right">--}}
        {{--                                <a href="#!" class="btn btn-sm btn-primary">See all</a>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                    <div class="table-responsive">--}}
        {{--                        <!-- Projects table -->--}}
        {{--                        <table class="table align-items-center table-flush">--}}
        {{--                            <thead class="thead-light">--}}
        {{--                            <tr>--}}
        {{--                                <th scope="col">Referral</th>--}}
        {{--                                <th scope="col">Visitors</th>--}}
        {{--                                <th scope="col"></th>--}}
        {{--                            </tr>--}}
        {{--                            </thead>--}}
        {{--                            <tbody>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row"> Facebook </th>--}}
        {{--                                <td> 1,480 </td>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex align-items-center">--}}
        {{--                                        <span class="mr-2">60%</span>--}}
        {{--                                        <div>--}}
        {{--                                            <div class="progress">--}}
        {{--                                                <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row"> Facebook</th>--}}
        {{--                                <td> 5,480</td>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex align-items-center">--}}
        {{--                                        <span class="mr-2">70%</span>--}}
        {{--                                        <div>--}}
        {{--                                            <div class="progress">--}}
        {{--                                                <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row"> Google </th>--}}
        {{--                                <td> 4,807</td>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex align-items-center">--}}
        {{--                                        <span class="mr-2">80%</span>--}}
        {{--                                        <div>--}}
        {{--                                            <div class="progress">--}}
        {{--                                                <div class="progress-bar bg-gradient-primary" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%;"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row"> Instagram </th>--}}
        {{--                                <td>  3,678 </td>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex align-items-center">--}}
        {{--                                        <span class="mr-2">75%</span>--}}
        {{--                                        <div>--}}
        {{--                                            <div class="progress">--}}
        {{--                                                <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%;"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            <tr>--}}
        {{--                                <th scope="row">   twitter </th>--}}
        {{--                                <td> 2,645 </td>--}}
        {{--                                <td>--}}
        {{--                                    <div class="d-flex align-items-center">--}}
        {{--                                        <span class="mr-2">30%</span>--}}
        {{--                                        <div>--}}
        {{--                                            <div class="progress">--}}
        {{--                                                <div class="progress-bar bg-gradient-warning" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%;"></div>--}}
        {{--                                            </div>--}}
        {{--                                        </div>--}}
        {{--                                    </div>--}}
        {{--                                </td>--}}
        {{--                            </tr>--}}
        {{--                            </tbody>--}}
        {{--                        </table>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
