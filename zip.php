<?php
/**
 * Creates a ZIP archive from a list of files
 *
 * @author Julien Gargot
 * @version 0.0.1
 */

// P R O V I D E   A   K I R B Y   T A G
// TODO: create a kirby tag.


// P R O V I D E   A   R O U T E
kirby()->routes(array(
	array(
		'pattern' => c::get('zip.download.url', 'download/archive'),
		'method' => 'POST',
		'action'  => function() {

			$site  = site();
			$datas = json_decode( get('datas') );
			$files_to_zip = array();

			foreach ($datas as $key => $filename)
			{
				$p = $site->index()->findBy('hash', $key);
				$f = $p->file($filename);
				$files_to_zip[] = $f->root();
			}

			//if true, good; if false, zip creation failed
			$filename = c::get('zip.default.filename', "archive") . '.zip';
			$destination = c::get('zip.destination.path', "tmp/zip/") . $filename;

			$result = create_zip($files_to_zip, $destination);

			if( $result )
			{
				// Then download the zipped file.
				header('Content-Type: application/zip');
				header('Content-disposition: attachment; filename='.$filename);
				header('Content-Length: ' . filesize($destination));
				readfile($destination);
				// Delete the zipped file from the server.
		    unlink($destination);
			}
			else
			{
				// Should display something better
				die('Error');
			}

		}
	)
));

/**
 * Creates a compressed zip file
 *
 * @author David Walsh
 * @source source: https://davidwalsh.name/create-zip-php
 */
function create_zip($files = array(),$destination = '',$overwrite = false) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$temp = basename(dirname($file)) .'-'. basename($file);
			$zip->addFile($file, basename(dirname($file)) .'-'. basename($file));
		}
		//debug
		// echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

		//close the zip -- done!
		$zip->close();

		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}

?>
