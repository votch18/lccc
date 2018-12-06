<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-table"></i> FUNDS BY MEMBER
        <div class="pull-right">

        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive">

<?php if (count($this->data['data']) > 0 ) { ?>
    <!-- Example DataTables Card-->

                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                    <thead>
                    <tr>
                        <th>ID#</th>
                        <th>Name</th>
                        <th style="width: 160px; text-align: right;">CBU</th>
                        <th style="width: 160px; text-align: right;">WP</th>
                        <th style="width: 160px; text-align: right;">ICI</th>
                        <th style="width: 160px; text-align: right;">Membership</th>
                        <th style="width: 165px;">Action</th>
                    </tr>

                    </thead>
                    <tbody>
                    <?php foreach ($this->data['data'] as $res) { ?>
                        <tr>
                            <td><?=$res['member_id'] ?></td>
                            <td><?=$res['member'] ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['CBU']) ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['WP']) ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['ICI']) ?></td>
                            <td style="text-align: right;"><?=Util::n_format($res['membership']) ?></td>
                            <td>
                                <a href="/admin/members/edit/<?=$res['member_id']?>" title="Edit" class="btn btn-primary btn-xs"><i class="fa fa-edit fa-lg"></i></a>
                                <a class="btn btn-success" data-toggle="modal" data-target="#addFundsModal" style="color: #ffffff;" onclick="$('#member_id').val('<?=$res['member_id']?>'); $('#name').val('<?=$res['member']?>') ">
                                    <i class="fa fa-fw fa-area-chart"></i> Add Funds</a>
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>
                </table>


<?php } else { Session::setFlash("No record found!"); } ?>

        </div>
    </div>

</div>



<!-- Add Funds Modal-->
<div class="modal fade" id="addFundsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD FUNDS</h5>
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
                                <input type="text" class="form-control" name="member" placeholder="Member Name" required="" id="name">
                            </div>
                        </div>

                    </div>

                    <div class="row row-sm-offset">

                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="gender">Funds Type*</label>
                                <select name="fund_id" class="form-control" required="">
                                    <?php
                                    $fund = new Fund();
                                    $category = $fund->getFundType();
                                    foreach ($category as $res) { ?>
                                        <option value="<?= $res['lid']?>"><?= $res['description']?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-6">
                            <div class="form-group">
                                <label for="gender">Amount*</label>
                                <input type="number" class="form-control" name="amount" placeholder="Amount"  value="" required="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">CANCEL</button>
                    <input type="submit" class="btn btn-primary" value="SAVE">
                </div>
            </form>
        </div>
    </div>
</div>