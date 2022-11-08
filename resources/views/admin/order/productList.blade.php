@extends('admin.layouts.master')

@section('title', ' User Order List Table')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="table-responsive table-responsive-data2">

                        <a href="{{ route('admin#orderList') }}" class="text-dark"><i class="fa-solid fa-arrow-left-long me-2"></i>Back</a>
                        <div class="card mt-4">
                            <div class="cart-header col-3 my-3" style="border-bottom: 1px solid black">
                                <h4><i class="fa-solid fa-clipboard me-3"></i>Order Info </h4>
                                <small class="text-warning my-3 "> <i class="fa-solid fa-triangle-exclamation"></i>Include Delivery Charges</small>
                            </div>
                            <div class="card-body col-4">
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-user me-2"></i> Customer Name </div>
                                    <div class="col"> {{ strtoupper($orderList[0]->user_name) }} </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-barcode me-2"></i> Oder Code </div>
                                    <div class="col"> {{ $orderList[0]->orderCode }} </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-regular fa-clock me-2"></i> Order Date </div>
                                    <div class="col"> {{ $orderList[0]->created_at->format('F-j-Y') }} </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-money-bill-wave me-2"></i> Total Price </div>
                                    <div class="col"> {{ $order->total_price }} Kyats </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-data2 text-center">
                            <thead>
                                 <tr>
                                    <th class=" text-primary font-weight-bold">Product Image</th>
                                    <th class=" text-primary font-weight-bold">Product Name</th>
                                    <th class=" text-primary font-weight-bold">Order Date</th>
                                    <th class=" text-primary font-weight-bold">Qty</th>
                                    <th class=" text-primary font-weight-bold">Amount</th>
                                </tr>
                            </thead>

                            <tbody id='datalist'>
                                @foreach ($orderList as $ol)
                                <tr class="tr-shadow">
                                    <td class=" text-info font-weight-bold"> <img src="{{ asset('storage/'.$ol->product_image) }}" style="height: 100px;" class=" img-thumbnail  shadow-sm" alt=""> </td>
                                    <td class=" text-info font-weight-bold"> {{ $ol->product_name }} </td>
                                    <td class=" text-info font-weight-bold"> {{ $ol->created_at->format('F-j-Y') }} </td>
                                    <td class=" text-info font-weight-bold"> {{ $ol->qty }} </td>
                                    <td class=" text-info font-weight-bold"> {{ $ol->total }} Kyats</td>
                                </tr>
                                <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

