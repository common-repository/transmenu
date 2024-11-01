<?php
/*
Plugin Name: transMenu
Plugin URI: http://www.pirex.com.br/wordpress-plugins/
Description: Creates a nice looking drop down menu for listing your pages and subpages (and more in the future) 
Author: LeoGermani
Version: 0.2.1
Author URI: http://leogermani.pirex.com.br/
*/ 

//OBS: All credits to this menu should go to:

///* =================================================================================================
 //* TransMenu 
 //* March, 2003
 //*
 //* Customizable multi-level animated DHTML menus with transparency.
 //*
 //* Copyright 2003-2004, Aaron Boodman (www.youngpup.net)
///* =================================================================================================

//All I did was to put it to work on wordpress





function transAddHeaderJS(){
?>
	<!-- transmenus //-->	
	<link rel="stylesheet" type="text/css" href="<? bloginfo('home') ?>/wp-content/plugins/transMenu/transmenu.css">
	<script language="javascript" src="<? bloginfo('home') ?>/wp-content/plugins/transMenu/transmenu.js"></script>
	<script language="javascript">
		function initTransMenu() {
			if (TransMenu.isSupported()) {
				TransMenu.initialize();
			}
		}
	</script>
	<!-- transmenus //-->
<?


}

function trans_add_menus($args = ''){

	$pages = trans_get_pages($args);
	
	?>
	
	<script language="javascript">
	 <!--
	 window.onload=initTransMenu;
	 
   	 if (TransMenu.isSupported()) {
		 var ms = new TransMenuSet(TransMenu.direction.down, 1, 0, TransMenu.reference.bottomLeft);		 
		 
		 <?php foreach($pages as $page) { ?>
			 <?php if($subpages=trans_get_pages('child_of='.$page->ID)) { ?>				 
				 var menu = ms.addMenu(document.getElementById("transMenuTop_<? echo $page->ID; ?>"));	
				 <?php $mm=0; ?>
				 <?php foreach ($subpages as $subpage) { ?>
					 
					 menu.addItem("<? echo $subpage->post_title; ?>", "<? echo get_permalink($subpage->ID); ?>");
					 <?php if($subsubpages=trans_get_pages('child_of='.$subpage->ID)) trans_add_submenus($subsubpages, 'menu.items['.$mm.']', $subpage->ID); ?>
					 <?php $mm = $mm + 1 ?>
				
				 <?php } ?>				 
			 <?php } ?>
	 	<?php } ?>
		 TransMenu.renderAll();
   	}
	//-->
	</script>
	<?
	
}


function trans_add_submenus($subpages, $item, $topID, $topmenu = 'menu'){
	//this function will loop through all pages childs and buils as many sub-menus are necessary
	?>		
			 var submenu_<?php echo $topID ?> = <?php echo $topmenu; ?>.addMenu(<?php echo $item ?>);
			 <?php $cc=0; ?>
			 <?php foreach ($subpages as $subpage) { ?>
				 
				 submenu_<?php echo $topID ?>.addItem("<? echo $subpage->post_title; ?>", "<? echo get_permalink($subpage->ID); ?>");
				 <?php if($subsubpages=trans_get_pages('child_of='.$subpage->ID)) trans_add_submenus($subsubpages, 'submenu_'.$topID.'.items['.$cc.']',$subpage->ID,'submenu_'.$topID); ?>
				 <?php $cc=$cc+1; ?>
			 <?php } ?>				 

	<?	
}


function trans_list_pages($args = ''){
	global $wp_query, $wpdb;
	$pages = trans_get_pages($args);
	$queried_obj = $wp_query->get_queried_object();
	$output = '';
	foreach ($pages as $page){
		$cur_element = '';
		if(!is_home() && !is_archive()) {
			if(($queried_obj->ID)) if($page->ID==trans_get_top_page_ID($queried_obj->ID)) $cur_element = 'class="current_page_item"';
		}
		$output.='<a href="'.get_permalink($page->ID).'" title="'.wp_specialchars($page->post_title).'" class="transmenu_page_link">'.'<li id="transMenuTop_'.$page->ID.'" '.$cur_element.'>'.$page->post_title.'</li></a>';
	}
	//$output.='';
	echo $output;
}


function trans_get_top_page_ID($page){
	global $wpdb;
	$test= $wpdb->get_row("SELECT post_parent, ID FROM $wpdb->posts WHERE ID = $page");
	if($test->post_parent!=0){
		while($test->post_parent > 0){
			$test= $wpdb->get_row("SELECT post_parent, ID FROM $wpdb->posts WHERE ID = $test->post_parent");
		}	
	}
	return $test->ID;
}


function trans_get_pages($args = '') {
	global $wpdb, $user_ID;

	parse_str($args, $r);

	if ( !isset($r['child_of']) )
		$r['child_of'] = 0;
	if ( !isset($r['sort_column']) )
		$r['sort_column'] = 'post_title';
	if ( !isset($r['sort_order']) )
		$r['sort_order'] = 'ASC';

	$exclusions = '';
	if ( !empty($r['exclude']) ) {
		$expages = preg_split('/[\s,]+/',$r['exclude']);
		if ( count($expages) ) {
			foreach ( $expages as $expage ) {
				$exclusions .= ' AND ID <> ' . intval($expage) . ' ';
			}
		}
	}
	$status = $user_ID ? "NOT LIKE 'draft'" : "= 'publish'";
	$pages = $wpdb->get_results("SELECT * " .
		"FROM $wpdb->posts " .
		"WHERE post_type = 'page' AND post_status " . $status . " AND post_parent = ". $r['child_of'] ." ".
		"$exclusions " .
		"ORDER BY " . $r['sort_column'] . " " . $r['sort_order']);

	if ( empty($pages) )
		return array();

	// Update cache.
	update_page_cache($pages);

	//if ( $r['child_of'] )
	//	$pages = & sts_get_page_children($r['child_of'], $pages);

	return $pages;
}





add_action('wp_print_scripts', 'transAddHeaderJS');
//add_filter('wp_list_pages', 'transFilterListPages');

add_action('wp_footer', 'trans_add_menus');
?>
