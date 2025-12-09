@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="page-header">
            <h3 class="fw-bold mb-3">Direct Team</h3>
            <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Direct Team</a>
                </li>
            </ul>
        </div>

        {{-- Filters --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="active"   {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Search</label>
                        <input type="text" name="search" class="form-control"
                               value="{{ request('search') }}"
                               placeholder="Name / User Code / Email">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">From</label>
                        <input type="date" name="from_date" class="form-control"
                               value="{{ request('from_date') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">To</label>
                        <input type="date" name="to_date" class="form-control"
                               value="{{ request('to_date') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary me-2" type="submit">Filter</button>
                        <a href="{{ route('team.direct') }}" class="btn btn-light">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Your Direct Referrals</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables"
                        class="display table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>User Code</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Joined At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($directTeam as $index => $member)
                                <tr>
                                    <td>{{ $directTeam->firstItem() + $index }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->user_code }}</td>
                                    <td>{{ $member->email }}</td>
                                    <td>{{ $member->mobile }}</td>
                                    <td>{{ $member->country }}</td>
                                    <td>
                                        @if($member->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($member->status) }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $member->created_at->format('d/m/Y, g:i a') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No direct team members found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $directTeam->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection