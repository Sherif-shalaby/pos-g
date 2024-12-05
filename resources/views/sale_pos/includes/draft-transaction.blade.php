<div id="draftTransaction" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal text-left">

    <div class="modal-dialog" role="document" style="width: 65%">
        <div class="modal-content">
            <div
                class="modal-header py-2 align-items-center text-white @if (app()->isLocale('ar')) flex-row-reverse @else flex-row @endif">
                <h4 class="modal-title">@lang('lang.draft_transactions')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 modal-filter">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('draft_start_date', __('lang.start_date'), []) !!}
                                {!! Form::text('start_date', null, ['class' => 'form-control', 'id' =>
                                'draft_start_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('draft_end_date', __('lang.end_date'), []) !!}
                                {!! Form::text('end_date', null, ['class' => 'form-control', 'id' =>
                                'draft_end_date']) !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label('draft_deliveryman_id', __('lang.deliveryman'), []) !!}
                                {!! Form::select('draft_deliveryman_id', $delivery_men, null, ['class' =>
                                'form-control sale_filter', 'placeholder' => __('lang.all'),
                                'data-live-search' => 'true', 'id' => 'draft_deliveryman_id']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @include('sale_pos.partials.view_draft')
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default col-md-12 px-0 m-0 rounded-0 text-center"
                    data-dismiss="modal">@lang('lang.close')</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>