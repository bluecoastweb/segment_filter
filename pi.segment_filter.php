<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name'        => 'Segment Filter',
  'pi_version'     => '1.0.0',
  'pi_author'      => 'Steve Pedersen',
  'pi_author_url'  => 'http://www.bluecoastweb.com',
  'pi_description' => 'Filter extra segments',
  'pi_usage'       => Segment_filter::usage()
);

class Segment_filter {
    private $debug = false;

    public function __construct() {
        $this->EE =& get_instance();
        $this->debug = $this->_is_truthy($this->EE->TMPL->fetch_param('debug'));
        $number = $this->EE->TMPL->fetch_param('number', 1);
        $this->_debug("number=$number");
        $segment = $this->EE->uri->segment($number);
        $this->_debug("segment=$segment");
        if (! $segment) {
            return;
        }
        $permitted_values = array_filter(explode('|', $this->EE->TMPL->fetch_param('permitted')));
        $this->_debug('permitted_values='.print_r($permitted_values, true));
        if (in_array($segment, $permitted_values)) {
            return;
        };
        $redirect = $this->EE->TMPL->fetch_param('redirect');
        if (! $redirect) {
            $redirect = '/';
            if ($number > 1) {
                $segments = $this->EE->uri->segment_array();
                $this->_debug('segments='.print_r($segments, true));
                $redirect .= implode('/', array_slice($segments, 0, $number - 1));
            }
        }
        $this->_debug("redirect=$redirect");
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: $redirect");
        exit();
    }

    /**
     * Private functions
     */

    private function _debug($string) {
        if ($this->debug) {
            $this->EE->TMPL->log_item(__CLASS__." $string");
        }
    }

    private function _is_truthy($value) {
        $truthy_values = array('on', 'true', 'yes', '1');
        return in_array(strtolower($value), $truthy_values);
    }

    public static function usage() {
        ob_start();
?>

{exp:segment_filter number='2' permitted='this|that'}

<?php
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
  }
}

/* End of file pi.segment_filter.php */
/* Location: /system/expressionengine/third_party/segment_filter/pi.segment_filter.php */
