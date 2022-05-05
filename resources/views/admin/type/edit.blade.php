@extends('layouts.app', ['class' => 'bg-secondary'])
@section('content')
    @include('layouts.headers.cards')
    <div class="container-fluid mt--9">
        <div class="row">
            <div class="col-xl-12 mb-4">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="mb-0">{{ __('แก้ไขประเภท') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ url('/type/update/'.$types->id) }}" autocomplete="off">
                            @csrf
                            <div class="pl-lg-2">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('ประเภท') }}</label>
                                    <input type="text" name="type_detail" id="input-name"
                                           class="form-control form-control-alternative{{ $errors->has('type_detail') ? ' is-invalid' : '' }}"
                                           placeholder="{{ __('ประเภท') }}" value="{{ $types->type_detail }}" autofocus>

                                    @if ($errors->has('type_detail'))
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('type_detail') }}</strong>
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

