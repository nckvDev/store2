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
                                               {{ $items }}
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
    </div>
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
