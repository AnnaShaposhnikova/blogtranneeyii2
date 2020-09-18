<?php


namespace app\traits;


trait Restore
{
    public function restore(){

        $this->deleted_at = null;
        $this->save();
        return true;
    }

}