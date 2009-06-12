<?php
/*
 *  This file is part of Bobby Heartrate's Mafia Tools.
 *
 *  Bobby Heartrate's Mafia Tools is free software: you can
 *  redistribute it and/or modify it under the terms of the GNU Affero
 *  General Public License as published by the Free Software
 *  Foundation, either version 3 of the License, or (at your option)
 *  any later version.
 *
 *  Bobby Heartrate's Mafia Tools is distributed in the hope that it
 *  will be useful, but WITHOUT ANY WARRANTY; without even the implied
 *  warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *  See the GNU Affero General Public License for more details.
 */

error_reporting(E_ALL);

require_once "db.php";

class User 
{
	private $id;
	private $alias;
	
	function __construct($id, $alias) {
		$this->id = $id;
		$this->alias = $alias;
	}

	function from_id_or_alias($user) {
		$id = sweet_get_user_id($user);
		if (!is_null($id)) {
			$alias = db_get_alias($id);
			return new User($id, $alias);
		}
		return null;
	}
	
	function id() {
		return $this->id;
	}
	function alias() {
		return $this->alias;
	}
	
	function alias_or_id() {
		if ($this->alias)
			return $this->alias;
		return $this->id;
	}
	function visible_name() {
		if ($this->alias)
			return $this->alias;
		return "User with ID $this->id";
	}

	function format_link() {
		return "<a href=\"http://www.facebook.com/profile.php?id=$this->id\">".$this->visible_name()."</a>";
	}
}
?>
