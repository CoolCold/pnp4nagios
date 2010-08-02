<html>
<head>
<?php echo html::stylesheet('media/css/common.css') ?>
<?php echo html::stylesheet('media/css/ui-'.$this->theme.'/jquery-ui.css') ?>
<?php echo html::script('media/js/jquery-min.js')?>
<?php echo html::script('media/js/jquery-ui.min.js')?>
</head>
<body>
<script type="text/javascript">
var imgprops = "";
</script>
<div class="pagebody">
<div class="ui-widget">
<div class="ui-widget-header ui-corner-top">
<?php echo Kohana::lang('common.zoom-header') ?>
</div>
<div class="p4 ui-widget-content ui-corner-bottom">
<h3> <?php echo $this->data->TIMERANGE['f_start']?> --- <?php echo $this->data->TIMERANGE['f_end']?> </h3>
<div id='zoomBox' style='position:absolute; overflow:none; left:0px; top:0px; width:0px; height:0px; visibility:visible; background:red; filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity:0.5; opacity:0.5'></div>
<div id='zoomSensitiveZone' style='position:absolute; overflow:none; left:0px; top:0px; width:0px; height:0px; visibility:visible; cursor:crosshair; background:blue; filter:alpha(opacity=0); -moz-opacity:0; -khtml-opacity:0;opacity:0' oncontextmenu='return false'></div>
<STYLE MEDIA="print">
  div#zoomBox, div#zoomSensitiveZone {display: none}
  #why {position: static; width: auto}
</STYLE>

<?php
$tplstr="";
$hoststr="";
$srvstr="";
if(!empty($tpl)) {
	$tplstr="&tpl=" . $tpl;
} else {
	$hoststr="&host=" . $host;
	$srvstr="&srv=" . $srv;
}

$valuestr="";
if(isset($this->value_min) && isset($this->value_max)) {
	$valuestr="&value_min=" . $this->value_min . "&value_max=" . $this->value_max;
}

$imgcode="image?source=" . $source . $tplstr;
$imgcode=$imgcode . $hoststr . $srvstr . "&view=" . $view . "&start=". $start . "&end=" . $end;
$imgcode=$imgcode . "&graph_height=" . $graph_height . "&graph_width=" . $graph_width . "&title_font_size=10" . $valuestr;
echo "<img id=\"zoomGraphImage\" src=\"" . $imgcode . "\">\n";
?>
<script type="text/javascript">
$.getJSON("<?php echo $imgcode . "&putdata=1"?>", function (data) {
	imgprops=data;
});
</script>
<?php
include("media/js/zoom.js")
?>
</div>
</div>
</body>
</html>

