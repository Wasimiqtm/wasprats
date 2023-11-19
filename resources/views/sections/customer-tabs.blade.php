<div class="row">
    <div class="card-body">
        <ul class="nav nav-pills mb-4 bg-white" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link text-uppercase {{ $tab == 'active' ? 'active' : '' }}"
                    href="{{ route('customers.jobs', [$customer->uuid, 'tab' => 'active']) }}">Active Jobs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase {{ $tab == 'completed' ? 'active' : '' }}"
                    href="{{ route('customers.jobs', [$customer->uuid, 'tab' => 'completed']) }}">Completed Jobs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase {{ $tab == 'canceled' ? 'active' : '' }}"
                    href="{{ route('customers.jobs', [$customer->uuid, 'tab' => 'canceled']) }}">Canceled Jobs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-uppercase {{ $tab == 'locations' ? 'active' : '' }}"
                    href="{{ route('customers.locations', [$customer->uuid, 'tab' => 'locations']) }}">Locations</a>
            </li>
        </ul>
    </div>
</div>