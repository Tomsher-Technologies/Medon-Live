@extends('backend.layouts.app')

@section('content')

<div class="card">
    <form class="" action="" id="sort_orders" method="GET">
        <div class="card-header row gutters-5">
            <div class="col-lg-12 mb-3">
                <h5 class="mb-md-0 h6">All Orders</h5>
            </div>

            @php
                $shops = getActiveShops();
            @endphp
            <div class="col-lg-3 ml-auto">
                <select id="shop_search" name="shop_search" class="form-control aiz-selectpicker" >
                    <option value="">Select Shop</option>
                    @foreach ($shops as $shop)
                        <option {{ ($shop_search == $shop->id) ? 'selected' : '' }} value="{{$shop->id}}">{{ $shop->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 ml-auto">
                <select class="form-control aiz-selectpicker" name="delivery_status" id="delivery_status">
                    <option value="">{{translate('Filter by Delivery Status')}}</option>
                    <option value="pending" @if ($delivery_status == 'pending') selected @endif>{{translate('Pending')}}</option>
                    <option value="confirmed" @if ($delivery_status == 'confirmed') selected @endif>{{translate('Confirmed')}}</option>
                    <option value="picked_up" @if ($delivery_status == 'picked_up') selected @endif>{{translate('Picked Up')}}</option>
                    <option value="partial_pick_up" @if ($delivery_status == 'partial_pick_up') selected @endif>{{translate('Partial Pick Up')}}</option>
                    <option value="partial_delivery" @if ($delivery_status == 'partial_delivery') selected @endif>{{translate('Partial Delivery')}}</option>
                    <option value="delivered" @if ($delivery_status == 'delivered') selected @endif> {{translate('Delivered')}}</option>
                    <option value="cancelled" @if ($delivery_status == 'cancelled') selected @endif>{{translate('Cancel')}}</option>
                </select>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="aiz-date-range form-control" value="{{ $date }}" name="date" placeholder="Filter by date" data-format="DD-MM-Y" data-separator=" to " data-advanced-range="true" autocomplete="off">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group mb-0">
                    <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder="Type Order code & hit Enter">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-warning">Filter</button>
                    <a class="btn btn-info" href="{{ route('sales_report.index') }}" >Reset</a>
                    <a href="{{ route('export.sales_report') }}"  class="btn btn-danger" style="border-radius: 30px;">Excel Export</a>
                </div>
            </div>
        </div>

        <div class="card-body">
            
            <table class="table aiz-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        {{-- <th>
                            <div class="form-group">
                                <div class="aiz-checkbox-inline">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" class="check-all">
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                            </div>
                        </th> --}}
                        <th>Order Code</th>
                        <th >Customer</th>
                        <th >Order Date</th>
                        <th  class="text-center" >No. of Products</th>
                        
                        <th >Amount</th>
                        <th >Shop</th>
                        <th  class="text-center">Delivery Status</th>
                        <!--<th   class="text-center">Payment Status</th>-->
                        <th class="text-center">{{translate('options')}}</th>
                    </tr>
                </thead>
                <tbody id="order-table">
                    @php
                        $shops = getActiveShops();
                    @endphp
                    @foreach ($orders as $key => $order)
                       
                    <tr>
                        <td>
                            {{ ($key+1) + ($orders->currentPage() - 1)*$orders->perPage() }}
                        </td>
                       
                        <td>
                            {{ $order->code }}
                        </td>
                        <td>
                            @if ($order->user != null)
                            <b>Name : </b>{{ $order->user->name }}</br>
                            <b>Email : </b>{{ $order->user->email }}</br>
                            <b>Phone : </b>{{ $order->user->phone }}
                            @else
                            Guest ({{ $order->guest_id }})
                            @endif
                        </td>
                         <td>
                            {{ date('d-m-Y h:i A', strtotime($order->created_at)) }}
                        </td>
                        <td class="text-center">
                            {{ count($order->orderDetails) }}
                        </td>
                       
                        <td>
                            {{ single_price($order->grand_total) }}
                        </td>
                        <td>
                            @php
                                $shopname = 'Not Assigned';
                                if($order->shop_id != null){
                                    $shopname = $order->shop->name;
                                }
                            @endphp
                            
                            {{ $shopname }}
                        </td>
                        <td class="text-center">
                            @php
                                $status = $order->delivery_status;
                                if($order->delivery_status == 'cancelled') {
                                    $status = '<span class="badge badge-inline badge-danger">'.translate('Cancel').'</span>';
                                }

                            @endphp
                            {!! ucfirst(str_replace('_', ' ', $status)) !!}
                        </td>
                        <!--<td class="text-center">-->
                        <!--    @if ($order->payment_status == 'paid')-->
                        <!--    <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>-->
                        <!--    @else-->
                        <!--    <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>-->
                        <!--    @endif-->
                        <!--</td>-->
                      
                        <td class="text-center">
                            <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('sales_orders.show', encrypt($order->id))}}" title="View">
                                <i class="las la-eye"></i>
                            </a>
                            <a class="btn btn-soft-info btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}" title="Download Invoice">
                                <i class="las la-download"></i>
                            </a>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="aiz-pagination">
                {{ $orders->appends(request()->input())->links() }}
            </div>

        </div>
    </form>
</div>

@endsection

@section('modal')
    @include('modals.delete_modal')
@endsection

@section('styles')
    <style>
    .status_indicator {
        margin: 0px 0px 20px;
        padding: 0;
        list-style: none;
    }
    .status {

        &.completed:before {
            background-color: #03ff0338;
            border-color: #78D965;
            box-shadow: 0px 0px 4px 1px #94E185;
        }

        &.picked_up:before {
            background-color: #e9ae004f;
            border-color: #FFB161;
            box-shadow: 0px 0px 4px 1px #FFC182;
        }

        &.cancelled:before {
            background-color: #e756568a;
            border-color: #e51e1e8a;
            box-shadow: 0px 0px 4px 1px #a61d1d8a;
        }

        &.cancel_requested:before {
            background-color: #ffbebe7a;
            border-color: #e147477a;
            box-shadow: 0px 0px 4px 1px #ee64647a;
        }
        &:before {
            content: ' ';
            display: inline-block;
            width: 25px;
            height: 12px;
            margin-right: 10px;
            border: 1px solid #000;
        }
    }
    </style>
@endsection

@section('script')
    <script type="text/javascript">

      
    </script>
@endsection
