  @extends('admin.layout')

  @section('content')
  <div class="container">
    <div class="page-inner">
      <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
          <h3 class="fw-bold mb-3">Dashboard</h3>
          <h6 class="op-7 mb-2">Capital Wealth Growth</h6>
        </div>
        <div class="ms-md-auto py-2 py-md-0">
          <!-- START -->
          <div class="d-flex mb-3">
            <div class="input-group mb-3 input-primary">
              <input name="ctl00$ContentPlaceHolder1$txtLink" type="text" value="http://cwg.za/signup?referral=CWG897156" id="ctl00_ContentPlaceHolder1_txtLink" class="form-control">
              <a onclick="CopyToClipboard1()" class="input-group-text">Copy Referral Link</a>
            </div>
          </div>
          <!-- END -->
        </div>
        <div class="ms-md-auto py-2 py-md-0">
          <a href="./deposit.html" class="btn btn-primary btn-round">Deposit</a>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="card card-stats card-round">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-icon">
                  <div class="icon-big text-center icon-primary bubble-shadow-small">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Income Wallet</p>
                    <h4 class="card-title">$20</h4>
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
                    <i class="fas fa-user-check"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Pokect Wallet</p>
                    <h4 class="card-title">$100</h4>
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
                    <i class="fas fa-luggage-cart"></i>
                  </div>
                </div>
                <div class="col col-stats ms-3 ms-sm-0">
                  <div class="numbers">
                    <p class="card-category">Total Income</p>
                    <h4 class="card-title">$ 30</h4>
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
                    <p class="card-category">Total Withdrawal</p>
                    <h4 class="card-title">$ 10</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- start-->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Sukhdev Gupta</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">

                <div class="row">
                  <div class="col-sm-12">
                    <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="basic-datatables_info">
                      <tr role="row" class="odd">
                        <td class="sorting_1">Member Id</td>
                        <td>CWG897156</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Active Status</td>
                        <td>Active</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">CWG Investment</td>
                        <td>$ 4012</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Rank</td>
                        <td>Silver</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Active Date</td>
                        <td>21/11/2025 02:57:31 PM</td>
                      </tr>
                    </table>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end-->


      <!-- start-->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Business Details</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">

                <div class="row">
                  <div class="col-sm-12">
                    <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="basic-datatables_info">
                      <tr role="row" class="odd">
                        <td class="sorting_1">Direct Team</td>
                        <td>5</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">CWG Investment</td>
                        <td>$ 500</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Current CWG Investment(Left/Right)</td>
                        <td>$500/$570</td>
                      </tr>
                      <tr role="row" class="odd">
                        <td class="sorting_1">Total CWG Investment(Left/Right)</td>
                        <td>$500/$570</td>
                      </tr>
                    </table>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end-->


      <div class="row">
        <div class="col-md-12">
          <div class="card card-round">
            <div class="card-header">
              <div class="card-head-row card-tools-still-right">
                <h4 class="card-title">Users Geolocation</h4>
                <div class="card-tools">
                  <button class="btn btn-icon btn-link btn-primary btn-xs">
                    <span class="fa fa-angle-down"></span>
                  </button>
                  <button class="btn btn-icon btn-link btn-primary btn-xs btn-refresh-card">
                    <span class="fa fa-sync-alt"></span>
                  </button>
                  <button class="btn btn-icon btn-link btn-primary btn-xs">
                    <span class="fa fa-times"></span>
                  </button>
                </div>
              </div>
              <p class="card-category"> Map of the distribution of users around the world </p>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="table-responsive table-hover table-sales">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/id.png" alt="indonesia" />
                            </div>
                          </td>
                          <td>Indonesia</td>
                          <td class="text-end">2.320</td>
                          <td class="text-end">42.18%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/us.png" alt="united states" />
                            </div>
                          </td>
                          <td>USA</td>
                          <td class="text-end">240</td>
                          <td class="text-end">4.36%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/au.png" alt="australia" />
                            </div>
                          </td>
                          <td>Australia</td>
                          <td class="text-end">119</td>
                          <td class="text-end">2.16%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/ru.png" alt="russia" />
                            </div>
                          </td>
                          <td>Russia</td>
                          <td class="text-end">1.081</td>
                          <td class="text-end">19.65%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/cn.png" alt="china" />
                            </div>
                          </td>
                          <td>China</td>
                          <td class="text-end">1.100</td>
                          <td class="text-end">20%</td>
                        </tr>
                        <tr>
                          <td>
                            <div class="flag">
                              <img src="assets/img/flags/br.png" alt="brazil" />
                            </div>
                          </td>
                          <td>Brasil</td>
                          <td class="text-end">640</td>
                          <td class="text-end">11.63%</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mapcontainer">
                    <div id="world-map" class="w-100" style="height: 300px"></div>
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