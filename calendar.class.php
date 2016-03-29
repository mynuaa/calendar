<?

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function echostr() {
	global $_G;
	$cache = $_G['cache']['plugin']['calendar'];
	$starttime = strtotime($cache['starttime']);
	$endtime = strtotime($cache['endtime']);
	$now = time();
	if ($now > $endtime && $cache['autoclose']) return '';
	else if ($now > $starttime) {
		if (isset($cache['url']) && $cache['url'] != '') {
			$link = '<p class="my_datename" style="margin-top:0.2em"><a href="' . $cache['url'] . '">[点此进入]</a></p>';
		}
		return <<<EOF
<div id="my_calendar">
<table><tr><td>
<p class="my_datename"><big>{$cache['title']}</big></p>{$link}
</td></tr></table>
</div>
EOF;
	}
	return <<<EOF
<div id="my_calendar">
<table>
<tr><td colspan="4"><div id="tb_header">距离&nbsp;&nbsp;&nbsp;<span class="my_datename">{$cache['title']}&nbsp;&nbsp;&nbsp;</span><span id="mc_seperator">还有</span></div></td></tr>
	<tr>
		<td id="td_day">
			<div id="mc_day">0</div>
			<div>天</div>
		</td>
		<td id="td_hour">
			<div id="mc_hour">00</div>
			<div>时</div>
		</td>
		<td id="td_min">
			<div id="mc_min">00</div>
			<div>分</div>
		</td>
		<td id="td_sec">
			<div id="mc_sec">00</div>
			<div>秒</div>
		</td>
	</tr>
</table>
<script>
(function(window){
	var starttime=new Date({$starttime}*1000),
		endtime=new Date({$endtime}*1000),
		infoSeperator=document.getElementById("mc_seperator");
		infoDay=document.getElementById("mc_day");
		infoHour=document.getElementById("mc_hour");
		infoMin=document.getElementById("mc_min");
		infoSec=document.getElementById("mc_sec");
	function setTime(time){
		time=parseInt(time/1000);
		infoDay.innerHTML=parseInt(time/86400);
		time=parseInt(time%86400);
		t=parseInt(time/3600);
		infoHour.innerHTML=(t<10?'0'+t:t);
		time=parseInt(time%3600);
		t=parseInt(time/60);
		infoMin.innerHTML=(t<10?'0'+t:t);
		t=parseInt(time%60);
		infoSec.innerHTML=(t<10?'0'+t:t);
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
function mobilecssstr() {
	return <<<EOF
<style>
#my_calendar table{
	margin:auto;
}
#my_calendar td{
	text-align:center;
}
#my_calendar td>div{
	font-size:14px;
	display:inline-block;
}
.my_datename{
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
	function global_calendar() {
		return echostr();
	}
}
class mobileplugin_calendar {
	function global_header_mobile() {
		return mobilecssstr() . echostr();
	}
}
