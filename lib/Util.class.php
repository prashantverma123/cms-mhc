<?php

/**

 * Main utility class
 * @author Mahendra
 * @example
 * <code>

 * try {

 * 	 @include_once('util.php');

 * 	 Util::redirect('profile.php');

 * }

 * catch (Exception $e) {

 * 	 echo $e->getMessage();

 * }

 * </code>

 */
class Util {

    /**

     * if header is already sent page will redirect through javascript

     * @access public

     * @param string

     * @return void

     */
    public static function redirect($page) {

        $_SESSION['referer'] = $_SERVER['REQUEST_URI'];

        if (!headers_sent()) {
            header("location:$page");
        } else {
            echo "<script type='text/javascript'>location.href='$page'</script>";
        }

        exit;
    }

    public static function getAdPath($agency_id) {
        if (!empty($agency_id)) {
            $newdir = '/ads/agency_' . $agency_id . '/' . date('Y/M');
        } else {
            $newdir = '/ads/common/' . date('Y/M');
        }

        if (!is_dir(UPLOAD_DIR . $newdir)) {
            if (mkdir(UPLOAD_DIR . $newdir, 0777, true)) {
                return $newdir;
            } else {
                return false;
            }
        } else {
            return $newdir;
        }
    }

    public static function copyFiles($files = array()) {
        if (is_array($files) && count($files) > 0) {
            foreach ($files as $key => $val) {
                $fileName = basename($val);
                $source = UPLOAD_DIR . '/tmp/' . $fileName;
                $destination = UPLOAD_DIR . $val;
                if (!copy($source, $destination)) {
                    // echo "failed to copy $file...\n";
                    return false;
                } else {
                    unlink($source);
                }
            }
        }

        return true;
    }

    public static function uploadFile($fileElement,$dest) {
        $msgArr = array();
        $errorCode = $_FILES[$fileElement]['error'];
        
        if (!empty($errorCode)) {
            $error_msg = Util::getError($errorCode);
            $msgArr['status'] = 'error';
            $msgArr['msg'] = $error_msg;
            return $msgArr;
        }
         //echo 'Jmd......1234';
       
      $fileType = $_FILES[$fileElement]['type'];

        if (in_array($fileType, array('image/jpeg', 'image/png'))) {
            
        } else {
            $msgArr['status'] = 'error';
            $msgArr['fileType'] = $fileType;
            $msgArr['msg'] = 'File type should be image/jpeg';
            return $msgArr;
        }

        //$destination = UPLOAD_DIR . '/tmp';
        $file = $_FILES[$fileElement]['name'];
        $fileName = time() . '_' . $_FILES[$fileElement]['name'];
        $destination = $dest . '/' . $fileName;
        if (move_uploaded_file($_FILES[$fileElement]['tmp_name'], $destination)) {
            $notice = 1;
            chmod($destination, 0777);
            $msgArr['status'] = 'success';
            $msgArr['final_name'] = $fileName;
            $msgArr['orgFileName'] = $file;
            $msgArr['fileType'] = $fileType;
            $msgArr['fieldId'] = $fileElement;
            return $msgArr;
        } else {
            $msgArr['status'] = 'error';
            $msgArr['fileType'] = $fileType;
            $msgArr['msg'] = 'File Could Not Upload.........';
            return $msgArr;
        }
    }

    public static function getError($errorCode) {
        switch ($errorCode) {
            case '1':
                return $error_mag = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                break;
            case '2':
                return $error_mag = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                break;
            case '3':
                return $error_mag = 'The uploaded file was only partially uploaded';
                break;
            case '4':
                return $error_mag = 'No file was uploaded.';
                break;
            case '6':
                return $error_mag = 'Missing a temporary folder';
                break;
            case '7':
                return $error_mag = 'Failed to write file to disk';
                break;
            case '8':
                return $error_mag = 'File upload stopped by extension';
                break;
            default:
                return $error_mag = 'No error code avaiable';
        }
    }

    public static function debug($arr) {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
    }

    public static function authToken() {
        $token = md5(uniqid() . time());
        return $token;
    }

    public static function encodePwd($pwd) {
        return md5($pwd);
    }

    public static function adStaus($status) {
        if (0 == $status) {
            return 'New';
        }
        if (1 == $status) {
            return 'Acknowledged';
        }
        if (2 == $status) {
            return 'Sent To BCCL';
        }
        if (3 == $status) {
            return 'Not Match';
        }
        if (4 == $status) {
            return 'Match';
        }
        if (5 == $status) {
            return 'Exact Match';
        }
        if (6 == $status) {
            return 'Invoiced';
        }
    }

    public static function isValidMd5($md5) {
        return!empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
    }

    public static function optionsGenerator($table, $display_field, $value_field, $selected_value="", $conditions="") {
        $db = Database::getInstance();
        $options_str = "";
       echo $stmt = "select distinct " . $display_field . " as display," . $value_field . " as value from " . $table . " " . $conditions . " order by " . $display_field;
       exit;
        $db->execute($stmt);
        $result = $db->fetchAll();
        while (list($key, $valueArr) = each($result)) {
            $options_str.='<option value="' . $valueArr['value'] . '"';
            if ($selected_value != "" && $selected_value == $valueArr['value'])
                $options_str.=' selected ';
            $options_str.='>' . $valueArr['display'] . '</option>';
        }
        return $options_str;
    }

    public static function getMonthYearDropDown($selected_month_year='') {
        ////Number of options to show 
        $opts = 12;
        ////Array of months 
        $m = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
        ////Get starting year and month 
        $sm = date('n', strtotime("-6 Months"));
        $sy = date('Y', strtotime("-6 Months"));
        $options_str = '';
        for ($i = 0; $i < $opts; $i++) {
             $smy =  $m[$sm - 1].'-'.$sy;
             ////Check for current month and year so we can select it 
            if ( ($selected_month_year !='') && ($m[$sm - 1] == date('M') && $sy == date('Y')) ) {
                $options_str .= "<option value='" . $m[$sm - 1] . "-" . $sy . "' selected='selected'>" . $m[$sm - 1] . " - " . $sy . "</option>";
            } else {
                $selected='';
                if($selected_month_year == $smy){  $selected_month_year=''; $selected = "selected='selected'"; }
                $options_str .= "<option value='" . $m[$sm - 1] . "-" . $sy . "' $selected >" . $m[$sm - 1] . " - " . $sy . "</option>";
                
            }
            //// Fix counts when we span years 
            if ($sm == 12) {
                $sm = 1;
                $sy++;
            } else {
                $sm++;
            }
        }

        return $options_str;
    }

    public static function optionsGeneratorArray($options, $selected_value="") {
        $options_str = '';
        foreach ($options as $val => $text) {
            $options_str.='<option value="' . $val . '"';
            if ($selected_value == $val) {
                $options_str.=' selected ';
            }
            $options_str .= '>' . $text . '</option>';
        }
        return $options_str;
    }

    public static function intToWords($x) {
        $nwords = array("zero", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen", "twenty", 30 => "thirty", 40 => "forty", 50 => "fifty", 60 => "sixty", 70 => "seventy", 80 => "eighty", 90 => "ninety");
        if (!is_numeric($x)) {
            $w = '#';
        } else if (fmod($x, 1) != 0) {
            $w = '#';
        } else {
            if ($x < 0) {
                $w = 'minus ';
                $x = -$x;
            } else {
                $w = '';
            }
            if ($x < 21) {
                $w .= $nwords[$x];
            } else if ($x < 100) {
                $w .= $nwords[10 * floor($x / 10)];
                $r = fmod($x, 10);
                if ($r > 0) {
                    $w .= '-' . $nwords[$r];
                }
            } else if ($x < 1000) {
                $w .= $nwords[floor($x / 100)] . ' hundred';
                $r = fmod($x, 100);
                if ($r > 0) {
                    $w .= ' and ' . Util::intToWords($r);
                }
            } else if ($x < 100000) {
                $w .= Util::intToWords(floor($x / 1000)) . ' thousand';
                $r = fmod($x, 1000);
                if ($r > 0) {
                    $w .= ' ';
                    if ($r < 100) {
                        $w .= 'and ';
                    }
                    $w .= Util::intToWords($r);
                }
            } else {
                $w .= Util::intToWords(floor($x / 100000)) . ' lakh';
                $r = fmod($x, 100000);
                if ($r > 0) {
                    $w .= ' ';
                    if ($r < 100) {
                        $word .= 'and ';
                    }
                    $w .= Util::intToWords($r);
                }
            }
        }
        return $w;
    }

    public static function sendHTMLMail($to, $subject, $body, $from = '', $attachFile='', $bcc = FALSE, $host = 'nmailer.indiatimes.com') {

        if (APP_ENV == 'dev') {
            return true;
        }

        if (APP_ENV == 'stg') {
            $to = 'mahendra.kumar@indiatimes.co.in';
            //$to = 'shekhar.kadam@indiatimes.co.in, Sainath.Kamble@indiatimes.co.in, ashok.sharma@indiatimes.co.in, achin.malik@indiatimes.co.in, mahendra.kumar@indiatimes.co.in';
        }

        if (!$to) {
            return false;
        }

        include_once "Mail.php";
        include('Mail/mime.php');

        $recipients = $to;
        if ($bcc) {
            $bcc = '';
            $to = '';
        }
        $headers = array(
            'From' => $from,
            'To' => $to,
            'Bcc' => $bcc,
            'Subject' => $subject,
            'Reply-To' => FROMMAIL,
            'Return-Path' => FROMMAIL,
            'MIME-Version' => '1.0',
            'Content-Type' => 'text/html; charset=UTF-8',
            'Content-Transfer-Encoding' => '8bit',
            'X-Mailer' => 'PHP/' . phpversion()
        );

        $crlf = "\n";
        //$text = 'Text version of email';
        $mime = new Mail_mime($crlf);

        //$mime->setTXTBody($text);
        $mime->setHTMLBody($body);
        if (!empty($attachFile)) {
            //echo 'util -- '. $attachFile;
            //$file = '/var/www/html/timescard/uploads/ads/agency_12/2012/Jul/1342690554_Koala.jpg';
            $mime->addAttachment($attachFile, 'text/html');
        }

        $body = $mime->get();
        $headers = $mime->headers($headers);

        $smtp = Mail::factory('smtp', array('host' => $host,
                    'port' => $port,
                    'auth' => FALSE));
        $mail = $smtp->send($recipients, $headers, $body);



        if (PEAR::isError($mail)) {
            return $mail->getMessage();
        } else {
            return true;
        }
    }

    public static function validateRights($right) {
        global $session;
        if (!is_array($right)) {
            $right = array($right);
        }
        if (!in_array($session->get('SesRole'), $right)) {
            Util::redirect('/home.php');
        }
    }

    public static function cleanName($str) {
        $from = array(' ', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+', '{', '}', '|', '[', ']', '\\', ';', '\'', ':', '"', ',', '/', '<', '>', '?');
        $to = array('_', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
        return str_replace($from, $to, $str);
    }

    public static function downloadFile($filePath, $isDel=false) {
        $file = basename($filePath);

        if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")) {
            $file = preg_replace('/\./', '%2e', $file, substr_count($file, '.') - 1);
        }

        // make sure the file exists before sending headers
        if (!$fdl = @fopen($filePath, 'r')) {
            die("<br>Cannot Open File!<br>");
        } else {
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            //header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Content-Disposition: attachment; filename=" . basename($filePath) . ";");
            header("Content-Transfer-Encoding: binary");
            //header("Content-Transfer-Encoding: binary");
            // UPDATE: Add the below line to show file size during download.
            header('Content-Length: ' . filesize($filePath));

            readfile($filePath);
        }
        if ($isDel) {
            unlink($filePath);
        }
    }

}

?>
