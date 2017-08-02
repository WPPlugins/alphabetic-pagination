<?php

global $ap_implementation, $ap_premium_link, $ap_datap, $ap_customp, $css_arr, $ap_group, $wpdb, $ap_allowed_pages, $ap_query_number, $ap_post_types, $ap_all_plugins, $ap_plugins_activated, $ap_dir, $ap_url;

	//pree($ap_all_plugins);

$mquery = "SELECT $wpdb->postmeta.meta_key FROM $wpdb->postmeta WHERE $wpdb->postmeta.meta_key NOT LIKE '\_%'  AND $wpdb->postmeta.meta_value NOT LIKE '%{%' AND $wpdb->postmeta.meta_value!=''  GROUP BY $wpdb->postmeta.meta_key ORDER BY $wpdb->postmeta.meta_key ASC";
$args = array(
	'posts_per_page'   => -1,
	'offset'           => 0,
	'category'         => '',
	'category_name'    => '',
	'orderby'          => 'title',
	'order'            => 'ASC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'page',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => true 
);
$allowed_pages = get_posts($args);

$ap_implementation = get_option('ap_implementation');
require_once('languages.php');
$dom_selectors = array(
'#main'=>'#main',
'#primary'=>'#primary',
'#content'=>'#content'
);
$ap_styles = array(
'ap_gogowords'=>'Gogo Words',
'ap_chess'=>'AP Chess',
'ap_classic'=>'AP Classic',
'ap_mahjong'=>'AP Mahjong'
);
if($ap_customp){
	$ap_styles['ap_miami'] = 'AP Miami';
}

ksort($ap_styles);
$ap_classes = implode(' ', array_keys($ap_styles));

$ap_taxonomies = get_taxonomies();
$stored_tax = get_option('ap_tax');
$stored_langs = get_option('ap_lang');

$get_post_types = get_post_types();
$ap_where_meta = get_option('ap_where_meta');


if(empty($ap_taxonomies))
$ap_taxonomies = array();

if(empty($stored_tax))
$stored_tax = array();

if(empty($stored_langs) || !is_array($stored_langs))
$stored_langs = array();



$dom_default = false;
$dom_selected = (get_option('ap_dom')==''?false:true);

$ap_all = (get_option('ap_all')==1?true:false);

$ap_numeric_sign = (get_option('ap_numeric_sign')==0?false:true);
$ap_reset_sign = (get_option('ap_reset_sign')==0?false:true);



?>

<div class="wrap ap_settings_div">

        

<div class="icon32" id="icon-options-general"><br></div><h2><?php echo $ap_datap['Name']; ?> <?php echo '('.$ap_datap['Version'].($ap_customp?') Pro':')'); ?> - <?php _e('Settings','alphabetic-pagination'); ?> </h2> 
<?php if(!$ap_customp): ?>
<a title="<?php _e('Click here to download pro version','alphabetic-pagination'); ?>" style="background-color: #25bcf0;    color: #fff !important;    padding: 2px 30px;    cursor: pointer;    text-decoration: none;    font-weight: bold;    right: 0;    position: absolute;    top: 0;    box-shadow: 1px 1px #ddd;" href="http://shop.androidbubbles.com/download/" target="_blank"><?php _e('Already a Pro Member?','alphabetic-pagination'); ?></a>
<?php endif; ?>
<div class="ap_video_tutorial"><?php _e('Click here for video tutorial','alphabetic-pagination'); ?></div>





<?php $wpurl = get_bloginfo('wpurl'); ?>



<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">







<div class="ap_notes"><?php _e('By default this plugin enables pagination on the default posts page (Settings > Reading).<br />
The following option enables Alphabetical Pagination on all other templates.','alphabetic-pagination'); ?></div>

<table class="form-table">




<tbody>

<tr>
<th scope="row"><?php _e('Implementation','alphabetic-pagination'); ?>:</th>
<td>

<fieldset>

	<p>
   <label for="ap_implementation_auto">
		<input type="radio" <?php echo ($ap_implementation!=AP_CUSTOM?'checked="checked"':''); ?> class="ap_imp" id="ap_implementation_auto" value="<?php _e('auto','alphabetic-pagination'); ?>" name="ap_implementation"><?php _e('Auto','alphabetic-pagination'); ?></label>
&nbsp;&nbsp;&nbsp;
   <label for="ap_implementation_custom">
		<input type="radio" <?php echo ($ap_implementation!=AP_CUSTOM?'':'checked="checked"'); ?> class="ap_imp" id="ap_implementation_custom" value="<?php echo AP_CUSTOM; ?>" name="ap_implementation"><?php echo ucwords(AP_CUSTOM); ?></label>
	</p>
</fieldset>

</td>
<td rowspan="7" width="54%" valign="top">
<div class="ap_shortcode <?php echo ($ap_implementation==AP_CUSTOM?'':'hide'); ?>">
<h4><?php _e('Shortcodes','alphabetic-pagination'); ?>:</h4> <?php if(!$ap_customp){ ?><a href="<?php echo $ap_premium_link; ?>" title="<?php _e('This is a premium feature.','alphabetic-pagination'); ?>" target="_blank"><?php _e('Go Premium for Shortcodes','alphabetic-pagination'); ?></a><?php } ?><br />
<br />

<code>
[ap_pagination]
</code>
<div>
or
</div>
<code>
&lt;?php echo do_shortcode('[ap_pagination]'); ?&gt;
</code>
<div>&nbsp;</div>



<h4><?php _e('Additional Shortcodes','alphabetic-pagination'); ?>:</h4>

<code>[ap_results class=&quot;ap_results&quot; type=&quot;users_list&quot;]</code><div>&nbsp;</div>

<code>[ap_results class=&quot;ap_results&quot; type=&quot;content_list&quot; thumb=&quot;false&quot;]</code><div>&nbsp;</div>

<code>[ap_pagination type="jquery" wrapper="#primary #content article" item="header &gt; h1 &gt; a"]</code>

 
</div>
<br />
<br />

<div class="alphabets_section">

<div class="alphabets_styles">
<div class="alphabets_set">
<div class="alphabets_label"><?php _e('Styles','alphabetic-pagination'); ?>:</div>
<div class="alphabets_settings">
<?php
	//pree($ap_all_plugins);
	
	if(!array_key_exists('chameleon/index.php', $ap_all_plugins)){
?>
	<a href="plugin-install.php?s=chameleon&tab=search&type=term" class="chameleon_links" target="_blank"><?php _e('Install Chameleon for Styles','alphabetic-pagination'); ?></a>
<?php		
	}elseif(!in_array('chameleon/index.php', $ap_plugins_activated)){
?>
	<a href="plugins.php?plugin_status=inactive&s=chameleon" class="chameleon_links" target="_blank"><?php _e('Activate Chameleon for Styles','alphabetic-pagination'); ?></a>
<?php		
	}else{
		global $wpc_assets_loaded, $wpc_dir, $wpc_url;
		//pree($wpc_assets_loaded);exit;
		$wp_chameleon = get_option( 'wp_chameleon');
		//pree($wpc_assets_loaded['ap']);
		//pree(get_option('ap_style'));
		//pree($wp_chameleon['ap']);
		if(isset($wpc_assets_loaded['ap']) && !empty($wpc_assets_loaded['ap'])){
			ksort($wpc_assets_loaded['ap']);
			//pree($wp_chameleon);
?>
			<select name="ap_style" id="ap_styles" class="apc_style">
            <option value=""><?php _e('Select','alphabetic-pagination'); ?></option>
<?php 		
			foreach($wpc_assets_loaded['ap'] as $style_name=>$style_data){
				
				$selected = ((isset($wp_chameleon['ap'][$style_name]) && !empty($wp_chameleon['ap'][$style_name]) && current($wp_chameleon['ap'][$style_name])=='enabled')?$style_name:'');
				
?>
			<option data-preview="<?php echo str_replace($wpc_dir, $wpc_url, $style_data['images']['screenshot']); ?>" value="<?php echo $style_name; ?>" <?php selected( $style_name, $selected ); ?>><?php echo ucwords(str_replace(array('_', '-'), ' ', $style_name)); ?></option>
<?php				
			}
			
			
			
?>
   

    

			</select>	
            <small><a href="https://www.youtube.com/embed/I8IAnf8wFpw" target="_blank" class="chameleon_links"><?php _e('Video Tutorial','alphabetic-pagination'); ?></a></small>
           
<div class="ap_preview">
<a href="" target="_blank">
<img src="" />
</a>
</div>            
<?php			
		}
		
?>
</div>
</div>

<div class="alphabets_set">
<div class="alphabets_label"><?php _e('Templates','alphabetic-pagination'); ?>:</div>
<div class="alphabets_settings">
<?php		
		if(isset($wpc_assets_loaded['apt']) && !empty($wpc_assets_loaded['apt'])){
			//pree($wp_chameleon);
?>

			<select name="ap_template" id="ap_templates" class="apc_template">
            <option value=""><?php _e('Select','alphabetic-pagination'); ?></option>
<?php 		
			foreach($wpc_assets_loaded['apt'] as $style_name=>$style_data){
				
				$selected = ((isset($wp_chameleon['apt'][$style_name]) && !empty($wp_chameleon['apt'][$style_name]) && current($wp_chameleon['apt'][$style_name])=='enabled')?$style_name:'');
				
?>
			<option data-preview="<?php echo str_replace($wpc_dir, $wpc_url, $style_data['images']['thumb']); ?>" value="<?php echo $style_name; ?>" <?php selected( $style_name, $selected ); ?>><?php echo ucwords(str_replace(array('_', '-'), ' ', $style_name)); ?></option>
<?php				
			}
			
			
			
?>
   

    

			</select>	
            

<div class="apt_preview">
<a href="" target="_blank">
<img src="" />
</a>
</div>            
<?php			
		}		
	}
	/*
?>
<select name="ap_style" id="ap_styles" class="hide">
    <option value="">Select</option>
    <?php foreach($ap_styles as $style_name=>$style_value): ?>
    <option value="<?php echo $style_name; ?>" <?php selected( $style_name, get_option('ap_style') ); ?>><?php echo $style_value; ?></option>    
    <?php endforeach; ?>        
</select>
*/
?>
</div>
</div>
</div>

<div class="alphabets_cases">
<div class="alphabets_set">
<div class="alphabets_label"><?php _e('Alphabets in?','alphabetic-pagination'); ?></div>
<div class="alphabets_settings">
<fieldset>
	
	<p><label for="case_U">
		<input type="radio" <?php echo (get_option('ap_case')=='U'?'checked="checked"':''); ?> class="tog" id="case_U" value="U" name="ap_case"><?php _e('Uppercase','alphabetic-pagination'); ?></label>

	</p>



	<p><label for="case_L">
		<input type="radio" <?php echo (get_option('ap_case')=='L'?'checked="checked"':''); ?> class="tog" id="case_L" value="L" name="ap_case"><?php _e('Lowercase','alphabetic-pagination'); ?></label>
	</p>







    

</fieldset>
</div>
</div>
<div class="alphabets_set">
<div class="alphabets_label"><?php _e('Layout?','alphabetic-pagination'); ?></div>
<div class="alphabets_settings">


<fieldset>



	<p><label for="layout_H">



		<input type="radio" <?php echo (get_option('ap_layout')=='H'?'checked="checked"':''); ?> class="tog" id="layout_H" value="H" name="ap_layout"><?php _e('Horizontal','alphabetic-pagination'); ?></label>



	</p>



	<p><label for="layout_V">



		<input type="radio" <?php echo (get_option('ap_layout')=='V'?'checked="checked"':''); ?> class="tog" id="layout_V" value="V" name="ap_layout"><?php _e('Vertical','alphabetic-pagination'); ?></label>


	</p>

    

</fieldset>
</div>
</div>

</div>




</div>

<div class="numeric_reset">
<div class="ap_numeric_sign">

<div class="ap_numeric_label"><b><?php _e('Numeric sign "#" visibility in pagination?','alphabetic-pagination'); ?></b></div>

<fieldset>
	<p>
   <label for="ap_numeric_sign_yes">
		<input type="radio" <?php echo ($ap_numeric_sign?'checked="checked"':''); ?> class="tog" id="ap_numeric_sign_yes" value="1" name="ap_numeric_sign"><?php _e('Yes','alphabetic-pagination'); ?></label>
	&nbsp;&nbsp;&nbsp;
   <label for="ap_numeric_sign_no">
		<input type="radio" <?php echo ($ap_numeric_sign?'':'checked="checked"'); ?> class="tog" id="ap_numeric_sign_no" value="0" name="ap_numeric_sign"><?php _e('No','alphabetic-pagination'); ?></label>
	</p>
</fieldset>

</div>

<div class="ap_reset_sign">

<div class="ap_reset_sign_label"><b><?php _e('View All','alphabetic-pagination'); ?>/<?php _e('Refresh','alphabetic-pagination'); ?> "<img src="<?php echo  plugin_dir_url( dirname(__FILE__) ); ?>images/reset.png"  />" <?php _e('icon visiblity?','alphabetic-pagination'); ?></b></div>

<fieldset>
	<p>
   <label for="ap_reset_sign_yes">
		<input type="radio" <?php echo ($ap_reset_sign?'checked="checked"':''); ?> class="tog" id="ap_reset_sign_yes" value="1" name="ap_reset_sign"><?php _e('Yes','alphabetic-pagination'); ?></label>
	&nbsp;&nbsp;&nbsp;
   <label for="ap_reset_sign_no">
		<input type="radio" <?php echo ($ap_reset_sign?'':'checked="checked"'); ?> class="tog" id="ap_reset_sign_no" value="0" name="ap_reset_sign"><?php _e('No','alphabetic-pagination'); ?></label>
	</p>
</fieldset>

</div>
</div>


<?php 
echo alphabets_bar();
ap_ready();
?>


<div class="ap_grouping_div">
<div class="ap_grouping_label"><b><?php _e('Alphabets Grouping?','alphabetic-pagination'); ?></b></div>

<fieldset>
	<p>
   <label for="ap_group_yes">
		<input type="radio" <?php echo ($ap_group==1?'checked="checked"':''); ?> class="tog" id="ap_group_yes" value="1" name="ap_grouping"><?php _e('Yes','alphabetic-pagination'); ?></label>
	&nbsp;&nbsp;&nbsp;
   <label for="ap_group_no">
		<input type="radio" <?php echo ($ap_group==1?'':'checked="checked"'); ?> class="tog" id="ap_group_no" value="0" name="ap_grouping"><?php _e('No','alphabetic-pagination'); ?></label>
	</p>
</fieldset>
<small class="hide"><?php _e('Save changes to have effect.','alphabetic-pagination'); ?></small>
</div>






</td>
</tr>
<?php if(!empty($allowed_pages)): ?>
<tr>
  <th scope="row"><div class="ap_allowed_pages_div"><?php _e('Allowed Pages?','alphabetic-pagination'); ?><?php if(!$ap_customp): ?><br /><small style="color:#fff; text-decoration:underline"><?php _e('Premium Feature','alphabetic-pagination'); ?></small><?php endif; ?><br />
<iframe width="200" src="https://www.youtube.com/embed/q6mUKDinrW8" frameborder="0" allowfullscreen></iframe>
</div></th>
  <td><div class="ap_allowed_pages_div">

<fieldset>
	
	<?php //pree($allowed_pages); ?>
    <select class="ap_allowed_pages" name="ap_allowed_pages[]" id="ap_allowed_pages" multiple="multiple">
    
    	
    <option value=""><?php _e('Select to Allow','alphabetic-pagination'); ?></option>    	
<?php   		
		foreach($allowed_pages as $apages){
?>
		<option <?php echo (is_array($ap_allowed_pages) && in_array($apages->ID, $ap_allowed_pages))?'selected="selected"':''; ?> value="<?php echo $apages->ID; ?>"><?php echo $apages->post_title; ?></option>    	
<?php			
		}
?>
	 </select>
     <small><?php _e('Note: Auto works with only archives, custom can work with any page including archives.','alphabetic-pagination'); ?></small>
     <?php   		
		foreach($allowed_pages as $apages){
?>
     <input placeholder="Query Number" class="hide" type="number" name="ap_query[<?php echo $apages->ID; ?>]" value="<?php echo (array_key_exists($apages->ID, $ap_query_number)?$ap_query_number[$apages->ID]:''); ?>" />
	<?php if(!empty($get_post_types) && is_array($ap_post_types)): ?>
    <select id="ap_post_types_<?php echo $apages->ID; ?>" name="ap_post_types[<?php echo $apages->ID; ?>][]" class="ap_post_types hide" multiple="multiple">
    <?php foreach($get_post_types as $key=>$val): ?>
        <option value="<?php echo $key; ?>" <?php echo (is_array($ap_post_types) && is_array($ap_post_types[$apages->ID]) && array_key_exists($apages->ID, $ap_post_types) && in_array($key, $ap_post_types[$apages->ID]))?'selected="selected"':''; ?>><?php echo ucwords(str_replace(array('_'), ' ', $val)); ?></option>
    <?php endforeach; ?>
    </select>
    <?php endif; ?>
         
     <?php 
		}
		?><br />

        <small><?php _e('Note: For pages, you should not use the main query. Try numbers from 2 to 6','alphabetic-pagination'); ?>.<br /><?php _e('Recommended: 3','alphabetic-pagination'); ?>
</small><br />
<br />

</fieldset> 

</div></td>
</tr>

<tr>
<?php endif; ?>
<th scope="row"><?php _e('Display on all lists?','alphabetic-pagination'); ?></th>
<td>



<fieldset>

	<p>
   <label for="ap_all_yes">
		<input type="radio" <?php echo ($ap_all?'checked="checked"':''); ?> class="tog" id="ap_all_yes" value="1" name="ap_all"><?php _e('Yes','alphabetic-pagination'); ?></label>
&nbsp;&nbsp;&nbsp;
   <label for="ap_all_no">
		<input type="radio" <?php echo ($ap_all?'':'checked="checked"'); ?> class="tog" id="ap_all_no" value="0" name="ap_all"><?php _e('No','alphabetic-pagination'); ?></label>
	</p>





</fieldset>


<div class="ap_tax_div <?php echo $ap_all?'hide':''; ?>">

<fieldset>

	<p>
    <select class="ap_taxes" name="ap_tax[]" id="tax_selector" multiple="multiple">
    	<option value=""><?php _e('Select','alphabetic-pagination'); ?></option>
    	<?php foreach($ap_taxonomies as $tax): ?>
    	<option value="<?php echo $tax; ?>" <?php echo in_array($tax, $stored_tax)?'selected="selected"':''; ?>><?php echo $tax; ?></option>    
        <?php endforeach; ?>  
    </select>
    
	</p>
<small><?php _e('Note: Multiple taxonomies can be selected.','alphabetic-pagination'); ?></small>
</fieldset>

</div>

<div class="ap_tax_types hide">

<fieldset>

	<p>
    <select style="background-color:#25bcf0; color:#fff;" class="ap_taxes_types" name="ap_tax_types[]" id="tax_types_selector" multiple="multiple">
    	<option value=""><?php _e('Select to Include','alphabetic-pagination'); ?></option>    	
    </select>
    <select style="background-color:#fc5151; color:#fff;" class="ap_taxes_types_x" name="ap_tax_types_x[]" id="tax_types_selector_x" multiple="multiple">
    	<option value=""><?php _e('Select to Exclude','alphabetic-pagination'); ?></option>    	
    </select>
	</p>
<small><?php _e('Note: Multiple items can be selected. Exclude will overwrite include.','alphabetic-pagination'); ?></small>
</fieldset>

 
<?php
	$meta_values = $wpdb->get_results($mquery);

	if(!empty($meta_values)){
		//pree($meta_values);
?>

<fieldset>
    <select class="ap_taxes_types" name="ap_where_meta" id="where_meta">
    
    	
    <option value=""><?php _e('Choose','alphabetic-pagination'); ?> meta_key <?php _e('for filtering','alphabetic-pagination'); ?></option>    	
<?php   		
		foreach($meta_values as $mvalues){
?>
		<option <?php echo ($mvalues->meta_key==$ap_where_meta)?'selected="selected"':''; ?> value="<?php echo $mvalues->meta_key; ?>"><?php echo $mvalues->meta_key; ?></option>    	
<?php			
		}
?>
	 </select>
     <small><?php _e('Default: post_title is default column for filtering.','alphabetic-pagination'); ?></small>
</fieldset>     
<?php        
	}

?>

</div>




</td></tr>


<tr valign="top">

<tr valign="top">

<th scope="row"><?php _e('Hide/Show pagination if only one post available?','alphabetic-pagination'); ?></th>


<td id="front-static-pages"><fieldset>


	<p><label for="signle_hide">


		<input type="radio" <?php echo (get_option('ap_single')==0?'checked="checked"':''); ?> id="signle_hide" value="0" name="ap_single"><?php _e('Hide','alphabetic-pagination'); ?></label>
&nbsp;&nbsp;&nbsp;
<label for="signle_show">

		<input type="radio" <?php echo (get_option('ap_single')==1?'checked="checked"':''); ?> id="signle_show" value="1" name="ap_single"><?php _e('Show','alphabetic-pagination'); ?></label>

	</p>

</fieldset></td>



</tr>







<tr valign="top">



<th scope="row"><?php _e('DOM Position?','alphabetic-pagination'); ?>
<br />
<div class="ap_caption"><?php _e('This is the HTML element where the Alphabetical Pagination will be placed into.','alphabetic-pagination'); ?></div>

</th>



<td>



<fieldset class="doms">

	
    <div class="dom_options <?php echo $dom_selected?'hide':''; ?>">
    <a id="dom_default"><?php _e('Default','alphabetic-pagination'); ?></a>&nbsp;|&nbsp;
    <a id="dom_custom"><?php _e('Custom','alphabetic-pagination'); ?></a>
    </div>
    
  
  	<?php if(in_array(get_option('ap_dom'), $dom_selectors)): ?>
        
    <?php $dom_default = true; ?>
    
    <?php endif; ?>
    
	
	<p>
    
    <select class="<?php echo $dom_default?'':'hide'; ?> dom_opt" name="ap_dom" id="dom_selector">
        <option value=""><?php _e('Select','alphabetic-pagination'); ?></option>
        <?php foreach($dom_selectors as $dom): ?>
        <option value="<?php echo $dom; ?>" <?php selected( $dom, get_option('ap_dom') ); ?>><?php echo $dom; ?></option>    
        <?php endforeach; ?>        
    </select>
    
    <?php echo $dom_default?'':'<input type="text" name="ap_dom" value="'.get_option('ap_dom').'" />'; ?>
    
    &nbsp;
    <a id="dom_reset" class="<?php echo $dom_selected?'':'hide'; ?>"><?php _e('Reset','alphabetic-pagination'); ?></a>
    </p>    
	
    
    
	





</fieldset>





</td></tr>







<th scope="row"><?php _e('Language selection?','alphabetic-pagination'); ?></th>



<td>

<?php if(!empty($ap_langs)): ksort($ap_langs); ?>

<fieldset>

	<p><select class="ap_langs" name="ap_lang[]" id="ap_lang_selector">

    	<?php foreach($ap_langs as $titles=>$letters):
			  $lang = ucwords($titles);
			  
		 ?>
    	<option value="<?php echo $lang; ?>" <?php echo in_array($lang, $stored_langs)?'selected="selected"':''; ?>><?php echo $lang; ?></option>    
        <?php endforeach; ?>  
    </select></p>

</fieldset>

<?php endif; ?>



</td></tr>



</tbody></table>

<p class="submit"><input type="submit" value="<?php _e('Save Changes','alphabetic-pagination'); ?>" class="button button-primary" id="submit" name="submit"></p>

</form>


<div class="ap_video_slide">
<h3><?php _e('Video Tutorial','alphabetic-pagination'); ?>:</h3>
<?php if(ap_vimeo_is_connected()): ?>
<iframe src="//player.vimeo.com/video/105855225" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
<?php else: ?>
<p><?php _e('No Internet Access.','alphabetic-pagination'); ?></p>
<?php endif; ?><br />
<br />

<a class="ap_slide_close"><?php _e('Close','alphabetic-pagination'); ?> >></a>
</div>

</div>

<script type="text/javascript" language="javascript">
jQuery(document).ready(function($) {
	
	
	setInterval(function(){ jQuery('.useful_link').fadeTo('slow', 0).fadeTo('slow', 1.0);
	
		
	
	}, 1000*60);
	
	jQuery('#dom_selector').click(function(){
		if(jQuery(this).val()=='Custom'){
		
		jQuery(this).parent().append('<input type="text" name="ap_dom" value="<?php echo get_option('ap_dom'); ?>" />');
		jQuery(this).remove();
		}
	});
	
	if($('#adminmenu li.current a.current').length>0){
		var title = $('#adminmenu li.current a.current').html();
		title = title.split(' ');
		var updated_title = title[0]+' <span>'+title[1]+'</span>';
		$('#adminmenu li.current a.current').html(updated_title);
	}
	
	$('.ap_grouping_div fieldset input[type="radio"]').change(function(){
		$('.ap_grouping_div').find('small').fadeIn();
	});
	
	

	jQuery('#dom_custom').click(function(){
		
		
		jQuery('#dom_selector').hide();
		jQuery('#dom_selector').parent().find('#dom_reset').before('<input type="text" name="ap_dom" value="<?php echo get_option('ap_dom'); ?>" />');	
		jQuery('.dom_options').hide();
		jQuery('#dom_reset').show();
		
	});	
	
	jQuery('#dom_default').click(function(){
		
		jQuery(this).parent().hide();
		jQuery('#dom_selector').show();
		jQuery('#dom_reset').show();
		
	});
	
	jQuery('#dom_reset').click(function(){
		jQuery(this).hide();
		jQuery('.dom_opt').hide();
		jQuery('.dom_options').show();
		jQuery('#dom_selector').parent().find('input[name="ap_dom"]').remove();
		
	});
	
	jQuery('#ap_all_no').click(function(){
		jQuery('.ap_tax_div').slideDown();
	});
	jQuery('#ap_all_yes').click(function(){
		jQuery('.ap_tax_div').slideUp();
	});

	jQuery('input.ap_imp').click(function(){
		switch(jQuery(this).val()){
			case '<?php echo AP_CUSTOM; ?>':
				jQuery('div.ap_shortcode, div.ap_allowed_pages_div').slideDown('slow');
			break;
			default:
				jQuery('div.ap_shortcode, div.ap_allowed_pages_div').slideUp('slow');
			break;
		}
	
	});


        jQuery('input[name="ap_layout"]').click(function(){
		jQuery('.ap_pagination').removeClass('layout_H');
                jQuery('.ap_pagination').removeClass('layout_V');
                jQuery('.ap_pagination').addClass(jQuery(this).attr('id'));
	});
        
        jQuery('input[name="ap_case"]').click(function(){
		jQuery('.ap_pagination').removeClass('case_U');
                jQuery('.ap_pagination').removeClass('case_L');
                jQuery('.ap_pagination').addClass(jQuery(this).attr('id'));
	});
	
	jQuery('select[name="ap_style"]').change(function(){
                               
                jQuery('.ap_pagination').removeClass('<?php echo $ap_classes; ?>').addClass(jQuery(this).val());
     });
		
	jQuery('input.ap_imp:checked').click();
	
	
	$('select.apc_style').on('change keyup', function(){

		var preview = $(this).find('option:selected').data('preview');
		$('.ap_preview a').attr('href', preview);
		$('.ap_preview img').attr('src', preview);
		if($(this).val()==''){
			$('.ap_preview').hide();
		}else{
			$('.ap_preview').show();
		}
		
	});	
	
	
	$('select.apc_template').on('change keyup', function(){

		var preview = $(this).find('option:selected').data('preview');
		$('.apt_preview a').attr('href', preview);
		$('.apt_preview img').attr('src', preview);
		if($(this).val()==''){
			$('.apt_preview').hide();
		}else{
			$('.apt_preview').show();
		}
		
	});		
	
	
	
	
	setTimeout(function(){
		if($('select.apc_style').length>0){
			$('select.apc_style').change();
		}
		
		if($('select.apc_template').length>0){
			$('select.apc_template').change();
		}		
	}, 1000);
	
});	
</script>

<style type="text/css">
<?php echo implode('', $css_arr); ?>
	#wpfooter{
		display:none;
	}
<?php if(!$ap_customp): ?>

	#adminmenu li.current a.current {
		font-size: 12px !important;
		font-weight: bold !important;
		padding: 6px 0px 6px 12px !important;
	}
	#adminmenu li.current a.current,
	#adminmenu li.current a.current span:hover{
		color:#25bcf0;
	}
	#adminmenu li.current a.current:hover,
	#adminmenu li.current a.current span{
		color:#fc5151;
	}	
<?php endif; ?>
	.woocommerce-message,
	.update-nag{
		display:none;
	}
</style>
