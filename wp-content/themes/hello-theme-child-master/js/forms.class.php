<?php
class ASA_Forms {
    private $_form_id = 18212;
    private $_url;
    private $_url_prefix = 'https://solutions.refinitiv.com/LP=';
    private $_url_whitepaper = 'https://info.giact.com/l/312331/2021-12-03/gxryx';
    private $_post_id;
    private $_query_string;
    public $utm_source;
    public $utm_content;
    public $utm_campaign;
    public $utm_medium;
    public $utm_term;
    public $elqCampaignID;
    public $referred_By;

    public function __construct() {
        $this->_start_session();
    }

    private function _start_session() {
        if(!session_id()) {
            session_start();
        }
    }

    private function _setPostId() {
        $this->_post_id = get_the_ID();
    }

    private function _setFormId() {
        $this->_setPostId();
        switch ($this->_post_id) {
            case 2849:
                $this->_form_id = 18212;
                break;
            case 2924:
                $this->_form_id = 18233;
                break;
            case 3038:
                $this->_form_id = '';
                $this->_url_prefix = $this->_url_whitepaper;
                break;
        }
    }

    private function _getFormId() {
        $this->_setFormId();
        return $this->_form_id;
    }

    private function _setQueryString() {
        $query_values =
            ['utm_source' => '',
            'utm_content' => '',
            'utm_campaign' => '',
            'utm_medium' => '',
            'utm_term'  => '',
            'elqCampaignId' => '',
            'referred_By' => '',
        ];

        //  loop through the query values
        foreach ($query_values as $query_value => $query_default_value) {
            //  check if the query value is set in the query string
            if ((isset($_GET[$query_value]) && $_GET[$query_value] != '')) {
                $temp = filter_input(INPUT_GET, $query_value, FILTER_SANITIZE_STRING); // sanitize
                $this->{$query_value} = $temp;
                $this->_query_string .= '&'.$query_value.'='.$temp;
                // check if the query value is set in the session
            } elseif ((isset($_SESSION[$query_value]) && $_SESSION[$query_value] != '')) {
                $this->{$query_value} = esc_attr($_SESSION[$query_value]); // sanitize
                $this->_query_string .= '&'.$query_value.'='.urlencode($_SESSION[$query_value]); // sanitize
            }
        }

        //  remove the first character from the query string
        $this->_query_string = substr($this->_query_string, 1);
    }

    private function _getQueryString():string {
        $this->_setQueryString();
        return $this->_query_string;
    }

    private function _setUrl() {
        $this->_setFormId();
        $this->_url = $this->_url_prefix.$this->_getFormId().'?'.$this->_getQueryString();
    }

    public function getUrl():string {
        $this->_setUrl();
        return $this->_url;
    }
}

$asa_forms = new ASA_Forms();
$url = $asa_forms->getUrl();

echo '
<script>
jQuery(function() {
';
echo ($asa_forms->elqCampaignID != '') ? "\n"."jQuery(\"input[name='hiddenCampaignId']\").val(\"$asa_forms->elqCampaignID\");" : "";
echo ($asa_forms->referred_By != '') ? "\n"."jQuery(\"input[name='referredBy']\").val(\"$asa_forms->referred_By\");" : "";
echo ($asa_forms->utm_source != '') ? "\n"."jQuery(\"input[name='utm_source']\").val(\"$asa_forms->utm_source\");" : "";
echo ($asa_forms->utm_content != '') ? "\n"."jQuery(\"input[name='utm_content']\").val(\"$asa_forms->utm_content\");" : "";
echo ($asa_forms->utm_campaign != '') ? "\n"."jQuery(\"input[name='utm_campaign']\").val(\"$asa_forms->utm_campaign\");" : "";
echo ($asa_forms->utm_medium != '') ? "\n"."jQuery(\"input[name='utm_medium']\").val(\"$asa_forms->utm_medium\");" : "";
echo ($asa_forms->utm_term != '') ? "\n"."jQuery(\"input[name='utm_term']\").val(\"$asa_forms->utm_term\");" : "";

echo "
var url = \"$url\";
document.getElementById(\"myurl\").setAttribute(\"src\", url);
});
</script>
";

