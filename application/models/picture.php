<?php
class Picture extends Eloquent
{
	public static $timestamps = false;
	public function author()
	{
		return $this->belongs_to('User', 'author_id');
	}
	public function gallery()
	{
		return $this->belongs_to('Gallery', 'gallery_id');
	}
}