@extends('owner.layouts.app')

@section('panel')
        <div class="row justify-content-center mt-2">
            <div class="col-lg-12">
                <div class="card card-deposit pt-3">
                    <div class="card-body mt-4">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    @php
                                        echo $withdraw->method->description
                                    @endphp
                                </div>
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Balance Will be') : </label>
                                    <div class="input-group">
                                        <input type="text" value="{{showAmount($withdraw->owner->balance - ($withdraw->amount))}}"  class="form-control form-control-lg" placeholder="@lang('Enter Amount')" required readonly>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text ">{{ __($general->cur_text) }} </span>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold">@lang('Request Amount') :</span>
                                    <span class="font-weight-bold pull-right">{{showAmount($withdraw->amount)  }} {{__($general->cur_text)}}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold">@lang('Withdrawal Charge') :</span>
                                    <span class="font-weight-bold pull-right">{{showAmount($withdraw->charge) }} {{__($general->cur_text)}}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold">@lang('After Charge') :</span>
                                    <span class="font-weight-bold pull-right">{{showAmount($withdraw->after_charge) }} {{__($general->cur_text)}}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold">@lang('Conversion Rate') : 1 {{__($general->cur_text)}} = </span>
                                    <span class="font-weight-bold pull-right">  {{showAmount($withdraw->rate)  }} {{__($withdraw->currency)}}</span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span class="font-weight-bold">@lang('You Will Get') :</span>
                                    <span class="font-weight-bold pull-right">{{showAmount($withdraw->final_amount) }} {{__($withdraw->currency)}}</span>
                                  </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <form action="{{route('owner.withdraw.submit')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if($withdraw->method->user_data)
                                    @foreach($withdraw->method->user_data as $k => $v)
                                        @if($v->type == "text")
                                            <div class="form-group">
                                                <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                <input type="text" name="{{$k}}" class="form-control" value="{{old($k)}}" placeholder="{{__($v->field_level)}}" @if($v->validation == "required") required @endif>
                                                @if ($errors->has($k))
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @elseif($v->type == "textarea")
                                            <div class="form-group">
                                                <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                                <textarea name="{{$k}}"  class="form-control"  placeholder="{{__($v->field_level)}}" rows="3" @if($v->validation == "required") required @endif>{{old($k)}}</textarea>
                                                @if ($errors->has($k))
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @elseif($v->type == "file")
                                            <label><strong>{{__($v->field_level)}} @if($v->validation == 'required') <span class="text-danger">*</span>  @endif</strong></label>
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new " data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail withdraw-thumbnail"
                                                         data-trigger="fileinput">
                                                        <img class="w-100" src="{{ getImage('/')}}" alt="@lang('Image')">
                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail wh-200-150"></div>
                                                    <div class="img-input-div">
                                                        <span class="btn btn-info btn-file">
                                                            <span class="fileinput-new "> @lang('Select') {{__($v->field_level)}}</span>
                                                            <span class="fileinput-exists"> @lang('Change')</span>
                                                            <input type="file" name="{{$k}}" accept="image/*" @if($v->validation == "required") required @endif>
                                                        </span>
                                                        <a href="#" class="btn btn-danger fileinput-exists"
                                                        data-dismiss="fileinput"> @lang('Remove')</a>
                                                    </div>
                                                </div>
                                                @if ($errors->has($k))
                                                    <br>
                                                    <span class="text-danger">{{ __($errors->first($k)) }}</span>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                    @endif
                                    @if(auth()->guard('owner')->user()->ts)
                                    <div class="form-group">
                                        <label>@lang('Google Authenticator Code')</label>
                                        <input type="text" name="authenticator_code" class="form-control" required>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <button type="submit" class="btn btn--primary btn-block btn-lg mt-4 text-center">@lang('Confirm')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('style-lib')
<link rel="stylesheet" href="{{asset('assets/laramin/css/fileinput.css')}}">
@endpush

@push('script-lib')
<script src="{{asset('assets/laramin/js/fileinput.js')}}"></script>
@endpush

@push('style')
    <style>
       .fileinput-new, .fileinput-exists{
            color: #fff;
        }
    </style>
@endpush



