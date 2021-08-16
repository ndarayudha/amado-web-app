<?php


use Illuminate\Support\Facades\Storage;

/**
 * * Konversi gambar ke base64
 * 
 * @param base64 file yang dienkripsi
 */
function convertImageToBase64($fileName)
{
	// explode file name
	$path = explode('/', $fileName);
	// ambil index terakhir (nama file)
	$imageName = $path[1];
	// cari tahu format file
	$fileType = pathinfo($imageName, PATHINFO_EXTENSION);
	// ambil data gambar
	$data = Storage::get("public/" . $fileName);
	// encode data
	$encodeData = base64_encode($data);

	$base64 = "data:image/{$fileType};base64,{$encodeData}";

	return $base64;
}


/**
 * * Konversi base64 ke gambar
 * 
 * @param base64 file base64 yang dienkripsi
 */
function convertBase64ToImage($base64)
{
	$image_base64 = base64_decode($base64);
	return $image_base64;
}
