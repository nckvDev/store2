@extends('layouts.app', ['class' => 'bg-gradient-neutral'])
@inject('thaiDateHelper', 'App\Services\ThaiDateFormat')
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
                    <div class="col-12"></div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
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
                                        <td>
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
                                        <td>
                                            <form action="{{ url('/personnel_dashboard/update/'.$row->id) }}"
                                                  method="post">
                                                @csrf
                                                @foreach($row->borrow_list_id as $item)
                                                    <input type="hidden" name="borrow_list_id[]" value="{{ $item }}">
                                                @endforeach
                                                <input type="hidden" name="borrow_status" value="4">
                                                <button type="submit"
                                                        class="btn btn-primary btn-sm " {{$row->borrow_status != 2 ? 'disabled' : ''}} >
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
@endsection

@push('js')
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush
