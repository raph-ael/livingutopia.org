<?php
/* ------------------------------------------------------------------------- *
 *  Custom functions
/* ------------------------------------------------------------------------- */
	
	// Add your custom functions here, or overwrite existing ones. Read more how to use:
	// http://codex.wordpress.org/Child_Themes
	
function kreis_func( $atts, $content ) {
	$a = shortcode_atts( array(
			
		'farbe' => 'orange',
		'groesse' => 'normal',
		'link' => false,
		'style' => 'float:none;'
		
	), $atts );
	
	/*
	$position = 'mitte';
	$farbe = 'orange';
	$groesse = 'normal';
	
	$possible = array(
		'mitte' => true,
		'links' => true,
		'rechts' => true,
		'orange' => true,
		'mitte' => true,
		'links' => true,
		'rechts' => true
	);
	
	$farbe = array(
		'orange' => true
	);
	
	if(isset($possible[$a['position']]))
	{
		$position = $a['position'];
	}
	
	$a['farbe'] = strtolower($a['farbe']);
	$a['position'] = strtolower($a['position']);
	$a['groesse'] = strtolower($a['groesse']);
	
	if(isset($possible[$a['']]))
	{
		
	}
	*/
	$tag = 'span';
	if($a['link'] !== false)
	{
		
		$tag = 'a';
		$link = ' href="'.$a['link'].'"';
	}
	
	$pre = '';
	$after = '';

	return $pre.'<'.$tag.$link.' class="kreis '.$a['farbe'].' '.$a['groesse'].'" style="'.$a['style'].'">' . $content . '</'.$tag.'>'.$after;
}

add_shortcode( 'kreis', 'kreis_func' );