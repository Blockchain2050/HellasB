<?php
class PointClass extends OssnDatabase
{
    function showPoints($guid){
        
        $this->statement("SELECT points FROM tk_points WHERE (guid='{$guid}');");
		$this->execute();
		$this->check = $this->fetch();

        return $this->check;
    }
}

?>