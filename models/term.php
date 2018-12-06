<?php

class Term extends Model
{

    public function getTerms(){
        $sql = "select * from l_terms";

        return $this->db->query($sql);
    }

    public function getTermsById($id){
        $id = $this->db->escape($id);
        $sql = "select months from l_terms where lid = '{$id}'";

        $result = $this->db->query($sql);
        if (isset($result[0])){
            return $result[0];
        }
        return false;
    }


    public function save($data, $id = null){
        $id = $this->db->escape($id);

        $months = $this->db->escape($data['months']);
        $description = $this->db->escape($data['description']);

        if(!$id){

            $sql = "insert into l_terms
                    set
                    months = '{$months}'
                    description = '{$description}'
                ";

        }else{

            $sql = "update l_terms
                    set
                    months = '{$months}'
                    description = '{$description}'
                    where 
                    lid ='{$id}'
                ";

        }

        $this->db->query($sql);
    }


}
