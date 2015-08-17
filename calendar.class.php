<?

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function echostr() {
	global $_G;
	$cache = $_G['cache']['plugin']['calendar'];
	$starttime = date($cache['starttime']);
	$endtime = date($cache['endtime']);
	$now = time();
	if ($now > $starttime && $now < $endtime) return <<<EOF
<div id="my_calendar">
<table><tr><td>
<span id="my_datename">{$cache['title']}</span>
</td></tr></table>
</div>
EOF;
	return <<<EOF
<div id="my_calendar">
<table><tr><td>
<div>距离<span id="my_datename">{$cache['title']}</span><span id="mc_seperator">还有</span></div>
<div id="my_time"><span id="mc_day">0</span>天<span id="mc_hour">0</span>时<span id="mc_min">0</span>分<span id="mc_sec">0</span>秒</div>
</td></tr></table>
<script>
(function(window){
	var starttime=new Date("{$starttime}"),
		endtime=new Date("{$endtime}"),
		infoSeperator=document.getElementById("mc_seperator");
		infoDay=document.getElementById("mc_day");
		infoHour=document.getElementById("mc_hour");
		infoMin=document.getElementById("mc_min");
		infoSec=document.getElementById("mc_sec");
	function setTime(time){
		time=parseInt(time/1000);
		infoDay.innerHTML=parseInt(time/86400);
		time=parseInt(time%86400);
		infoHour.innerHTML=parseInt(time/3600);
		time=parseInt(time%3600);
		infoMin.innerHTML=parseInt(time/60);
		time=parseInt(time%60);
		infoSec.innerHTML=time;
	}
	function calcTime(){
		var now=new Date();
		var time;
		if(now>endtime){
			infoSeperator.innerHTML="已过去";
			time=now-endtime;
			setTime(time);
		}
		else if(now<starttime){
			infoSeperator.innerHTML="还有";
			time=starttime-now;
			setTime(time);
		}
	}
	calcTime();
	setInterval(calcTime,1000);
})(window);
</script>
</div>
EOF;
}
function pccssstr() {
	return <<<EOF
<style>
#my_calendar{
	position:absolute;
	top:-100px;
	left:320px;
	right:380px;
	height:90px;
	line-height:1.2em;
	text-align:center;
	font-size:16px;
	box-sizing:border-box;
}
#my_datename{
	font-family:"楷体","SimKai","仿宋";
	font-weight:bold;
	margin:0 5px;
}
#my_calendar table{
	width:100%;
	height:100%;
}
#my_time span{
	font-weight:bold;
	font-family:"Consolas","Courier New","Lucida Console";
	display:inline-block;
	width:2em;
}
#my_time{
	margin:5px 0 -5px;
}
</style>
EOF;
}
function mobilecssstr() {
	return <<<EOF
<style>
#my_calendar td{
	text-align:center;
}
#my_calendar td>div{
	font-size:14px;
	display:inline-block;
}
#my_datename{
	margin:0 4px;
	font-weight:bold;
}
#my_calendar td>div{
display:inline;
}
</style>
EOF;
}
class plugin_calendar {
	function global_nav_extra() {
		return pccssstr() . echostr();
	}
}
class mobileplugin_calendar {
	function global_header_mobile() {
		return mobilecssstr() . echostr();
	}
}
