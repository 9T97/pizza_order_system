@extends('admin.layouts.master')

@section('title', 'Order List')

@section('content')
     <!-- MAIN CONTENT-->
     <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    {{-- <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>

                    </div>

                    @if (session('deleteSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger"> {{ request('key') }}</span> </h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('product#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search..." value="{{ request('key') }}" autocomplete="off">
                                    <button class="btn btn-dark" type="submit"  data-toggle="tooltip" data-placement="bottom" title="Search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div> --}}

                    <div class="row mt-2">
                        <div class="col col-6 d-flex">
                            <div class="col-4">
                                <label for="" class="mt-2 me-4">Order Status</label>
                            </div>
                            <form action="{{ route('admin#changeStatus') }}" method="get">
                                @csrf
                                <div class="col  d-flex">
                                    <select name="orderStatus" id="orderStatus" class="form-control col-8 text-info font-weight-bold">
                                        <option value="">All</option>
                                        <option value="0" @if (request('orderStatus') == '0' ) selected @endif>Pending</option>
                                        <option value="1" @if (request('orderStatus') == '1' ) selected @endif>Accept</option>
                                        <option value="2" @if (request('orderStatus') == '2' ) selected @endif>Reject</option>
                                    </select>
                                    <button type="submit" class="btn btn-dark btn-sm text-white ms-3"><i class="fa-solid fa-magnifying-glass me-2"></i>Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="bg-dark col-1 offset-4 bg-white shadow-sm p-2 text-center" data-toggle="tooltip" title="Total Count" data-placement="bottom">
                            <h4><i class="fa-solid fa-database me-2"></i>  {{ count($order)}} </h4>
                        </div>
                    </div>

                    @if (count($order) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody id='datalist'>
                                    @foreach ($order as $o)
                                    <tr class="tr-shadow">
                                        <input type="hidden" name="" class="orderId" value="{{ $o->id }}">
                                        <td class=" text-info font-weight-bold"> {{ $o->user_id }} </td>
                                        <td class=" text-info font-weight-bold"> {{ $o->user_name }} </td>
                                        <td class=" text-info font-weight-bold"> {{ $o->created_at->format('F-j-Y') }} </td>
                                        <td class=" text-info font-weight-bold">
                                            <a href="{{ route('admin#listInfo',$o->order_code) }}"> {{ $o->order_code }} </a>
                                        </td>
                                        <td class=" text-info font-weight-bold" id="amount"> {{ $o->total_price }} Kyats</td>
                                        <td class=" text-info font-weight-bold">
                                            <select name="status" id="" class="form-control statusChange text-info font-weight-bold">
                                                <option value="0" @if ($o->status == 0 ) selected @endif><i class="text-warning">Pending</i></option>
                                                <option value="1" @if ($o->status == 1 ) selected  @endif>Accept</option>
                                                <option value="2" @if ($o->status == 2 ) selected  @endif>Reject</option>

                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{-- {{ $order->links() }} --}}
                            </div>
                        </div>
                    <!-- END DATA TABLE -->
                @else
                    <h3 class="text-center text-secondary mt-5">There is no Order Here!</h3>
                @endif
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
<script>
    $(document).ready(function(){
        // $('#orderStatus').change(function(){
        //     $status = $('#orderStatus').val();
        //     console.log($status);
        //     $.ajax({
        //         type : 'get',
        //         url : '/order/ajax/status',
        //         data : { 'status' : $status },
        //         dataType : 'json',
        //         success : function(response){

        //             $list = '';
        //             for($i=0;$i<response.length;$i++){


        //                 $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        //                 //append data datetime
        //                 $dbDate = new Date(response[$i].created_at);

        //                 $dateTime = $months[$dbDate.getMonth()] +"-"+ $dbDate.getDate() +"-"+ $dbDate.getFullYear();

        //                 if(response[$i].status == 0 ){
        //                     $statusMessage = `
        //                         <select name="status" id="" class="form-control statusChange">
        //                              <option value="0" selected>Pending</option>
        //                             <option value="1">Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>
        //                         `;
        //                 } else if ( response[$i].status == 1 ){
        //                     $statusMessage = `
        //                         <select name="status" id="" class="form-control statusChange">
        //                             <option value="0">Pending</option>
        //                             <option value="1" selected>Accept</option>
        //                             <option value="2">Reject</option>
        //                         </select>

        //                         `;
        //                 } else if ( response[$i].status == 2 ){
        //                     $statusMessage = `
        //                         <select name="status" id="" class="form-control statusChange">
        //                             <option value="0">Pending</option>
        //                             <option value="1">Accept</option>
        //                             <option value="2" selected>Reject</option>
        //                         </select>
        //                         `;
        //                 }

        //                 $list += `
        //                 <tr class="tr-shadow">
        //                     <input type="hidden" name="" class="orderId" value="${response[$i].id}">
        //                     <td class=" text-info font-weight-bold"> ${response[$i].user_id} </td>
        //                     <td class=" text-info font-weight-bold"> ${response[$i].user_name} </td>
        //                     <td class=" text-info font-weight-bold"> ${$dateTime} </td>
        //                     <td class=" text-info font-weight-bold"> ${response[$i].order_code} </td>
        //                     <td class=" text-info font-weight-bold" id=""> ${response[$i].total_price} Kyats</td>
        //                     <td class=" text-info font-weight-bold">${ $statusMessage } </td>
        //                 </tr>
        //                 <tr class="spacer"></tr>
        //                 `;
        //             }
        //             $('#datalist').html($list);
        //         }
        //     });
        // })

        // change status
        $('.statusChange').change(function(){

            $currentStatus = $(this).val();
            // console.log($currentStatus);
            $parentNode = $(this).parents("tr");
            $orderId = $parentNode.find('.orderId').val();

            $data = {
                'status' : $currentStatus,
                'orderId' : $orderId
            };
            $.ajax({
                type : 'get',
                url : '/order/ajax/change/status',
                data : $data ,
                dataType : 'json',
            });
            location.reload();

        })
    })
</script>

@endsection
