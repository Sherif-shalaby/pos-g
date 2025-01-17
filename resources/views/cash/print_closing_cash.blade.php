<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            @media print {

                * {
                    font-size: 22px;
                    line-height: 20px;
                    font-family: 'Times New Roman';
                    font-weight: bolder;
                    color: black;
                }
                @page {
                    size: 80mm; /* Set the page size to 80mm */
                    margin: 0; /* Optionally set margins for the printed page */
                }
            }
        </style>
    </head>
    <body>
        @php
            $store = \App\Models\Store::where('id' ,$cash_register->store_id)->first();
            $user = \App\Models\User::where('id',$cash_register->user_id)->first();
        @endphp
        <div class="col-md-12" style="max-width: 350px;" id="print-closing-cash-div">
            <div class="well">
                <table class="table">
                    <thead style="border-bottom:2px solid #000!important ">
                        <tr>
                            <td><b>@lang('lang.date_and_time')</b></td>
                            <td>{{ @format_datetime($cash_register->created_at) }}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.store_name')</b></td>
                            <td>{{$store->name ?? ''}}</td>
                        </tr>
                        <tr>
                            <td><b>@lang('lang.cashier')</b></td>
                            <td>{{$user->name  ?? ''}}</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>@lang('lang.cash_in')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_cash_in) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.cash_out')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_cash_out) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_card_sale')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_card_sales) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_cheque_sale')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_cheque_sales) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_bank_transfer_sale')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_bank_transfer_sales) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_gift_card_sale')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_gift_card_sales) }}
                                </td>
                            @endforeach
                        </tr>
                        @if (session('system_mode') == 'restaurant')
                            <tr>
                                <td><b>@lang('lang.dining_in')</b></td>
                                @foreach ($cr_data as $data)
                                    <td>{{ $data['currency']['symbol'] }}
                                        {{ @num_format($data['cash_register']->total_dining_in) }}
                                    </td>
                                @endforeach
                            </tr>
                        @endif
                        <tr>
                            <td><b>@lang('lang.other_cash_sales')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_cash_sales - $data['cash_register']->total_dining_in_cash) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_cash_sale')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_cash_sales) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.total_sales')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_sale - $data['cash_register']->total_refund) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.return_sales')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_sell_return) }}
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.purchases')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_purchases) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.expenses')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_expenses) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.wages_and_compensation')</b></td>
                            @foreach ($cr_data as $data)
                                <td>{{ $data['currency']['symbol'] }}
                                    {{ @num_format($data['cash_register']->total_wages_and_compensation) }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td><b>@lang('lang.current_cash')</b></td>
                            @foreach ($cr_data as $data)
                                <td>
                                    @php
                                        $current_cash = $data['cash_register']->total_cash_sales + $data['cash_register']->total_cash_in - $data['cash_register']->total_cash_out - $data['cash_register']->total_purchases - $data['cash_register']->total_expenses - $data['cash_register']->total_wages_and_compensation - $data['cash_register']->total_sell_return;
                                    @endphp
                                    <h6 class="currency_total_row_td currency_total currency_total_{{ $data['currency']['currency_id'] }}"
                                        data-currency_id="{{ $data['currency']['currency_id'] }}"
                                        data-is_default="{{ $data['currency']['is_default'] }}"
                                        data-conversion_rate="{{ $data['currency']['conversion_rate'] }}"
                                        data-base_conversion="{{ $data['currency']['conversion_rate'] * $current_cash }}"
                                        data-orig_value="{{ $current_cash }}">
                                        <span class="symbol" style="padding-right: 10px;">
                                            {{ $data['currency']['symbol'] }}</span>
                                        <span class="total">{{ @num_format($current_cash) }}</span>
                                    </h6>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
                <div class="" style="width: 100%;text-align: center; margin-bottom: 20px ">
                    <h5 style='text-align: center;'>Proudly Developed at Sherifshalaby.tech</h5>
                </div>
            </div>
        </div>
    </body>
</html>
