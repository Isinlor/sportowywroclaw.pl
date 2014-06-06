<?php
class Gallery extends Eloquent
{
	public function pictures()
	{
		return $this->has_many('Picture');
	}
}