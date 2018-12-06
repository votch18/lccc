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
                                Receipt #: 123<br>
                                Loan #: <?=$this->data['loan_id']?><br>
                                Date: <?=Util::d_format2($this->data['dop'])?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <h2 style="text-align: center; margin: 5px;">PAYMENT RECEIPT</h2>
                </td>
            </tr>
          
            <tr class="heading">
                <td>
                    Name:
                </td>
                
                <td>
                    Amount:
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    <?=strtoupper($this->data['name'])?>
                </td>
                
                <td>
                    <?=Util::number_format($this->data['amount'])?>
                </td>
            </tr>

             <tr class="heading">
                <td colspan="2">
                    Amount in words:
                </td>
               
            </tr>
            
            <tr class="details">
                <td colspan="2">
                    <?=ucwords($util->NumbertoWords($this->data['amount']))?>
                </td>
               
            </tr>
            
            <!--
            <tr class="heading">
                <td>
                    Item
                </td>
                
                <td>
                    Price
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Website design
                </td>
                
                <td>
                    $300.00
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Hosting (3 months)
                </td>
                
                <td>
                    $75.00
                </td>
            </tr>
            
            <tr class="item last">
                <td>
                    Domain name (1 year)
                </td>
                
                <td>
                    $10.00
                </td>
            </tr>
            
            <tr class="total">
                <td></td>
                
                <td>
                   Total: $385.00
                </td>
            </tr>
            -->
        </table>
    </div>

