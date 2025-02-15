<?php
class Contentdatatable {
	function Content(){

	}
	function PrintContent($content){
	$r = '';
		
		$r .= '<div>';
			$r .= '<div>';
				$r .= $content["title"];
			$r .= '</div>';

		$r .= '</div>';
		
		$r .= '<div>';
			$r .= '<div>';
				$r .= $content["content"];
			$r .= '</div>';

		$r .= '</div>';

	
	echo  $r;
	}


}


?>