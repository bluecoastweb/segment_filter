<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
    'pi_name'        => 'Segment Filter',
    'pi_version'     => '1.1',
    'pi_author'      => 'Steve Pedersen',
    'pi_author_url'  => 'http://www.bluecoastweb.com',
    'pi_description' => 'Filter extra segments',
    'pi_usage'       => Segment_filter::usage()
);

class Segment_filter {
    private $debug = false;

    public function __construct() {
        $this->EE =& get_instance();
        $this->debug = $this->is_truthy($this->EE->TMPL->fetch_param('debug'));
        $number = $this->EE->TMPL->fetch_param('number', 1);
        $segment = $this->EE->uri->segment($number);
        if ($this->debug) {
            $this->EE->TMPL->log_item(__CLASS__." number=$number, segment=$segment");
        }
        if (! $segment) {
            return;
        }
        $permitted_values = array_filter(explode('|', $this->EE->TMPL->fetch_param('permitted', '')));
        if ($this->debug) {
            $this->EE->TMPL->log_item(__CLASS__.' permitted_values='.print_r($permitted_values, true));
        }
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
        if ($this->debug) {
            $this->EE->TMPL->log_item(__CLASS__." redirect=$redirect");
        }
        header('HTTP/1.1 301 Moved Permanently');
        header("Location: $redirect");
        exit();
    }

    private function is_truthy($value) {
        $truthy_values = array('on', 'true', 'yes', '1');
        return in_array(strtolower($value), $truthy_values);
    }

    public static function usage() {
        ob_start();
?>

Enforce strict URLs by permitting only certain values for a specified segment.

For example, if segment_2 != '' then redirect to /segment_1:

    {exp:segment_filter number='2'}

Or specify a non-default redirect:

    {exp:segment_filter number='2' redirect='/somewhere/else'}

Or redirect to /segment_1/segment_2 (the default) if segment_3 is not within the specified whitelist of permitted values:

    {exp:segment_filter number='3' permitted='apples|oranges|mangoes'}

<?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }
}

/* End of file pi.segment_filter.php */
/* Location: /system/expressionengine/third_party/segment_filter/pi.segment_filter.php */
