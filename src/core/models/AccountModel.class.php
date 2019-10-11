<?php

class AccountModel extends Model
{

    public function get_primary_key()
    {
        return $this->primary_key = 'userid';
    }

    public function get_fields()
    {
        return $this->get_table_fields();
    }

}
