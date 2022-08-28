@extends('layouts.app', ['class' => 'bg-secondary'])
@section('content')
@include('layouts.headers.cards')
<div class="container-fluid mt--9">
    <div class="row">
        <div class="col-xl-12 mb-4">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">{{ __('แก้ไขคำนำหน้า') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ url('/prefix/update/'.$prefixs->id) }}" autocomplete="off">
                        @csrf
                        <div class="pl-lg-2">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label class="form-control-label" for="input-name">{{ __('คำนำหน้า') }}</label>
                                <input type="text" name="prefix_name" id="input-name"
                                    class="form-control form-control-alternative{{ $errors->has('prefix_name') ? ' is-invalid' : '' }}"
                                    placeholder="{{ __('คำนำหน้า') }}" value="{{ $prefixs->prefix_name }}" autofocus>

                                @if ($errors->has('prefix_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('prefix_name') }}</strong>
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