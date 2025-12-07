@extends('admin.layout')

@section('content')

@php
$activeTab = session('active_tab', 'profile');
@endphp

<div class="container">
    <div class="page-inner">

        {{-- Header card with name & country --}}
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $user->name }}</h4>
                    <p>{{ $user->country }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a href="#profile" data-bs-toggle="tab"
                                            class="nav-link {{ $activeTab == 'profile' ? 'active show' : '' }}">
                                            Profile
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#settings" data-bs-toggle="tab"
                                            class="nav-link {{ $activeTab == 'settings' ? 'active show' : '' }}">
                                            Change Profile Password
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#email" data-bs-toggle="tab"
                                            class="nav-link {{ $activeTab == 'email' ? 'active show' : '' }}">
                                            Update Email
                                        </a>
                                    </li>
                                </ul>


                                <div class="tab-content">

                                    {{-- PROFILE TAB --}}
                                    <div id="profile" class="tab-pane fade {{ $activeTab == 'profile' ? 'show active' : '' }}">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Edit Profile</h4>

                                                {{-- Success for profile --}}

                                                @if(session('success_profile'))
                                                    <div class="alert alert-success alert-dismissible fade show auto-hide-alert" role="alert">
                                                        {{ session('success_profile') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                {{-- Validation errors (global) --}}
                                                @if($errors->any())
                                                <div class="alert alert-danger alert-dismissible fade show auto-hide-alert">
                                                    <ul class="mb-0">
                                                        @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                @endif

                                                <form action="{{ route('profile.update') }}" method="POST">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Name <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                name="name"
                                                                value="{{ old('name', $user->name) }}"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                placeholder="Name">
                                                            @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="text"
                                                                value="{{ $user->email }}"
                                                                class="form-control"
                                                                readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Country <span class="text-danger">*</span></label>
                                                            <select name="country"
                                                                class="form-select @error('country') is-invalid @enderror">
                                                                <option value="">Select country--</option>
                                                                {{-- you can move this country list to a config/array later --}}
                                                                <option value="India" {{ old('country', $user->country) == 'India' ? 'selected' : '' }}>India</option>
                                                                <option value="United States" {{ old('country', $user->country) == 'United States' ? 'selected' : '' }}>United States</option>
                                                                <option value="United Kingdom" {{ old('country', $user->country) == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                                {{-- ... add rest of your countries here ... --}}
                                                            </select>
                                                            @error('country')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                name="mobile"
                                                                value="{{ old('mobile', $user->mobile) }}"
                                                                class="form-control @error('mobile') is-invalid @enderror">
                                                            @error('mobile')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">User Id</label>
                                                            <input type="text"
                                                                value="{{ $user->user_code }}"
                                                                class="form-control"
                                                                readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">User Name</label>
                                                            <input type="text"
                                                                value="{{ $user->username }}"
                                                                class="form-control"
                                                                readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">
                                                                Transaction Password <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group mb-3 input-primary">
                                                                <input type="password"
                                                                    name="transaction_password"
                                                                    class="form-control @error('transaction_password') is-invalid @enderror"
                                                                    placeholder="******">
                                                                <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                                                                @error('transaction_password')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- OTP UI (not wired yet) --}}
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">
                                                                One Time Password
                                                            </label>
                                                            <div class="input-group mb-3 input-primary">
                                                                <input type="text"
                                                                    class="form-control"
                                                                    placeholder="Enter One Time Password"
                                                                    disabled>
                                                                <button type="button" class="btn btn-secondary" disabled>Send OTP</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- EMAIL TAB --}}
                                    <div id="email" class="tab-pane fade {{ $activeTab == 'email' ? 'show active' : '' }}">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Update Email</h4>

                                                @if(session('success_email'))
                                                    <div class="alert alert-success alert-dismissible fade show auto-hide-alert" role="alert">
                                                        {{ session('success_email') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                <form action="{{ route('profile.email') }}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label">New Email <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                name="email"
                                                                value="{{ old('email', $user->email) }}"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                placeholder="hello@example.com">
                                                            @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">
                                                                Transaction Password <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="input-group mb-3 input-primary">
                                                                <input type="password"
                                                                    name="transaction_password"
                                                                    class="form-control @error('transaction_password_email') is-invalid @enderror"
                                                                    placeholder="******">
                                                                <span class="input-group-text"><i class="fa fa-eye-slash"></i></span>
                                                                @error('transaction_password_email')
                                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        {{-- OTP UI placeholder --}}
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label">One Time Password</label>
                                                            <div class="input-group mb-3 input-primary">
                                                                <input type="text"
                                                                    class="form-control"
                                                                    placeholder="Enter One Time Password"
                                                                    disabled>
                                                                <button type="button" class="btn btn-secondary" disabled>Send OTP</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- CHANGE LOGIN PASSWORD TAB --}}
                                    <div id="settings" class="tab-pane fade {{ $activeTab == 'settings' ? 'show active' : '' }}">
                                        <div class="pt-3">
                                            <div class="settings-form">
                                                <h4 class="text-primary">Profile Password Setting</h4>

                                                @if(session('success_password'))
                                                    <div class="alert alert-success alert-dismissible fade show auto-hide-alert" role="alert">
                                                        {{ session('success_password') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                @endif

                                                <form action="{{ route('profile.password') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Password <span class="text-danger">*</span></label>
                                                        <input type="password"
                                                            name="current_password"
                                                            class="form-control @error('current_password') is-invalid @enderror"
                                                            placeholder="Current Password">
                                                        @error('current_password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">New Password <span class="text-danger">*</span></label>
                                                        <input type="password"
                                                            name="new_password"
                                                            class="form-control @error('new_password') is-invalid @enderror"
                                                            placeholder="New Password">
                                                        @error('new_password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                                        <input type="password"
                                                            name="new_password_confirmation"
                                                            class="form-control"
                                                            placeholder="Confirm Password">
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                </div>{{-- tab-content --}}
                            </div>{{-- custom-tab-1 --}}
                        </div>{{-- profile-tab --}}
                    </div>{{-- card-body --}}
                </div>{{-- card --}}
            </div>{{-- col --}}
        </div>{{-- row --}}

    </div>
</div>
@endsection