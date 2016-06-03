<?php
class Logging {

    private $log_file, $fp;
    public function lfile($path) {
        $this->log_file = $path;
    }

    public function writelogs($moduleName="general",$message) {

        if (!is_resource($this->fp)) {
            $this->lopen($moduleName);
        }

        $script_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);
        $time = @date('[d/M/Y:H:i:s]');

        $user = $_SESSION['tmobi']['AdminName'];
        $role =$_SESSION['tmobi']['role'];
        fwrite($this->fp, "$time ($script_name) [$user $role] $message" . PHP_EOL);
				$this->lclose();
    }

    public function lclose() {
        fclose($this->fp);
    }

    private function lopen($moduleName) {

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $log_file_default = 'c:/php/logfile.txt';
        }

        else {
            $log_file_default = '/tmp/logfile.txt';
        }
        $time = date("j.n.Y");
				if( !is_dir('../logs/'.$time) ) {
				  mkdir( '../logs/'.$time, 0750, true );
				}

				$this->log_file =  '../logs/'.$time.'/'.$moduleName.'Log_'.date("j.n.Y").'.txt';
        $lfile = $this->log_file ? $this->log_file : $log_file_default;

        $this->fp = fopen($lfile, 'a') or exit("Can't open $lfile!");
    }
}
?>
