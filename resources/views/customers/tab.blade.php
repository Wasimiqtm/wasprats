<ul class="nav nav-pills mb-4 bg-white" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='notes'?'active':''}}" href="{{route('customers.details', ['customer_id' =>request()->customer_id,'type'=>'notes'])}}">Notes</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='task'?'active':''}}" href="{{route('customers.details', ['customer_id' =>request()->customer_id,'type'=>'task'])}}">Tasks</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='jobs'?'active':''}}" href="{{route('customers.details', ['customer_id' =>request()->customer_id,'type'=>'jobs'])}}">Jobs</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='invoices'?'active':''}}" href="{{route('customers.details', ['customer_id' =>request()->customer_id,'type'=>'invoices'])}}">Invoices</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='estimate'?'active':''}}" href="{{route('customers.details', ['customer_id' =>request()->customer_id,'type'=>'estimate'])}}">Estimate</a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='payments'?'active':''}}" href="{{route('customers.details', ['customer_id' =>request()->customer_id,'type'=>'payments'])}}">Payments</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='credit'?'active':''}}" href="{{route('customers.details', ['customer_id' =>request()->customer_id,'type'=>'credit'])}}">Credit</a>
    </li>
</ul>
