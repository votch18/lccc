<?php
$util = new Util();

?>

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
                    <h2 style="text-align: center; margin: 5px;">LIST OF LOANS</h2>
                </td>
            </tr>
          
            <tr class="heading">
                <td>
                    Name
                </td>
                <td>
                    Type
                </td>
                <td class="right">
                    Amount
                </td>
                <td>
                    Terms
                </td>
                <td class="right">
                    Balance
                </td>
            </tr>
            
            <?php

                foreach($this->data['data'] as $res) { 
            ?>

            <tr class="details">
                <td><?=$res['name'] ?></td>
                <td><?=$res['type'] ?></td>
                <td class="right"><?=Util::n_format($res['principal']) ?></td>
                <td><?=$res['terms'] ?></td>
                <td class="right"><?=Util::n_format($res['balance']) ?></td> 
            </tr>


            <?php
                }
            ?>

        </table>
    </div>

