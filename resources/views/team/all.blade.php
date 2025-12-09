@extends('admin.layout')

@section('content')
<div class="container">
    <div class="page-inner">

        <div class="page-header">
            <h3 class="fw-bold mb-3">All Team (Binary Downline)</h3>
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
                    <a href="#">All Team</a>
                </li>
            </ul>
        </div>

        {{-- Filters --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-2">
                        <label class="form-label">Position</label>
                        <select name="position" class="form-select">
                            <option value="">All</option>
                            <option value="left"  {{ request('position')=='left' ? 'selected' : '' }}>Left</option>
                            <option value="right" {{ request('position')=='right' ? 'selected' : '' }}>Right</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Level</label>
                        <input type="number" min="0" name="level" class="form-control"
                               value="{{ request('level') }}" placeholder="e.g. 1">
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary me-2" type="submit">Filter</button>
                        <a href="{{ route('team.all') }}" class="btn btn-light">Reset</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Your Downline</h4>
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
                                <th>Position</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Joined At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($downline as $index => $node)
                                @php $member = $node->user; @endphp
                                <tr>
                                    <td>{{ $downline->firstItem() + $index }}</td>
                                    <td>{{ $member->name ?? 'N/A' }}</td>
                                    <td>{{ $member->user_code ?? '-' }}</td>
                                    <td>{{ $member->email ?? '-' }}</td>
                                    <td>{{ ucfirst($node->position) }}</td>
                                    <td>{{ $node->level }}</td>
                                    <td>
                                        @if(($member->status ?? '') === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ isset($member->status) ? ucfirst($member->status) : 'N/A' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ optional($member->created_at)->format('d/m/Y, g:i a') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No team members found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $downline->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection