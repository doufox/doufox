<?php
if (!defined('IN_CMS')) {
    exit();
}

class BlockModel extends Model
{

    public function get_primary_key()
    {
        return $this->primary_key = 'id';
    }

}
