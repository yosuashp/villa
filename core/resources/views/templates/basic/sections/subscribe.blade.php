@php
 $subscribe = getContent('subscribe.content', true);
@endphp

<section class="section--sm">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="cta">
            <div class="section cta__container">
              <h3 class="my-0 text-white cta__title">
                {{ __($subscribe->data_values->heading) }}
              </h3>
              <form id="subscribe">
                  @csrf
              <div class="newsletter rounded-pill">
                <div class="newsletter__container rounded-pill">
                        <input type="email" name="email" id="email" class="form-control form--control newsletter__input flex-grow-1 rounded-pill" placeholder="@lang('Subscribe now..')"/>
                        <button class="btn btn--xl btn--base rounded-pill sm-text">
                          @lang('Subscribe')
                        </button>
                    </div>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @push('script')
<script>
    (function ($) {
        "use strict";

        $('#subscribe').on('submit', function (e) {
            e.preventDefault();
            var data = $('#subscribe').serialize();
           $.ajax({
               type: "POST",
               url: "{{ route('subscribe') }}",
               data: data,
               success: function (response) {
                    if(response.status == 'success'){
                        notify('success', response.message);
                        $('#email').val('');
                    }else{
                        notify('error', response.message);
                    }
               }
           });
        });
    })(jQuery);

</script>
@endpush

