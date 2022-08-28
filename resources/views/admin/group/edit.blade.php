@extends('layouts.app', ['class' => 'bg-secondary'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{ __('แก้ไขกลุ่มเรียน') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/group/update/'.$groups->id) }}" autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div>
                                <label class="form-control-label" for="input-name">{{ __('กรุณาเลือกแผนก') }}</label>
                                <select class="form-control" data-toggle="select" title="Simple select"
                                    data-live-search="true" data-live-search-placeholder="Search ..."
                                    name="department_name">
                                    <option>เลือก</option>
                                    @foreach($departments as $row)
                                    <option value="{{ $row->department_name }}">{{ $row->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('กลุ่มเรียน') }}</label>
                                <input type="text" name="group_name" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('group_name') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('กลุ่มเรียน') }}" value="{{ $groups->group_name }}" autofocus>

                                @if ($errors->has('group_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('group_name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-2">{{ __('บันทึก') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection