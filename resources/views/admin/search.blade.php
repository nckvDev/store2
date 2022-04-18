@extends('layouts.app', ['class' => 'bg-gradient-info'])

@section('content')
@include('layouts.headers.cards')

<div class="container mt--7">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Simple Search</h3>
                </div>
                <div class="card-body">
                    <!-- <form action="{{ route('simple_search') }}" method="GET">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Type the name"  name="search">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </div>
                    </form> -->
                    <form action="{{ route('advance_search') }}" method="GET">
                        <h3>Advanced Search</h3><br>
                        <div class="form-group">
                            <select class="form-control form-control-alternative " data-toggle="select" name="name">
                                <option value="">-- Select --</option>
                                @foreach($data as $row)
                                <option value="{{ $row->name }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" class="form-control" placeholder="Person's name"><br>
                        <input type="text" name="address" class="form-control" placeholder="Address"><br>
                        <label>Range of Age</label>
                        <div class="input-group">
                            <input type="text" name="min_age" class="form-control" placeholder="Start Age" value="{{ old('min_age') ?  old('min_age') : '' }}" autofocus>
                            <input type="text" name="max_age" class="form-control" placeholder="End of Age"  value="{{ old('max_age') }}" autofocus>
                        </div>
                        <input type="submit" value="Search" class="btn btn-outline-secondary">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>List of People</h3>
                </div>

                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Age</th>
                                <th>Date</th>
                            </tr>
                        </thead>

                        @foreach($data as $pep)
                        <tr>
                            <td>{{ $pep->id }}</td>
                            <td>{{ $pep->name }}</td>
                            <td>{{ $pep->address }}</td>
                            <td>{{ $pep->age }}</td>
                            <td>{{ $pep->created_at }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="card-footer">
                    {{ $data->appends(request()->except('page'))->links() }}
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
