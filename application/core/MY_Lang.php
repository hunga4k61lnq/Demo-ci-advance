<?php 
class MY_Lang extends MX_Lang {

    public $language    = array();
    public $is_loaded    = array();
    private $idiom;
    private $set;

    private $line;
    private $CI;
    public function __construct(){
        parent::__construct();

    }
    /**
     * Load a language file
     *
     * @access    public
     * @param    mixed    the name of the language file to be loaded. Can be an array
     * @param    string    the language (english, etc.)
     * @return    mixed
     */
    function load($langfile='', $idiom = 'vi', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $_module = '')    
    {
        $this->set = $langfile;
        $this->idiom = $idiom;

        $database_lang =  $this->_get_from_db();

        if ( ! empty( $database_lang ) )
        {
            $lang = $database_lang;
        }else{
            show_error('Unable to load the requested language file: language/'.$langfile);
        }

        if ( ! isset($lang))
        {
            log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile);
            return;
        }

        if ($return == TRUE)
        {
            return $lang;
        }

        $this->is_loaded[] = $langfile;
        $this->language = array_merge($this->language, $lang);
        unset($lang);

        log_message('debug', 'Language file loaded: language/'.$idiom.'/'.$langfile);
        return TRUE;
    }

    /**
     * Load a language from database
     *
     * @access    private
     * @return    array
     */
    private function _get_from_db()
    {
        $CI =& get_instance();
        $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        $CI->load->database();
        if ( ! $return = $CI->cache->get('website_language'))
        {
            $return= array();
            $CI->db->select   ('*');
            $CI->db->from     ('languages');


            $query = $CI->db->get()->result_array();

            foreach ( $query as $row )
            {

                $return[$row['keyword']] = $row;
            }
            $CI->cache->save('website_language', $return, $CI->config->item('enuy_time_cache_language'));
            unset($CI, $query);
        }
         return $return;
    }
    public function line($line, $log_errors = TRUE)
    {
        $CI =& get_instance();
        $lang = $CI->session->userdata('lang');

        if(!@$lang || isNull($lang)){
            $lang= 'vi';
        }
        $line = strtoupper($line);
        $value = FALSE;
        if(isset($this->language[$line])){
            if(array_key_exists($lang."_value", $this->language[$line])){
                $value = $this->language[$line][$lang."_value"];
            }
            else{
                 $value = $this->language[$line]["vi_value"];
            }

            
        }
        else{
            $value = $line;
        }
        return $value;
    }
    
}
?>