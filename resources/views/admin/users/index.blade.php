@extends('admin.admin-layout')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="page-header">
            <h3 class="fw-bold mb-3">User Management</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator"><i class="icon-arrow-right"></i></li>
                <li class="nav-item"><a href="#">Users</a></li>
            </ul>
        </div>

        {{-- Top stats --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category mb-1">Total Users</p>
                            <h4 class="card-title mb-0">{{ $totalUsers }}</h4>
                        </div>
                        <div class="icon-big text-center icon-primary bubble-shadow-small">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category mb-1">Active Users</p>
                            <h4 class="card-title mb-0">{{ $activeUsers }}</h4>
                        </div>
                        <div class="icon-big text-center icon-success bubble-shadow-small">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-stats card-round">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <p class="card-category mb-1">Inactive Users</p>
                            <h4 class="card-title mb-0">{{ $inactiveUsers }}</h4>
                        </div>
                        <div class="icon-big text-center icon-secondary bubble-shadow-small">
                            <i class="fas fa-user-slash"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filters --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2">

                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               value="{{ request('search') }}"
                               placeholder="Name / User Code / Email / Mobile">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="active"   {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="blocked"  {{ request('status')=='blocked' ? 'selected' : '' }}>Blocked</option>
                            <option value="pending"  {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select">
                            <option value="">All</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->slug }}"
                                    {{ request('role') == $role->slug ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Country</label>
                        <select name="country" class="form-select">
                            <option value="">All</option>
                            @foreach($countries as $code => $label)
                                <option value="{{ $label }}"
                                    {{ request('country') == $label ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">From</label>
                        <input type="date"
                               name="date_from"
                               class="form-control"
                               value="{{ request('date_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">To</label>
                        <input type="date"
                               name="date_to"
                               class="form-control"
                               value="{{ request('date_to') }}">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Users table --}}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Users</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name / User Code</th>
                                <th>Username</th>
                                <th>Email / Mobile</th>
                                <th>Country</th>
                                <th>Sponsor</th>
                                <th>Roles</th>
                                <th>Status</th>
                                <th>Joined At</th>
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $u)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>

                                    <td>
                                        <strong>{{ $u->name }}</strong><br>
                                        <small class="text-muted">Code: {{ $u->user_code }}</small>
                                    </td>

                                    <td>{{ $u->username }}</td>

                                    <td>
                                        {{ $u->email }}<br>
                                        <small class="text-muted">{{ $u->mobile }}</small>
                                    </td>

                                    <td>{{ $u->country }}</td>

                                    <td>
                                        @if($u->sponsor)
                                            {{ $u->sponsor->name }}<br>
                                            <small class="text-muted">Code: {{ $u->sponsor->user_code }}</small>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>
                                        @foreach($u->roles as $role)
                                            <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                        @endforeach
                                    </td>

                                    <td>
                                        @if($u->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($u->status === 'inactive')
                                            <span class="badge bg-secondary">Inactive</span>
                                        @elseif($u->status === 'blocked')
                                            <span class="badge bg-danger">Blocked</span>
                                        @else
                                            <span class="badge bg-warning text-dark">{{ ucfirst($u->status) }}</span>
                                        @endif
                                    </td>

                                    <td>{{ $u->created_at->format('d/m/Y, g:i a') }}</td>

                                    {{-- Actions column if you want later
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                    --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">
                                        No users found with current filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection