<?php
/**
 * VDC 24
 *
 * Cloud hosting interface
 * @author Alla Mamontova <alla.mamontova@ubn24.de>
 * @version 1.0 2011
 * @package vdc
 */

/**
 * Convert variables into correct format
 *
 * @author Alla Mamontova <alla.mamontova@ubn24.de>
 * @version 1.0 2011
 */
class control
{

  public static function get_string($string){
    $string = str_replace('"','\"',$string);
    $string = str_replace("'",'\'',$string);
    return $string;
  }

  public static function get_integer($int){
    return (int)$int;
  }

  public static function get_unsigned_integer($int){
    return abs(self::get_integer($int));
  }

  public static function get_float($float){
    return (float)$float;
  }

  public static function get_unsigned_float($float){
    return abs(self::get_float($float));
  }

// public static function cut_ext($value){
// $value = str_replace('.html','',$value);
// $value = str_replace('.htm','',$value);
// $value = str_replace('.php','',$value);
// $value = str_replace('.xls','',$value);
// $value = str_replace('.pdf','',$value);
// return $value;
// }
//
/**
 * Convert timestamp to time format (HH:MM:SS)
 *
 * @param integer $date_ts timestamp
 * @return string
 */
  public static function get_time_from_ts($date_ts){
    return date('H:i:s', $date_ts);
  }
/**
 * Convert timestamp to time format (HH:MM)
 *
 * @param integer $date_ts timestamp
 * @return string
 */
  public static function get_time_without_sec_from_ts($date_ts){
    return date('H:i', $date_ts);
  }
/**
 * Convert string to date format with time (DD.MM.YYYY HH:MM:SS)
 *
 * uses strtotime function
 * @param string $date
 * @return string
 */
  public static function get_date($date){
    $date = self::correct_date_format($date);
    return date('d.m.Y H:i:s', strtotime($date));
  }
/**
 * Convert string to date format without time (DD.MM.YYYY)
 *
 * uses strtotime function
 * @param string $date
 * @return string
 */
  public static function get_date_without_time($date){
    $date = self::correct_date_format($date);
    return date('d.m.Y', strtotime($date));
  }
/**
 * Convert string to date format without time id db format (YYYY-MM-DD)
 *
 * uses strtotime function
 * @param string $date
 * @return string
 */
  public static function get_date_without_time_to_db($date){
    $date = self::correct_date_format($date);
    return date('Y-m-d', strtotime($date));
  }
/**
 * Convert timestamp to date format with time (DD.MM.YYYY HH:MM:SS)
 *
 * @param integer $date_ts timestamp
 * @return string
 */
  public static function get_date_from_ts($date_ts){
    return date('d.m.Y H:i:s', $date_ts);
  }
/**
 * Convert timestamp to date format without time (DD.MM.YYYY)
 *
 * @param integer $date_ts timestamp
 * @return string
 */
  public static function get_date_without_time_from_ts($date_ts){
    return date('d.m.Y', $date_ts);
  }
/**
 * Convert string to date format without time from db result (DD.MM.YYYY HH:MM:SS)
 *
 * uses strtotime function
 * @param string $date
 * @return string
 */
  public static function get_date_without_time_from_db($date){
    return date('d.m.Y', strtotime($date));
  }

  public static function correct_date_format($date)
  {
    $date = str_replace('.','',$date);
    $date = str_replace(',','',$date);
    $date = str_replace('-','',$date);
    $date = str_replace('\\','',$date);
    $date = str_replace('/','',$date);
    $day = substr($date,0,2);
    $month = substr($date,2,2);
    $year = substr($date,4);
    if (strlen($year) == 2){
        if ($year > date('y')){
          $year = '19'.$year;
        }
        else{
          $year = '20'.$year;
        }
    }
    $date = $day.'.'.$month.'.'.$year;

    return $date;
  }

// public static function get_db_date($date = ''){
// if ($date == ''){
// $date = date('d.m.Y');
// }
// $date = date('Y-m-d', strtotime($date));
// return $date;
// }

  public static function get_decimal_format($number){
    $number = round($number,2);
    if ( $number*100 % 100 == 0 ){
      $number .= '.00';
    }
    elseif ( $number*100 % 10 == 0 ){
      $number .= '0';
    }
    return $number;
  }

  public static function get_only_char($value){
    return $value;
  }

  public static function get_login($value){
    return $value;
  }

  public static function get_mac($value){
    return $value;
  }

  public static function get_network_group_name($value){
    return $value;
  }

  public static function get_directory($value){
    return $value;
  }

  public static function get_email($value){
    return $value;
  }

  public static function get_phone($value){
    return $value;
  }
  
    public function get_array_of_unsigned_integer($value) {
	$array = array();
	if (is_array($value) && $value) {
	    foreach ($value as $key => $int) {
		$array[$key] = abs(self::get_integer($int));
	    }
	}
	return $array;
    }

  public static function get_sex($value){
//     $male_sex = array(1, '1', 'male', 'man');
//     $female_sex = array(0, '0', 'female', 'woman');
//     if (in_array($value,$male_sex)){
//       $value = user::SEX_MALE;
//     }
//     elseif (in_array($value,$female_sex)){
//       $value = user::SEX_FEMALE;
//     }
//     else{
//       $value = '';
//     }
    return $value;
  }

  // --- NIC CONTROL ---

/**
 * Get country for nic.ru
 *
 * @param mixed $value value to control
 * @return string
 */
  public function get_nic_country($value){ // !!! list of countries !!!
    return 'RU';
  }
/**
 * Get array of emails from string
 *
 * @param mixed $value value to control
 * @return array
 */
  public function get_array_of_emails($value){
    $emails = explode(',',$value);
    foreach ($emails as $key => $email){
      $emails[$key] = control::get_email(trim($email));
    }
    return $emails;
  }
/**
 * Get string (letters, digits, punctuation marks) for nic.ru
 *
 * @param mixed $value value to control
 * @return string
 */
  public function get_nic_string($value){
    return $value;
  }
/**
 * Get string with cyrillic (letters, digits, punctuation marks) for nic.ru
 *
 * @param mixed $value value to control
 * @return string
 */
  public function get_nic_string_cyr($value){
    return $value;
  }
/**
 * Get string that contains only chars (letters&digits) for nic.ru
 *
 * @param mixed $value value to control
 * @return string
 */
  public function get_nic_only_char($value){
    return $value;
  }
/**
 * Get array of phone number for nic.ru
 *
 * @param mixed $value value to control
 * @return string
 */
  public function get_nic_phone($value){
    return $value;
  }
/**
 * Get array of phone numbers from string for nic.ru
 *
 * @param mixed $value value to control
 * @return array
 */
  public function get_array_of_nic_phones($value){
    $phones = explode(',',$value);
    foreach ($phones as $key => $phone){
      $phone[$key] = control::get_nic_phone(trim($phone));
    }
    return $phones;
  }

  public function get_array_of_nic_string_cyr($value,$len){
    $array = array();
    while (mb_strlen($value) > $len){
      $array[] = mb_substr($value, 0, $len);
      $value = mb_substr($value, $len - 1);
    }
    if (!$array){
      $array[] = $value;
    }
    return $array;
  }

  public function get_array_of_nic_string($value,$len){
    $array = array();
    while (mb_strlen($value) > $len){
      $array[] = mb_substr($value, 0, $len);
      $value = mb_substr($value, $len - 1);
    }
    if (!$array){
      $array[] = $value;
    }
    return $array;
  }

  public function get_nic_code($value){
    return trim($value);
  }

  public function get_nic_kpp($value){
    return trim($value);
  }

  public function get_domain_zone($value){
    return trim($value);
  }

  public function get_domain($value){
    return trim($value);
  }

  public function remove_quotes($value){
    $value = str_replace('"','``',$value);
    $value = str_replace("'",'`',$value);
    return $value;
  }

  public function return_quotes($value){
    $value = str_replace('``','"',$value);
    $value = str_replace('`',"'",$value);
    return $value;
  }

  public function get_network_address($value){
    return trim($value);
  }

  public function get_network_network($value){
    return trim($value);
  }

  public function get_network_netmask($value){
    return trim($value);
  }

  public function get_network_gateway($value){
    return trim($value);
  }

}

?>