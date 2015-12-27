<?php

	class HTMLtoPDF {
	
		private $html;
		
		public function setHTML($html) {
			$this->html = $html;
		}

		public function convert() {
			$descriptorspec = array(
			   0 => array("pipe", "r"),  // STDIN ist eine Pipe, von der das Child liest
			   1 => array("pipe", "w"),  // STDOUT ist eine Pipe, in die das Child schreibt
			   2 => array("pipe", "w")
			);

			$process = proc_open('/usr/local/bin/wkhtmltopdf -q - -', $descriptorspec, $pipes, "/", array());

			if (is_resource($process)) {
				fwrite($pipes[0], $this->html);
				fclose($pipes[0]);

				$pdf = stream_get_contents($pipes[1]);
				
				
				@fclose($pipes[0]);
				@fclose($pipes[1]);
				@fclose($pipes[2]);

				$return_value = proc_close($process);

				return $pdf;
			}
		}

	}

?>