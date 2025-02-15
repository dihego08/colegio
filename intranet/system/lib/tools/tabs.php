<?php

class Tabs{


	private $baseurl = "";
	
	function Tabs(){
		
		$this->baseurl = BASEURL;
	}
	function getTab($data){
	$r = '<script type="text/javascript">';
	$r .= '$(document).ready(function (){';
	
		$r .= '$(".tab_content").hide();';
		$r .= '$("ul.tabs li:first").addClass("active").show();';
		$r .= '$(".tab_content:first").show();';
		$r .= '$("ul.tabs li").click(function() {';

			$r .= '$("ul.tabs li").removeClass("active");';
			$r .= '$(this).addClass("active");';
			$r .= '$(".tab_content").hide();';

			$r .= 'var activeTab = $(this).find("a").attr("href");';
			$r .= '$(activeTab).fadeIn();';
			$r .= 'return false;';
		$r .= '});';
	$r .= '});';
	
	$r .= '</script>';



		$r .= '<br/><ul class="tabs">';
		$container = '';
		$inc = 1;
		foreach(array_keys($data) as $row)
		{
			$r .= '<li><a href="#tab'.$inc.'">'.$row.'</a></li>';
			$container .= '<div id="tab'.$inc.'" class="tab_content">'.$data[$row].'</div>';
			++$inc;
		}
		$r .= '</ul>';
		
		$r .= '<div class="tab_container">';
			
		$r .= $container;	

		$r .= '</div>';

			$r .= '<style type="text/css">';

$r .= 'ul.tabs {';
	$r .= 'margin-bottom: -1px;';
	$r .= 'padding: 0;';
	$r .= 'float: left;';
	$r .= 'list-style: none;';
	// $r .= 'height: 32px;';
	$r .= 'border-bottom: 3px solid #eeeeee;';
	$r .= 'border-left: 0px solid #999;';
	$r .= 'width: 100%;';
$r .= '}';
$r .= 'ul.tabs li {';
	$r .= 'float: left;';
	$r .= 'margin: 0;';
	$r .= 'padding: 0;';
	/*height: 31px; /*--Subtract 1px from the height of the unordered list--*/
	$r .= 'line-height: 31px;'; 
	$r .= 'border: 0px solid #333;';
	$r .= 'border-left: none;';
	$r .= 'margin-bottom: 0px; ';
	$r .= 'overflow: hidden;';
	$r .= 'position: relative;';
	$r .= 'color:#555;';

$r .= '}';
$r .= 'ul.tabs li a {';
	$r .= 'text-decoration: none;';
	$r .= 'color: #555;';
	$r .= 'display: block;';
	$r .= 'font-size: 9pt;';
	$r .= 'padding: 0 20px;';
	$r .= 'border: 0px solid #fff;'; 
	$r .= 'outline: none;';
$r .= '}';
$r .= 'ul.tabs li a:hover {';
	$r .= 'color:#000;';
	$r .= 'background-color: #f5f5f5;';
$r .= '}';
$r .= 'html ul.tabs li.active, html ul.tabs li.active a:hover  { ';
	$r .= 'background-color: #eeeeee;';
	$r .= 'border-bottom: 0px solid #333;';
$r .= '}';
$r .= '.tab_container {';
	$r .= 'border: 0px solid #333;';
	$r .= 'border-top: none;';
	$r .= 'overflow: hidden;';
	$r .= 'clear: both;';
	$r .= 'float: left; width: 100%;';
	$r .= 'cursor:default;';
	
$r .= '}';
$r .= '.tab_content {';
	$r .= 'padding: 10px;';
	$r .= 'cursor:default;';
$r .= '}';
	$r .= '</style>';
		
		
		return $r;
	}			
	
	
	
	
	
	
	
}