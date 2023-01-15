<?php

namespace App\Traits;

trait ImageUpload
{
	public function uploadImage($image): string
	{

		$imageName = date('YmdHi') . $image->getClientOriginalName();
		$image->move(public_path('public/Image'), $imageName);
		return $imageName;
	}
}
