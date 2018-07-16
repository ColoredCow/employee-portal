<ul class="nav nav-pills">
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/volunteers/opportunities*') ? 'active' : '' }}" href="{{ route('volunteer.opportunities') }}"><i class="fa fa-list-ul"></i>&nbsp;Projects</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ $requestRoute == 'volunteer.applications.index' ? 'active' : '' }}" href="{{ route('volunteer.applications.index') }}"><i class="fa fa-users"></i>&nbsp;Applications</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/volunteers/reports*') ? 'active' : '' }}" href="{{ route('volunteers.reports') }}"><i class="fa fa-pie-chart"></i>&nbsp;Reports</a>
    </li>
    <li class="nav-item">
        <a class="nav-item nav-link {{ Request::is('hr/volunteers/campaigns*') ? 'active' : '' }}" href="{{ route('volunteers.campaigns') }}"><i class="fa fa-envelope"></i>&nbsp;Campaigns</a>
    </li>
</ul>
