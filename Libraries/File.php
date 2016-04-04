<?php

namespace Libraries {

	class File {
		private $filename;

		function __construct($project_id) {
			$this->filename = substr("00000" . $project_id, -6);
		}

		public function save($data, $thumb = false) {
			$prefix = $thumb ? '_th' : '';
			$data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
			file_put_contents("screens/{$this->filename}{$prefix}.jpg", $data);
		}

	}

}?>