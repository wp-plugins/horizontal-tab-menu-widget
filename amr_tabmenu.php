<?php
/*
Plugin Name: AmR Tabmenu
Plugin URI: http://anmari.com
Description: Provides a tab file folder menu.
Author: Anna-marie Redpath
Version: 1.0
Author URI: http://anmari.com
Credits:  
*/
function amr_tabmenu_style()
{
    $options = get_option("amr_tabmenu");
	$style = (empty($options["style"])) ? null : $options["style"];
	if (!($style === 'NoDefaultStyle'))  /* then not using their own style */
	{
	?><style type="text/css">
	div.sidebar ul { margin: 0}
	li.amr_tabmenu ul li { display:inline; }  
	ul.amr_tabmenu, 
	li.amr_tabmenu ul, 
	li.amr_tabmenu ul li  
		{ list-style: none; margin: 0; padding:0;	}
	li.amr_tabmenu a {padding-right: 1em;}	
	</style>
	<?php
	}
}
function amr_tabmenu($args)
{
// NB - need condensed code to avoid browser whitespace issues on lists
    extract($args);
    //var_dump($args);
    $sort_opts = amr_tabmenu_get_sort_opts();
    $options = get_option("amr_tabmenu");
    $title = (empty($options["title"])) ? null : $options["title"];
	$sort_column = (array_key_exists($options["sort_column"],$sort_opts)) ? $options["sort_column"] : key($sort_opts);
		
    global $notfound;
	global $post;

	echo $before_widget;
	if (!(is_null($title))) echo  $before_title . $title . $after_title;
	if (!( is_404() or is_search())) 
	{ 	
		$p_id = $post->post_parent; /* do we have a parent*/
		if ($p_id)  /* if we have a parent (not = 0) */
		{
			amr_more_ancestors ($p_id, $sort_column);			
		}		
		/* list the siblings if there are any ie not an only child  */ 	
		$children = wp_list_pages("&depth=1&title_li=&child_of="
			.$p_id."&echo=0&sort_column=\"$sort_column\""); 
		if ($children) 		/* list any children of the parent (ie siblings) */	
		{ ?><ul class="siblingmenu"><?php echo $children; ?></ul><?php } 		
		$children = false;	
		$children = wp_list_pages("title_li=&child_of="
			.$post->ID."&echo=0&depth=1&sort_column=\"$sort_column\"");
		if ($children) { ?><ul class="childmenu"><?php echo $children; ?></ul><?php } 
	}
	echo $after_widget;
}

/* -------------------------------------------------------------------------------------------------------------*/
function amr_more_ancestors ($p_id, $sort_column)
/* This function looks recursively for more */
{	 
	$p_post = get_page($p_id);
	$gp_id = $p_post->post_parent;

	if ((!(is_null($gp_id))) and ($gp_id))  /* do we have a grandparent ? if yes, then parent is not global nav and we should list the parent & siblings*/
		{	
			amr_more_ancestors ($gp_id, $sort_column);
			$children = wp_list_pages("&depth=1&title_li=&child_of="
				.$gp_id."&echo=0&sort_column=\"$sort_column\""); 
			if ($children) 
			{ ?><ul class="parentmenu"><?php echo $children; ?></ul><?php } 
			else echo __('Unknown error: A parent has no children');
			/* else was some weird error */
		}
	else 
	{ /* we have no grandparent, so are at the top of the tree, list the top level only  */	
		$children = wp_list_pages("&depth=1&title_li=&echo=0&sort_column=\"$sort_column\""); 
		if ($children) 
			{ ?><ul class="topmenu"><?php echo $children; ?></ul><?php } 
		else echo __('Unknown error: No top level pages');
	} 
}
/* -------------------------------------------------------------------------------------------------------------*/
function amr_tabmenu_get_sort_opts() {
	return array( "post_title"=>"Title",
					"menu_order"=>"Page Order");
}
/* -------------------------------------------------------------------------------------------------------------*/
function amr_tabmenu_control() {

	$sort_opts = amr_tabmenu_get_sort_opts();
    $options = get_option("amr_tabmenu");
   
    if ( $_POST['amr_tabmenu_submit'] ) 
    {
		$options['title'] = strip_tags(stripslashes($_POST['amr_tabmenu_title']));
		$options['sort_column'] = (array_key_exists($_POST['amr_tabmenu_sort_column'], $sort_opts)) ? $_POST['amr_tabmenu_sort_column'] : key($sort_opts);
		$options['style'] = strip_tags(stripslashes($_POST['amr_tabmenu_style']));
		update_option('amr_tabmenu', $options);
    }
    $sort_column = (array_key_exists($options["sort_column"],$sort_opts)) ? $options["sort_column"] : key($sort_opts);
    $title = wp_specialchars($options['title']);
	$style = wp_specialchars($options['style']);
	$checked = '';
	if ($style === 'NoDefaultStyle') $checked = ' checked="checked"';  

?>
	<input type="hidden" id="amr_tabmenu_submit" name="amr_tabmenu_submit" value="1" />
	<p><label for="amr_tabmenu_title"><?php _e('Title:'); ?> <input style="width: 250px;" id="amr_tabmenu_title" name="amr_tabmenu_title" type="text" value="<?php echo $title; ?>" /></label></p>
	
	<p><label for="amr_tabmenu_sort_column">
		<?php _e('Sort:'); ?> 
		<select  id="amr_tabmenu_sort_column" name="amr_tabmenu_sort_column">
		<?php
		foreach ($sort_opts as $val=>$label){
			echo "<option value=\"$val\"";
			if ($sort_column == $val) echo ' selected="selected"';
			echo ">$label</option>";
		}
		?>
		</select>
	</label></p>
	<p><label for="amr_tabmenu_style"><?php _e('No default style?:'); ?> 
	<input id="amr_tabmenu_style" name="amr_tabmenu_style" type="checkbox" 
	value="NoDefaultStyle" <?php echo $checked; ?> /></label></p>
<?php
}
/* -------------------------------------------------------------------------------------------------------------*/
function amr_tabmenu_init()
{
    register_sidebar_widget("AmR tabmenu", "amr_tabmenu");
    register_widget_control("AmR tabmenu", "amr_tabmenu_control");
}
/* -------------------------------------------------------------------------------------------------------------*/
add_action("plugins_loaded", "amr_tabmenu_init");
add_action( 'wp_head', 'amr_tabmenu_style' );
?>