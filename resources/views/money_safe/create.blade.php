<div class="modal-dialog" role="document">
    <div class="modal-content">

        {!! Form::open(['url' => action('MoneySafeController@store'), 'method' => 'post', 'id' =>
        'money_safe_add_form']) !!}

        <div
            class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">

            <h4 class="modal-title">@lang( 'lang.add_money_safe' )</h4>
            <button type="button"
                class="btn text-primary rounded-circle d-flex justify-content-center align-items-center modal-close-btn"
                data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
            <div class="form-group">
                {!! Form::label('store_id', __('lang.store') . ':*') !!}
                {!! Form::select('store_id', $stores, !empty($stores->toArray()) && count($stores->toArray()) > 0 ?
                array_key_first($stores->toArray()) : false, ['class' => 'form-control selectpicker', 'data-live-search'
                => 'true', 'required', 'placeholder' => __('lang.please_select')]) !!}
            </div>
            <div class="form-group">
                {!! Form::label('name', __('lang.safe_name') . ':*') !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('lang.name'), 'required'])
                !!}
            </div>
            <div class="form-group">
                {!! Form::label('currency_id', __('lang.currency') . ':*') !!}
                {!! Form::select('currency_id', $currencies, false, ['class' => 'form-control selectpicker',
                'data-live-search' => 'true', 'required']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('type', __('lang.type_of_safe') . ':*') !!}
                {!! Form::select('type', ['cash' => __('lang.cash'), 'bank' => __('lang.bank')], false, ['class' =>
                'form-control selectpicker', 'data-live-search' => 'true', 'required', 'placeholder' =>
                __('lang.please_select')]) !!}
            </div>
            <div class="form-group bank_fields">
                {!! Form::label('bank_name', __('lang.bank_name') . ':*') !!}
                {!! Form::text('bank_name', null, ['class' => 'form-control bank_required', 'placeholder' =>
                __('lang.bank_name'), 'required']) !!}
            </div>
            <div class="form-group bank_fields">
                {!! Form::label('IBAN', __('lang.IBAN')) !!}
                {!! Form::text('IBAN', null, ['class' => 'form-control', 'placeholder' => __('lang.IBAN')]) !!}
            </div>
            <div class="form-group bank_fields">
                {!! Form::label('bank_address', __('lang.bank_address')) !!}
                {!! Form::text('bank_address', null, ['class' => 'form-control', 'placeholder' =>
                __('lang.bank_address')]) !!}
            </div>
            {{-- <div class="form-group bank_fields">
                {!! Form::label('credit_card_currency_id', __('lang.credit_card_default_currency') . ':*') !!}
                {!! Form::select('credit_card_currency_id', $currencies, false, ['class' => 'form-control selectpicker
                bank_required', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select')]) !!}
            </div>
            <div class="form-group bank_fields">
                {!! Form::label('bank_transfer_currency_id', __('lang.bank_transfer_default_currency') . ':*') !!}
                {!! Form::select('bank_transfer_currency_id', $currencies, false, ['class' => 'form-control selectpicker
                bank_required', 'data-live-search' => 'true', 'placeholder' => __('lang.please_select')]) !!}
            </div> --}}
            <div class="form-group cash_fields">
                {!! Form::label('add_money_users', __('lang.add_money_users')) !!}
                {!! Form::select('add_money_users[]', $employees, false, ['class' => 'form-control selectpicker',
                'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple']) !!}
            </div>
            <div class="form-group cash_fields">
                {!! Form::label('take_money_users', __('lang.take_money_users')) !!}
                {!! Form::select('take_money_users[]', $employees, false, ['class' => 'form-control selectpicker',
                'data-live-search' => 'true', 'data-actions-box' => 'true', 'multiple']) !!}
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary col-md-6 px-0 m-0 rounded-0
                 text-center">@lang( 'lang.save' )</button>
            <button type="button" class="btn btn-default col-md-6 px-0 m-0 rounded-0 text-center"
                data-dismiss="modal">@lang('lang.close')</button>
        </div>

        {!! Form::close() !!}

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<script>
    $('.selectpicker').selectpicker();
    $('.bank_fields').hide();
    $('.cash_fields').hide();
    $(document).on('change', '#type', function() {
        let type = $(this).val();
        if (type == 'cash') {
            $('.bank_fields').hide();
            $('.cash_fields').show();
            $('.bank_required').attr('required', false);
        }
        if (type == 'bank') {
            $('.bank_fields').show();
            $('.cash_fields').hide();
            $('.bank_required').attr('required', true);
        }
    })
</script>
