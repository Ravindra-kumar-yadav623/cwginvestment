@extends('admin.admin-layout')

@section('content')
<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div>
        <h3 class="fw-bold mb-3">Admin Dashboard</h3>
        <h6 class="op-7 mb-2">Capital Wealth Growth</h6>
      </div>
    </div>

    {{-- TOP CARDS: Withdraw & Deposit --}}
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-primary bubble-shadow-small">
                  <i class="fas fa-arrow-up"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Total Withdrawal</p>
                  <h4 class="card-title">
                    ${{ number_format($totalWithdrawalAmount, 2) }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-info bubble-shadow-small">
                  <i class="fas fa-clock"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">New Withdrawal (Pending)</p>
                  <h4 class="card-title">
                    ${{ number_format($pendingWithdrawalAmount, 2) }}
                  </h4>
                  <small class="text-muted">{{ $pendingWithdrawalCount }} request(s)</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-success bubble-shadow-small">
                  <i class="fas fa-arrow-down"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">New Deposit (Pending)</p>
                  <h4 class="card-title">
                    ${{ number_format($pendingDepositAmount, 2) }}
                  </h4>
                  <small class="text-muted">{{ $pendingDepositCount }} request(s)</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-icon">
                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                  <i class="far fa-check-circle"></i>
                </div>
              </div>
              <div class="col col-stats ms-3 ms-sm-0">
                <div class="numbers">
                  <p class="card-category">Total Deposit</p>
                  <h4 class="card-title">
                    ${{ number_format($totalDepositAmount, 2) }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- SECOND ROW: Income & Users --}}
    <div class="row row-card-no-pd">
      <div class="col-12 col-sm-6 col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6><b>Today's Income</b></h6>
                <p class="text-muted">All credit transactions today</p>
              </div>
              <h4 class="text-info fw-bold">
                ${{ number_format($todayIncome, 2) }}
              </h4>
            </div>
            <div class="progress progress-sm">
              <div class="progress-bar bg-info w-75" role="progressbar"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6><b>Total Revenue</b></h6>
                <p class="text-muted">All credit transactions</p>
              </div>
              <h4 class="text-success fw-bold">
                ${{ number_format($totalRevenue, 2) }}
              </h4>
            </div>
            <div class="progress progress-sm">
              <div class="progress-bar bg-success w-50" role="progressbar"></div>
            </div>
          </div>
        </div>
      </div>              

      <div class="col-12 col-sm-6 col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6><b>New Users (Today)</b></h6>
                <p class="text-muted">Joined today</p>
              </div>
              <h4 class="text-secondary fw-bold">
                {{ $newUsersToday }}
              </h4>
            </div>
            <div class="progress progress-sm">
              <div class="progress-bar bg-secondary w-25" role="progressbar"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-6 col-xl-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h6><b>Total Users</b></h6>
                <p class="text-muted">All registered members</p>
              </div>
              <h4 class="text-warning fw-bold">
                {{ $totalUsers }}
              </h4>
            </div>
            <div class="progress progress-sm">
              <div class="progress-bar bg-warning w-50" role="progressbar"></div>
            </div>
          </div>
        </div>
      </div> 
    </div>

    {{-- THIRD ROW: Misc business stats --}}
    <div class="row">
      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="icon-pie-chart text-warning"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Total Deposits</p>
                  <h4 class="card-title">{{ $totalDepositsCount }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="icon-wallet text-success"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Sponsor Income Paid</p>
                  <h4 class="card-title">
                    ${{ number_format($totalSponsorIncome, 2) }}
                  </h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="icon-close text-danger"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Rejected Requests</p>
                  <h4 class="card-title">{{ $rejectedCount }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3">
        <div class="card card-stats card-round">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center">
                  <i class="icon-user-following text-primary"></i>
                </div>
              </div>
              <div class="col-7 col-stats">
                <div class="numbers">
                  <p class="card-category">Active Users</p>
                  <h4 class="card-title">{{ $activeUsers }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection