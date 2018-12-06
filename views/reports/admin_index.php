
<h1>Reports</h1>
<hr>

<?php if(Session::get('access') == "1") { ?>
    <!-- Icon Cards-->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-bed"></i>
                    </div>
                    <div class="mr-5">Room Inventory</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="/admin/reports/room_inventory/">
                    <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-money fa-fw"></i>
                    </div>
                    <div class="mr-5">Income</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="/admin/reports/income/">
                    <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-home fa-fw"></i>
                    </div>
                    <div class="mr-5">Cottages</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="/admin/reports/cottage_inventory/">
                    <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-bed fa-fw"></i>
                    </div>
                    <div class="mr-5">Check-in</div>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="/admin/reports/checkin_reports/">
                    <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
                </a>
            </div>
        </div>
    </div>


<?php } ?>