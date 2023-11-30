<!DOCTYPE html>
<html>
<head>
    <title>Generate Invoice</title>
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
</style>
<body>
<div class="head-title">
    <h1 class="text-center m-0 p-0">Job Confirmation</h1>
</div>
<div class="add-detail mt-10">
    <div class="w-50 float-left mt-10">
        <p class="m-0 pt-5 text-bold w-100">Job Id - <span class="gray-color">#{{$displayData['id']}}</span></p>
        <p class="m-0 pt-5 text-bold w-100">Job Created At - <span class="gray-color">{{$displayData['created_at']}}</span></p>
    </div>
    <div style="clear: both;"></div>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Data</th>
            <th class="w-50">Time</th>
            <th class="w-50">Hours</th>
            <th class="w-50">Minutes</th>
            <th class="w-50">Repeat Frequency</th>
        </tr>
        <tr align="center">
                    <td>{{$displayData['date']}}</td>
                    <td>{{$displayData['time']}}</td>
                    <td>{{$displayData['hours']}}</td>             
                    <td>{{$displayData['minutes']}}</td>
                    <td>{{$displayData['repeat_frequency']}}</td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Confirmed Status</th>
            <th class="w-50">Customer Status</th>
        </tr>
        <tr align="center">
            <td>{{$displayData['confirmed']}}</td>
            <td>{{$displayData['customer_status']}}</td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Service Name</th>
            <th class="w-50">Customer</th>
            <th class="w-50">Customer Location</th>
            <th class="w-50">Technician</th>
            <th class="w-50">Total</th>
        </tr>
            <tr align="center" >
            <td>{{$displayData['service']}}</td>
            <td>{{$displayData['customer']}}</td>
            <td>{{$displayData['customer_location']}}</td>
            <td>{{$displayData['user']}}</td>
            <td>{{$displayData['total']}}</td>
        </tr>
    </table>
</div>
<div class="table-section bill-tbl w-100 mt-10">
    <table class="table w-100 mt-10">
        <tr>
            <th class="w-50">Note</th>
        </tr>
        <tr align="center">
            <td>{{$displayData['notes']}}</td>
        </tr>
    </table>
</div>
</html>