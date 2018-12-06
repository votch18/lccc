<?php

class Expenditure extends Model
{

    public function getExpenditures(){

        $sql = "SELECT 
                date, 
                particulars, 
                amount, 
                b.description as fund_source
                FROM t_expenditures a
                INNER JOIN l_accounts b ON b.account_code = a.charge_to
                ORDER BY a.date DESC";

        return $this->db->query($sql);
    }

    public function save($data, $id = null){

        $id = $this->db->escape($id);

        $date = $this->db->escape($data['date_expended']);
        $particulars = $this->db->escape($data['particulars']);
        $amount = $this->db->escape($data['amount']);
        $charge_to =  $this->db->escape($data['charge_to']);
        $status =  $this->db->escape($data['status']);
        $userid = Session::get('userid');

        if (!$id){
            $sql="insert into `t_expenditures` 
                set 
                `date`='{$date}',
                `particulars`='{$particulars}',
                `amount`='{$amount}',
                `charge_to`='{$penalty}',
                `userid`='{$userid}',
                `status`='{$status}'
            ";
        }else{
            $sql="update `t_expenditures` 
                set 
                `date`='{$date}',
                `particulars`='{$particulars}',
                `amount`='{$amount}',
                `charge_to`='{$penalty}',
                `userid`='{$userid}',
                `status`='{$status}'
                where
                `id` = '{$id}'
            ";
        }
        
        return $this->db->query($sql);;
    }


    public function delete($id){
        $id = $this->db->escape($id);
        $sql = "delete from t_expenditures where id ='{$id}'";
        $this->db->query($sql);

        return true;
    }

}
