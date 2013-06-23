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
 * Works with a global array $_GET
 *
 * @author Alla Mamontova <alla.mamontova@ubn24.de>
 * @version 1.0 2011
 */
class get
{
  public static function passed($params){
    if (is_array($params)){
      if ($params) foreach ($params as $param){
        if (!isset($_GET[$param])){
          return false;
        }
      }
      return true;
    }
    else{
      if (isset($_GET[$params])){
        return true;
      }
      return false;
    }
  }

  public static function is_string($param){
     return validator::is_string($_GET[$param]);
  }

  public static function is_only_char($param){
    return validator::is_only_char($_GET[$param]);
  }

  public static function is_login($param){
    return validator::is_login($_GET[$param]);
  }

  public function is_integer($param){
    return validator::is_integer($_GET[$param]);
  }

  public function is_unsigned_integer($param){
    return validator::is_unsigned_integer($_GET[$param]);
  }

  public function is_float($param){
    return validator::is_float($_GET[$param]);
  }

  public function is_unsigned_float($param){
    return validator::is_unsigned_float($_GET[$param]);
  }

  public function is_array_of_integer($param){
    return validator::is_array_of_integer($_GET[$param]);
  }

  public function is_array_of_unsigned_integer($param){
    return validator::is_array_of_unsigned_integer($_GET[$param]);
  }

  public function is_array_of_unsigned_float($param){
    return validator::is_array_of_unsigned_float($_GET[$param]);
  }

  public static function is_array_of_string($param){
     return validator::is_array_of_string($_GET[$param]);
  }

  public static function is_array_of_only_char($param){
    return validator::is_array_of_only_char($_GET[$param]);
  }

  public static function is_not_empty_array($param){
    return validator::is_not_empty_array($_GET[$param]);
  }

  public static function is_time($param){
    return validator::is_time($_GET[$param]);
  }

  public static function is_date($param){
    return validator::is_date($_GET[$param]);
  }

  public static function is_array_of_date($param){
    return validator::is_array_of_date($_GET[$param]);
  }

  public static function is_phone($param){
    return validator::is_phone($_GET[$param]);
  }

  public static function is_email($param){
    return validator::is_email($_GET[$param]);
  }

  public static function get_email($param){
    return control::get_email($_GET[$param]);
  }

  public static function get_phone($param){
    return control::get_phone($_GET[$param]);
  }

  public static function get_only_char($param){
    return control::get_only_char($_GET[$param]);
  }

  public static function get_login($param){
    return control::get_login($_GET[$param]);
  }

  public static function get_string($param){
    return control::get_string($_GET[$param]);
  }

  public static function get_unsigned_integer($param){
    return control::get_unsigned_integer($_GET[$param]);
  }

  public static function get_as_is($param){
    return $_GET[$param];
  }

  public static function is_mac($param){
    return validator::is_mac($_GET[$param]);
  }

  public static function get_mac($param){
    return control::get_mac($_GET[$param]);
  }

  public static function is_network_group_name($param){
    return validator::is_network_group_name($_GET[$param]);
  }

  public static function get_network_group_name($param){
    return control::get_network_group_name($_GET[$param]);
  }

  public static function is_network_address($param){
    return validator::is_network_address($_GET[$param]);
  }

  public static function get_network_address($param){
    return control::get_network_address($_GET[$param]);
  }

  public static function is_network_network($param){
    return validator::is_network_network($_GET[$param]);
  }

  public static function get_network_network($param){
    return control::get_network_network($_GET[$param]);
  }

  public static function is_network_netmask($param){
    return validator::is_network_netmask($_GET[$param]);
  }

  public static function get_network_netmask($param){
    return control::get_network_netmask($_GET[$param]);
  }

  public static function is_network_gateway($param){
    return validator::is_network_gateway($_GET[$param]);
  }

  public static function get_network_gateway($param){
    return control::get_network_gateway($_GET[$param]);
  }

  public static function is_directory($param){
    return validator::is_directory($_GET[$param]);
  }

  public static function get_directory($param){
    return control::get_directory($_GET[$param]);
  }

  public static function is_sex($param){
    return validator::is_sex($_GET[$param]);
  }

  public static function get_sex($param){
    return control::get_sex($_GET[$param]);
  }

  // nic

  public static function is_nic_country($param){
    return validator::is_nic_country($_GET[$param]);
  }

  public static function get_nic_country($param){
    return control::get_nic_country($_GET[$param]);
  }

  public static function is_string_of_emails($param){
    return validator::is_string_of_emails($_GET[$param]);
  }

  public static function get_array_of_emails($param){
    return control::get_array_of_emails($_GET[$param]);
  }

  public static function is_nic_string_cyr($param){
    return validator::is_nic_string_cyr($_GET[$param]);
  }

  public static function get_nic_string_cyr($param){
    return control::get_nic_string_cyr($_GET[$param]);
  }

  public static function is_nic_only_char($param){
    return validator::is_nic_only_char($_GET[$param]);
  }

  public static function get_nic_only_char($param){
    return control::get_nic_only_char($_GET[$param]);
  }

  public static function is_nic_string($param){
    return validator::is_nic_string($_GET[$param]);
  }

  public static function get_nic_string($param){
    return control::get_nic_string($_GET[$param]);
  }

  public static function is_string_of_nic_phones($param){
    return validator::is_string_of_nic_phones($_GET[$param]);
  }

  public static function get_array_of_nic_phones($param){
    return control::get_array_of_nic_phones($_GET[$param]);
  }

  public static function is_domain_zone($param){
    return validator::is_domain_zone($_GET[$param]);
  }

  public static function get_domain_zone($param){
    return control::get_domain_zone($_GET[$param]);
  }

  public static function is_domain($param){
    return validator::is_domain($_GET[$param]);
  }

  public static function get_domain($param){
    return control::get_domain($_GET[$param]);
  }

  public static function is_nic_kpp($param){
    return validator::is_nic_kpp($_GET[$param]);
  }

  public static function is_nic_org($param){
    return validator::is_nic_org($_GET[$param]);
  }

  public static function is_nic_org_r($param){
    return validator::is_nic_org_r($_GET[$param]);
  }
}

?>