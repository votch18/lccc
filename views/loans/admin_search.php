
    <!-- Example DataTables Card-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> LIST OF LOANS
        <div class="pull-right">
          
               <a class="btn btn-info" href="/print/loans/">
                <i class="fa fa-fw fa-print"></i> Print</a>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php if (count($this->data['data']) > 0 ) { ?>

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Terms</th>
                        <th>Principal</th>
                        <th>Deductions</th>
                        <th>Net Proceed</th>
                        <th>Monthly</th>
                        <th>Status</th>
                        <th style="width: 80px;">Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php foreach ($this->data['data'] as $res) { ?>
                        <tr>
                            <td><?=$res['member_id'] ?></td>
                            <td><?=$res['name'] ?></td>
                            <td><?=$res['type'] ?></td>
                            <td><?=$res['terms'] ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['principal']) ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['deductions']) ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['net_proceed']) ?></td> 
                            <td style="text-align: right;"><?=Util::n_format($res['monthly']) ?></td> 
                            <td style="text-align: center;"><?=$res['status'] == 0 ? '<span class="btn btn-warning">PENDING</span>' : '<span class="btn btn-info">OPEN</span>' ?></td> 
                            <td>
                            <?php if ($res['status'] == 1) {?>
                                <a href="/admin/loans/schedule/<?=$res['loan_id']?>/<?=$res['member_id']?>" title="View" class="btn btn-primary btn-xs"><i class="fa fa-eye fa-lg"></i></a>
                            <?php } else {?>
                                <a href="/admin/loans/deductions/<?=$res['loan_id']?>/<?=$res['member_id']?>" title="Proceed" class="btn btn-primary btn-xs"><i class="fa fa-arrow-right fa-lg"></i></a>
                            <?php } ?>
                                <a href="/admin/loans/delete/<?=$res['loan_id']?>" title="Delete" class="btn btn-danger btn-xs" onclick="return confirmDelete('Are you sure you want to deactivate this account?');"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>
            <?php } else { Session::setFlash("No record found!"); } ?>

        </div>
    </div>

</div>

<!-- Search Funds Modal-->
<div class="modal fade" id="addLoanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">SELECT CUSTOMER</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="member_id" id="member_id" />
                    <div class="row row-sm-offset">

                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label for="member_id">Member Name*</label>
                                <input type="text" class="form-control" name="member" placeholder="Member Name" required="" id="name" >
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-12">
                            <div id="search_result" style="height: 300px;"></div>
                        </div>

                    </div>

                
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">CANCEL</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

$( "#name" ).keyup(function() {
    
    //alert('shit');
    ajaxFn($( "#name" ).val());


});

var timeOutId = 0;
var ajaxFn = function (str) {
    $.ajax({
        url: "/ajax/loans/?q=" + str,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        type: "GET",
        success: function (response) {
            if (response) {
                
                console.log(response);
                console.log(response["member_id"]);
                var datas = response;

                var content = "<table class ='table table-responsive col-xs-12 col-md-12'>";
                var x = 0;
                $.each(datas, function() {
                    content += '<tr><td>' + datas[x].member_id +' ' + datas[x].name + '</td><td><a href="/admin/loans/application/' + datas[x].member_id + '" class="btn btn-success">SELECT</a></td></tr>';
                    x++;
                });
                content += "</table>";

                $("#search_result").html('' + content + '');
            } else {
                //do nothing baby
            }
        }
    });
}


});

</script>