<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Image controller.
 *
 * @package    pnp4nagios
 * @author     Joerg Linge
 * @license    GPL
 */
class Image_Controller extends System_Controller  {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Disable auto-rendering
        $this->auto_render = FALSE;
    
        $tpl     = $this->input->get('tpl');
        $host    = $this->input->get('host');
        $service = $this->input->get('srv');
        $start   = $this->input->get('start');
        $end     = $this->input->get('end');
        $view    = $this->config->conf['overview-range']; //default value
        $source  = "";
        $value_min = FALSE;
        $value_max = FALSE;

        if($this->input->get('view') != "" )
            $view = $this->input->get('view') ;

        if($this->input->get('source') )
            $source = $this->input->get('source') ;

        $beverbose=0;
        if($this->input->get('putdata') ) {
            $beverbose=1;
        }

        if ($this->input->get('value_min') != "" ) {
            $value_min=$this->input->get('value_min');
            $value_min=floatval($value_min);
        }

        if ($this->input->get('value_max') != "") {
            $value_max=$this->input->get('value_max');
            $value_max=floatval($value_max);
        }
        if (is_numeric($value_min) && is_numeric($value_max) ) {
            $this->data->RRD_EXTRA=$this->data->RRD_EXTRA . " -r -l " . $value_min . " -u " . $value_max;
        }
        $this->data->getTimeRange($start,$end,$view);

        if(isset($tpl)){
            $tpl    = pnp::clean($tpl);
            $this->data->buildDataStruct('__special',$tpl,$view,$source);
            #print Kohana::debug($this->data->STRUCT);
            $image = $this->rrdtool->doImage($this->data->STRUCT[0]['RRD_CALL'],'STDOUT',$beverbose);
            $this->rrdtool->streamImage($image);
        }elseif(isset($host) && isset($service)){
            $service = pnp::clean($service);
            $host    = pnp::clean($host);
            $this->data->buildDataStruct($host,$service,$view,$source);
            #print Kohana::debug($this->data->STRUCT);
            if(sizeof($this->data->STRUCT) > 0){
                $image = $this->rrdtool->doImage($this->data->STRUCT[0]['RRD_CALL'],'STDOUT',$beverbose);
            }else{
                $image = FALSE;
            }
            $this->rrdtool->streamImage($image); 
        }else{
            print "ERROR";
        }
    }


}
