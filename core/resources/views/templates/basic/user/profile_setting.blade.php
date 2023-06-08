@extends($activeTemplate.'layouts.master')
@section('content')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="custom--card">
                    <div class="card-body">
                        <div class="text-end mb-3">
                            <a href="{{route('user.change.password') }}" class="btn btn-sm btn--base">
                             <i class="fa fa-key"></i>  @lang('Change Password')
                            </a>
                        </div>
                        <form class="register prevent-double-click" action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="InputFirstname">@lang('First Name'):</label>
                                    <input type="text" class="form--control" id="InputFirstname" name="firstname" placeholder="@lang('First Name')" value="{{$user->firstname}}" minlength="3" readonly>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="lastname">@lang('Last Name'):</label>
                                    <input type="text" class="form--control" id="lastname" name="lastname" placeholder="@lang('Last Name')" value="{{$user->lastname}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="email">@lang('E-mail Address'):</label>
                                    <input class="form--control" id="email" placeholder="@lang('E-mail Address')" value="{{$user->email}}" readonly>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="phone">@lang('Mobile Number')</label>
                                    <input class="form--control" id="phone" value="{{$user->mobile}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label for="address">@lang('Address'):</label>
                                    <input type="text" class="form--control" id="address" name="address" placeholder="@lang('Address')" value="{{@$user->address->address}}" required="">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="state">@lang('State'):</label>
                                    <input type="text" class="form--control" id="state" name="state" placeholder="@lang('state')" value="{{@$user->address->state}}" required="">
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label for="zip">@lang('Zip Code'):</label>
                                    <input type="number" class="form--control" id="zip" name="zip" placeholder="@lang('Zip Code')" value="{{@$user->address->zip}}" required="">
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="city">@lang('City'):</label>
                                    <input type="text" class="form--control" id="city" name="city" placeholder="@lang('City')" value="{{@$user->address->city}}" required="">
                                </div>

                                <div class="form-group col-sm-4">
                                    <label>@lang('Country'):</label>
                                    <input class="form--control" value="{{@$user->address->country}}" readonly>
                                </div>

                            </div>
                            <div class="form-group row pt-5 mb-0">
                                <div class="col-sm-12 text-center">
                                    <button type="submit" class="btn btn--base w-100">@lang('Update Profile')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('script')
    <script>
        $('[readonly]').on('focus', function(){
            $(this).parents('.form-group').append('<span class="text--danger error-message">@lang("Sorry! you can\'t change this field")<span>');
        });

        $('[readonly]').on('focusout', function(){

            $(this).parents('.form-group').find('.error-message').remove();

        });
    </script>
@endpush
