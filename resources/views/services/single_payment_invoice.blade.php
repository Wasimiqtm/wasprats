<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<style type="text/css">
    body{
        font-family: 'Roboto Condensed', sans-serif;
    }
    .m-0{
        margin: 0px;
    }
    .p-0{
        padding: 0px;
    }
    .pt-5{
        padding-top:5px;
    }
    .mt-10{
        margin-top:10px;
    }
    .text-center{
        text-align:center !important;
    }
    .w-100{
        width: 100%;
    }
    .w-50{
        width:50%;
    }
    .w-85{
        width:85%;
    }
    .w-15{
        width:15%;
    }
    .logo img{
        width:200px;
        height:60px;
    }
    .gray-color{
        color:#5D5D5D;
    }
    .text-bold{
        font-weight: bold;
    }
    .border{
        border:1px solid black;
    }
    table tr,th,td{
        border: 1px solid #d2d2d2;
        border-collapse:collapse;
        padding:7px 8px;
    }
    table tr th{
        background: #F4F4F4;
        font-size:15px;
    }
    table tr td{
        font-size:13px;
    }
    table{
        border-collapse:collapse;
    }
    .box-text p{
        line-height:10px;
    }
    .float-left{
        float:left;
    }
    .total-part{
        font-size:16px;
        line-height:12px;
    }
    .total-right p{
        padding-right:20px;
    }
    .left-side {
      background-color: white;
      width: 200px;
      height: 100px;
      border: 1px solid grey;
      padding: 50px;
      margin: 20px;
    }
    #wrapper {
        overflow: hidden;
        background-color: lightgrey;
    }
    #c1 {
       float:left;
    }
    #c2 {
        float: right
    }
</style>
<body onload="window.print()">
<div class="head-title">
    <h1 class="text-center m-0 p-0">Invoice</h1>
    <div><img width="100" height="100" src="{{ asset('/uploads/print_logo.jpeg') }}"></div>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Invoice Id - <span class="gray-color"># {{$servicePayment->id}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Created At - <span class="gray-color">{{$servicePayment->created_at}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Order Date - <span class="gray-color">{{$servicePayment->date}}</span></p>
    </div>
    <div class="w-50 float-left logo mt-10">
        <!-- <img src="https://techsolutionstuff.com/frontTheme/assets/img/logo_200_60_dark.png" alt="Logo"> -->
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Service Name</th>
            <th class="w-50">Customer</th>
            <th class="w-50">Technician</th>
            <th class="w-50">Payment Mode</th>
            <th class="w-50">Total</th>
            <th class="w-50">Amount Paid</th>
        </tr>
        <tr align="center">
                <!-- <div class="box-text"> -->
                    <td>{{$servicePayment->service->name}}</td>
                    <td>{{$servicePayment->customer->first_name}} {{$servicePayment->customer->last_name}}</td>
                    <td>{{$servicePayment->user->first_name}} {{$servicePayment->user->last_name}}</td>
                    <td>{{$servicePayment->payment_mode}}</td>
                    <td>{{$servicePayment->service->service_amount}}</td>
                    <td>{{$servicePayment->amount}}</td>
                <!-- </div> -->
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Description</th>
            <td class="w-50">{{$servicePayment->description}}</td>
        </tr>
        <tr>
            <th>Used Things</th>
            <td>
            @if(count($servicePayment->usedItems) > 1)
                @foreach($servicePayment->usedItems as $item)
                    <p>{{$item}}</p>
                @endforeach
            @else
                <p>Not Found</p>
            @endif

         </td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <td colspan="7">
                <div class="total-part">
                    <div class="total-left w-85 float-left" align="right">
                        <p>Amount</p>
                        <p>Vat (20%)</p>
                        <p>Total amount</p>
                        <p>Amount paid</p>
                        <p>Remaining Amount</p>
                    </div>
                    <div class="total-right w-15 float-left text-bold" align="right">
                        <p>{{$servicePayment->service->service_amount}}</p>
                        <p>{{$servicePayment->staticVat}}</p>
                        <p>{{$servicePayment->newAmount}}</p>
                        <p>{{$servicePayment->amount}}</p>
                        <p>{{$servicePayment->remainingAmount}}</p>
                    </div>
                    <div style="clear: both;"></div>
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <td class="w-50"><h3 align="center">Technician Signature</h3></td>
            <td class="w-50"><h3 align="center">Customer Signature</h3></td>
        </tr>
        <tr>
            <th class="left-side"></th>
            <th class="left-side"></th>

         </td>
        </tr>
    </table>
</div>
{{-- <script type="text/javascript">
            $(document).ready(function() {
                window.print();
            });
</script> --}}
</body>
</html>
