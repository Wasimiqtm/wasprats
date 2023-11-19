<ul class="nav nav-pills mb-4 bg-white" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='notes'?'active':''}}" href="{{route('users.get.active.jobs', ['id' =>request()->id,'type'=>'active'])}}">Active Jobs</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='task'?'active':''}}" href="{{route('users.get.active.jobs', ['id' =>request()->id,'type'=>'completed'])}}">Completed Jobs</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-uppercase {{request()->type ==='jobs'?'active':''}}" href="{{route('users.get.active.jobs', ['id' =>request()->id,'type'=>'canceled'])}}">Canceled Jobs</a>
    </li>

</ul>
