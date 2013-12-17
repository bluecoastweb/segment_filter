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

    public function __construct() {
        $this->EE =& get_instance();
        $number = $this->EE->TMPL->fetch_param('number', 1);
        $segment = $this->EE->uri->segment($number);
        if (! $segment) {
            return;
        }
        $permitted_values = array_filter(explode('|', $this->EE->TMPL->fetch_param('permitted')));
        if (in_array($segment, $permitted_values)) {
            return;
        };
        $redirect = $this->EE->TMPL->fetch_param('redirect');
        if (! $redirect) {
            $redirect = '/';
            if ($number > 1) {
                $segments = $this->EE->uri->segment_array();
                $redirect .= implode('/', array_slice($segments, 0, $number - 1));
            }
        }
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: $redirect");
        exit();
    }

    public static function usage() {
        ob_start();
?>

{exp:segment_filter number='2' permitted='this|that'}

{exp:segment_filter number='2' permitted='this|that' redirect='/somewhere/else'}

<?php
    $buffer = ob_get_contents();
    ob_end_clean();
    return $buffer;
  }
}

/* End of file pi.segment_filter.php */
/* Location: /system/expressionengine/third_party/segment_filter/pi.segment_filter.php */
