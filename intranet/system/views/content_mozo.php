<?php
class Content {
	function Content(){

	}
	function PrintContent($content){
	$r = '<table class="cont" cellspacing="0" cellpadding="5" width="100%" style="border:0px solid #EEEEEE;background-color:#ffffff; max-width:700px;">';
		
		$r .= '<tr>';
			$r .= '<td class="title" align="left" valign="middle">';
				$r .= $content["title"];
			$r .= '</td>';

		$r .= '</tr>';
		
		$r .= '<tr>';
			$r .= '<td align="left" valign="top" style="border-left:1px solid #eeeeee;border-right:1px solid #eeeeee;">';
				$r .= $content["content"];
			$r .= '</td>';

		$r .= '</tr>';

	
	echo  $r;
	}


}


?>