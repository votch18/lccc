    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title" >
                                <h1>LCCC</h1>
                                <p>
                                    Purok 5, Lapinigan,<br>
                                    San Francisco, Agusan del Sur
                                </p>
                            </td>
                            
                            <td>
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="5">
                    <h2 style="text-align: center; margin: 10px;">LIST OF PAYMENTS</h2>
                </td>
            </tr>
      
            <tr class="heading">
                <td>Name</td>
                <td>Loan ID#</td>
                <td>Date</td>
                <td class="right">Amount</td>
                <td class="right">Penalty</td>
            </tr>
					
        <?php foreach ($this->data['data'] as $res) { ?>
            <tr class="details">
                <td><?=$res['name'] ?></td>
                <td><?=$res['loan_id'] ?></td>
                <td><?=Util::d_format($res['dop']) ?></td>
                <td class="right"><?=Util::n_format($res['amount']) ?></td>
                <td class="right"><?=Util::n_format($res['penalty']) ?></td>  
            </tr>

        <?php } ?>

        

        </table>
    </div>

