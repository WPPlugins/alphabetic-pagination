<?php

	

	function ap_search_orderby($orderby) {
	
		global $wpdb, $ap;	
	
		if ( $ap!='' ) {
			$orderby = $wpdb->prefix . "posts.post_title ASC";	
		}
	
		return $orderby;
	
	}
	
	add_filter( 'wp_title', 'ap_page_title', 10, 2 );
	
	function ap_page_title($title){
		global $ap;
		if ( $title!='' && $ap!=''){
			return $title.' with '.$ap.' | ';
		}else{
			return $title;
		}
	}

	//FOR QUICK DEBUGGING

	
	if(!function_exists('pre')){
	function pre($data){
			if(isset($_GET['debug'])){
				pree($data);
			}
		}	 
	} 	
	if(!function_exists('pree')){
	function pree($data){
				echo '<pre>';
				print_r($data);
				echo '</pre>';	
		
		}	 
	} 


	if(!function_exists('ap_vimeo_is_connected')){
		function ap_vimeo_is_connected()
		{
			$connected = @fsockopen("vimeo.com", 80); 
												
			if ($connected){
				$is_conn = true; //action when connected
				fclose($connected);
			}else{
				$is_conn = false; //action in connection failure
			}
			return $is_conn;
		
		}
	}
	
	if(!function_exists('ap_init_actions')){
		function ap_init_actions(){
			global $ap_current_cat;
	
			$categories = get_the_category();
			$ap_current_cat = $categories;

		}
	}


	function ap_menu()
	{
		global $ap_customp;
		
		$title = 'Alphabetic Pagination'.($ap_customp?' '.__('Pro', 'alphabetic-pagination'):'');
		
		add_options_page($title, $title, 'install_plugins', 'alphabetc_pagination', 'alphabetc_pagination');



	}

	function alphabetc_pagination(){ 



		if ( !current_user_can( 'install_plugins' ) )  {



			wp_die( __( 'You do not have sufficient permissions to access this page.', 'alphabetic-pagination' ) );



		}



		global $wpdb, $ap_group; 

		

		

		if(isset($_REQUEST['ap_layout']) && in_array($_REQUEST['ap_layout'], array('H', 'V')))		

		{

			update_option( 'ap_layout', $_REQUEST['ap_layout'] );

		}

		

		if(isset($_REQUEST['ap_case']) && in_array($_REQUEST['ap_case'], array('U', 'L')))		

		{

			update_option( 'ap_case', $_REQUEST['ap_case'] );

		}
		if(isset($_REQUEST['ap_single']) && in_array($_REQUEST['ap_single'], array(1, 0)))		

		{

			update_option( 'ap_single', $_REQUEST['ap_single'] );

		}		
	
		if(isset($_REQUEST['ap_dom'])){
			
			if($_REQUEST['ap_dom']!='')
			update_option( 'ap_dom', $_REQUEST['ap_dom'] );
			else
			update_option( 'ap_dom', '' );

		}
		
		if(isset($_REQUEST['ap_implementation'])){
			
			if($_REQUEST['ap_implementation']!='')
			update_option( 'ap_implementation', $_REQUEST['ap_implementation'] );
			else
			update_option( 'ap_implementation', '' );

		}		
		
		
		
		if(isset($_REQUEST['ap_tax']) && !empty($_REQUEST['ap_tax']))		

		{


			update_option( 'ap_tax', $_REQUEST['ap_tax'] );

		}
		
		if(isset($_REQUEST['ap_tax_types']) && !empty($_REQUEST['ap_tax_types']))		

		{


			update_option( 'ap_tax_types', $_REQUEST['ap_tax_types'] );

		}	
		
		if(isset($_REQUEST['ap_tax_types_x']) && !empty($_REQUEST['ap_tax_types_x']))		

		{


			update_option( 'ap_tax_types_x', $_REQUEST['ap_tax_types_x'] );

		}	
		
		if(isset($_REQUEST['ap_where_meta']))		

		{
			update_option( 'ap_where_meta', $_REQUEST['ap_where_meta'] );

		}	
		
		if(isset($_REQUEST['ap_allowed_pages']))		

		{
			update_option( 'ap_allowed_pages', $_REQUEST['ap_allowed_pages'] );

		}	
		
		if(isset($_REQUEST['ap_query']))		

		{
			update_option( 'ap_query', $_REQUEST['ap_query'] );

		}			
		
		if(isset($_REQUEST['ap_post_types']))		

		{
			update_option( 'ap_post_types', $_REQUEST['ap_post_types'] );

		}					
		
		
		//pree($_REQUEST);exit;							
		
		if(isset($_REQUEST['ap_all'])){
		
		 	if($_REQUEST['ap_all']==1)
			update_option( 'ap_all', 1);
			else
			update_option( 'ap_all', 0);
		}			
		
		if(isset($_REQUEST['ap_numeric_sign'])){
		
		 	if($_REQUEST['ap_numeric_sign']==1)
			update_option( 'ap_numeric_sign', 1);
			else
			update_option( 'ap_numeric_sign', 0);
		}			
				
		if(isset($_REQUEST['ap_reset_sign'])){
		
		 	if($_REQUEST['ap_reset_sign']==1)
			update_option( 'ap_reset_sign', 1);
			else
			update_option( 'ap_reset_sign', 0);
		}	
				
		if(isset($_REQUEST['ap_lang']) && !empty($_REQUEST['ap_lang']))		

		{


			update_option( 'ap_lang', $_REQUEST['ap_lang'] );

		}			
			
        /*        
 		if(isset($_REQUEST['ap_style']) && !empty($_REQUEST['ap_style'])){
			update_option( 'ap_style', $_REQUEST['ap_style'] );
		}	               
		*/
				
		
		
 		if(isset($_REQUEST['ap_grouping'])){
			update_option( 'ap_grouping', $_REQUEST['ap_grouping'] );
			
		}	 
		$ap_group = (get_option('ap_grouping')==0?false:true);
				
		include('ap_settings.php');	

		

	}	

	
	function ap_add_query_vars( $vars ){
	  global $ap_vv;
	  $ap_vv = $vars;
	  return $vars;
	}
	
	
	
	function ap_get_query_vars(){
		global $ap_vv;
		$v_val = array();
		if(!empty($vv)){
			foreach($vv as $vals){
				$v_val[$vals] = get_query_var($vals, '');
			}
			$v_val = array_filter($v_val, 'strlen');
			$v_val = array_filter($v_val, 'is_numeric');
			$v_val = array_keys();
		}
											
		return $v_val;									
	}

	function ap_remove_var($url, $key) { 
		$url = preg_replace('/(.*)(?|&)' . $key . '=[^&]+?(&)(.*)/i', '$1$2$4', $url . '&'); 
		$url = substr($url, 0, -1); 
		
		$in = '/'.$key;
		if(stristr($url, $in)){
			$url2 = explode($in, $url);
			$url = current($url2);
		}
		
		return $url; 
	}
	

	
	if(!function_exists('ap_url_reset')){
		function ap_url_reset($alphabetz_bar){  
		
			$ap_reset_sign = (get_option('ap_reset_sign')==0?false:true);
			if($ap_reset_sign){
				global $arg;
	
				$url = $_SERVER['REQUEST_URI'];
				
				if(
					(!isset($_GET[$arg]) && get_query_var('paged', 0)!=0)
					||	
					(isset($_GET[$arg]) && $ap!='numeric')
				){
					$url_x = ap_remove_var( $url, 'page' );
				}else{
					$url_x = $url;
				}
				
				$url_reset = parse_url($url);
				$url_reset = (isset($url_reset['path'])?$url_reset['path']:'');		
				
				

				$alphabetz_bar .= '<li class="ap_reset">';
				$alphabetz_bar .= '<a href="'.$url_reset.'">&nbsp;</a>';
				$alphabetz_bar .= '</li>';				
			
			}			
			
			return $alphabetz_bar;
		}
	}
				
	if(!function_exists('alphabets_bar')){
                    function alphabets_bar(){                                			
                                            global $ap, $ap_customp, $arg, $ap_queries, $ap_group;
											
											$languages_selected = get_option('ap_lang', array());
											$languages_selected = is_array($languages_selected)?$languages_selected:array();
											//pree($languages_selected);
											
											$url = $_SERVER['REQUEST_URI'];
											
                                            $alphabets = ap_alphabets();
                                            
											//pre($alphabets);
											
                                            $alphabetz_bar = '';

                                            foreach($alphabets as $language=>$alphabetz){
												$selected = '';											
												if(is_admin()){
													$selected = 'hide';	
													if(in_array(ucwords($language), $languages_selected)){
														$selected = 'ap_slanguage';
														
													}
												}
                                         

																					    
                                            $alphabetz_bar .= '<ul class="ap_'.$language.' '.$selected.' ap_pagination case_'.get_option('ap_case').' layout_'.get_option('ap_layout').' '.get_option('ap_style').' by_'.$ap_queries.'">';
											
											
											$alphabetz_bar = ap_url_reset($alphabetz_bar);
											
											$alphabetz_bar .= '<li class="ap_numeric">';
                                            $alphabetz_bar .= '<a href="'.add_query_arg( array($arg => 'numeric'), $url_x).'"  class="'.(strtolower($ap)=='numeric'?'selected':'').'">#</a>';

                                            $alphabetz_bar .= '</li>';
																								
											
											$alpha_count = 0;
											$alpha_jump = ($ap_group?4:0);
											$alpha_jump_count = 0;
											$alpha_jump_arr = array();
											
                                            foreach($alphabetz as $num=>$alphabet){
											
											$alpha_count++;	
												
													if(
														(!isset($_GET[$arg]) && get_query_var('paged', 0)!=0)
														||	
														(isset($_GET[$arg]) && $ap!=$alphabet)
													){
														$url_x = ap_remove_var( $url, 'page' );
													}else{
														$url_x = $url;
													}	
													
													
													
														if($alpha_jump==0){										
																										
															$alphabetz_bar .= '<li class="ap_'.strtolower($alphabet).' ap_an_'.$num.'">';
															$alphabetz_bar .= '<a href="'.add_query_arg( array($arg => $alphabet), $url_x).'" class="'.(strtolower($ap)==$alphabet?'selected':'').'">'.$alphabet.'</a>';
															$alphabetz_bar .= '</li>';
																													
														}else{
															
															$alpha_jump_count++;
															
															if($alpha_jump_count<=$alpha_jump){
																$alpha_jump_arr[] = $alphabet;
																if($alpha_jump_count==$alpha_jump || $alpha_count==count($alphabetz)){
																	$alphabet_arg = current($alpha_jump_arr).(current($alpha_jump_arr)!=end($alpha_jump_arr)?'-'.end($alpha_jump_arr):'');
																	$alphabet_str = implode(' ap_', $alpha_jump_arr);
																	$alphabetz_bar .= '<li class="ap_'.strtolower($alphabet_str).'">';
																	$alphabetz_bar .= '<a href="'.add_query_arg( array($arg => $alphabet_arg), $url_x).'" class="'.(strtolower($ap)==$alphabet_arg?'selected':'').'">'.$alphabet_arg.'</a>';
																	$alphabetz_bar .= '</li>';
																}
															}else{					
																$alpha_jump_arr = array();
																$alpha_jump_arr[] = $alphabet;
																$alpha_jump_count = 1;
															}
															
															
															
															
														}
													
                                                    }

                                                    $alphabetz_bar .= '</ul>';
                                            }
											
											//pre($alphabetz_bar);
											
                                            //pre($alpha_jump_arr);
                                            return $alphabetz_bar;
											
											
                    }
       }
                                
	if(!function_exists('ap_tax_types_callback')){    
		function ap_tax_types_callback() {
			
			if(!isset($_POST['type']))
			die();
			
			global $wpdb;
			$return['msg'] = false;
			$return = array();
			
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => $_POST['type'],
				'pad_counts'               => false 
			
			); 
			
			$categories = get_categories( $args );
			
			if(!empty($categories)){
				$return['msg'] = true;
				$return['data'][0] = 'Select to ';
				$return['selected'] = get_option('ap_tax_types');
				$return['selected_x'] = get_option('ap_tax_types_x');
				$lang = get_option('ap_lang');
				//print_r($lang);
				foreach($categories as $cats){
					$return['data'][$cats->cat_ID] = $cats->cat_name;//(!in_array('English')?'Category ID: '.$cats->cat_ID:$cats->cat_name);
				}
			}
			//print_r($return);exit;
			echo json_encode($return);
			exit;
		}		                        
	}
	function ap_gtz($value){
		return $value > 0;
	}
	if(!function_exists('ap_has_term')){
	function ap_has_term($taxonomy){
			
			global $ap_current_cat;
			
			$response = false;
			
			$ap_tax_types = get_option('ap_tax_types');
			$ap_tax_types = (is_array($ap_tax_types)?$ap_tax_types:array());
			$ap_tax_types = array_filter($ap_tax_types, 'ap_gtz');
			
			$ap_tax_types_x = get_option('ap_tax_types_x');
			$ap_tax_types_x = (is_array($ap_tax_types_x)?$ap_tax_types_x:array());
			$ap_tax_types_x = array_filter($ap_tax_types_x, 'ap_gtz');
			
			//pree($taxonomy);
			//pre($ap_tax_types);
			
			switch($taxonomy){
				
				case 'category':
					//pree($ap_current_cat);
					$categories = $ap_current_cat;//get_the_category();
					$current_cat = ((isset($categories[0]) && isset($categories[0]->cat_ID))?$categories[0]->cat_ID:'');					
					
					//pre($current_cat);
										
					$response = is_category();
					if($response){
						$current_cat = get_query_var('cat'); 
						
					}					
					
					//pre($response);
					//pree($ap_tax_types);
					//pree($ap_tax_types_x);
					
					//pre(is_array($ap_tax_types_x));
					//pre(!empty($ap_tax_types_x));
					//pre(!in_array($current_cat, $ap_tax_types_x));
					
					if(!empty($ap_tax_types)){
						$response = (
											in_array($current_cat, $ap_tax_types)
										&& 
											!in_array($current_cat, $ap_tax_types_x)
											
									);
					}
					
					//pre($response);
					
				break;
				case 'post_tag':
					$response = is_tag();
				break;	
				default:
					$response = has_term('', $taxonomy);
				break;							
				
			}
			
			return $response;
		}
	}

	if(!function_exists('ap_go')){
	function ap_go(){
		
		
		
		$allowed_taxes = get_option('ap_tax');
		//pree($allowed_taxes);
		//pre(get_option('ap_all'));
		$ap_go = FALSE;
		if(!empty($allowed_taxes) && $allowed_taxes[0]!=''){
			
			foreach($allowed_taxes as $taxonomy_allowed){
				//pree($taxonomy_allowed);
				$ap_go = ap_has_term($taxonomy_allowed);
				if($ap_go)
				break;
			}
		}

		 if(!$ap_go && get_option('ap_all')){				
			$ap_go = TRUE; 				
		}
		
		if($ap_go){		
			global $post, $wp_query, $ap;
			
			$condition = true;
			if($ap=='' && have_posts() && !get_option('ap_single'))
			$condition = ($wp_query->post_count>1);
			
			$ap_go = (!is_single() && $condition);		
		}
		
		return $ap_go;
	}
	}
	
	if(!function_exists('ap_ready')){
	function ap_ready(){

			$class = '.ap_pagination';
			
			if(is_admin()){
				$class .= '.ap_slanguage';
			}
			
			$ready = '<script type="text/javascript" language="javascript">
			jQuery(document).ready(function($) {
			setTimeout(function(){	
			//console.log("'.$class.'");
			if($("'.$class.'").length){
			$("'.$class.'").eq(0).show();
			} }, 1000);
			
			});
			</script>';
			echo $ready;
		
		
		}
	}


	
	if(!function_exists('ap_start')){
	function ap_start(){	



				ap_backup_pro();
				update_option( 'ap_case', 'U');
				update_option( 'ap_layout', 'H');
				update_option( 'ap_dom', '#content' );

		}	





	}

	if(!function_exists('ap_end')){
	function ap_end(){	

				delete_option( 'ap_case');
				delete_option( 'ap_layout');
				delete_option( 'ap_dom');

		}
	}	

	

	if(!function_exists('ap_where_meta')){
		function ap_where_meta($where='', $ap_force=''){
			
			global $wpdb, $ap, $where_meta;
			
			//pree($where);

			
			//$where_meta = get_option('ap_where_meta');
			$continuity = ($ap_force=='');
			$ap = ($continuity?$ap:$ap_force);
			//pree($continuity);
			
			//pre($where);
			//pree($ap);exit;
			
			$ands = explode('AND', $where);
			$awhere = array();
			//pre($ands);
			if(!empty($ands) && $where_meta!=''){
				foreach($ands as $and){
					//pre(stripos($and, $wpdb->postmeta));
					if(stripos($and, $wpdb->postmeta)){								
						$ob += substr_count($and, '(');
						$cb += substr_count($and, ')');
						//pree($ob);
						//pree($cb);
					}else{
						$awhere[] = $and;
					}
				}
				//pre($awhere);
				if(!empty($awhere)){
					$where = implode('AND', $awhere).')';
					if(!$continuity){
						$whr = trim($where);
						//pre($whr);
						$where = substr(trim($whr), strlen('AND'), strlen($whr));
						//pre($where);
					}
					$where .= " AND ($wpdb->postmeta.meta_key = '$where_meta' AND $wpdb->postmeta.meta_value LIKE ".ap_char_type()."'".esc_sql($ap)."%')  ";
					//pree($where);exit;
					//pree($continuity);
				}
			}else{				
			
				$where .= ' AND '.$wpdb->prefix.'posts.post_title LIKE '.ap_char_type().'"'.esc_sql($ap).'%"';
				
			}	
			//pree($where);
			return $where;		
		}
	}

	function ap_char_type(){
		global $ap_lang;
		
		
		$type = '';
		switch($ap_lang){
			case 'hungarian':
				$type = 'BINARY _utf8';
			break;
		}
		
		return $type;
	}
	

	if(!function_exists('ap_where_meta_clean')){
		function ap_where_meta_clean($where=''){
			
			global $where_meta;
									
			if($where_meta=='')
			return $where;
				
			$obt = substr_count($where, '(');
			$cbt = substr_count($where, ')');
			
			if($obt!=$cbt){
				$xwhere = explode('AND', $where);
				//pree($xwhere);
				$twhere = array();
				if(!empty($xwhere)){
					foreach($xwhere as $xwhr){
						$ob = substr_count($xwhr, '(');
						$cb = substr_count($xwhr, ')');
						//echo ($ob).'|'.($cb).' > '.$xwhr.'<br />';
						$xwhr = trim($xwhr);
						if($ob!=$cb){
							if($ob<$cb){
								$c = ($cb-$ob);
								$twhere[] = str_repeat('(', $c).$xwhr;
							}else{
								$c = ($ob-$cb);
								$twhere[] = $xwhr.str_repeat(')', $c);
							}
						}else{
							$twhere[] = $xwhr;
						}
					}
					if(!empty($twhere)){
						$twhere = array_filter($twhere, 'strlen');
						//pre($twhere);
						$where = implode(' AND ', $twhere);
					}
				}
			}else{
				$xwhere = explode('AND', $where);
				//pree($xwhere);
				$twhere = array();
				if(!empty($xwhere)){
					foreach($xwhere as $xwhr){	
							$xwhr = trim($xwhr);					
							$twhere[] = $xwhr;
					}	
				}			
				if(!empty($twhere)){
					
					$twhere = array_filter($twhere, 'strlen');	
					//pree($twhere);			
					$where = implode(' AND ', $twhere);
				}				
			}
			
			return $where;
		}
	}

	if(!function_exists('ap_compability')){
		function ap_compability(){
			global $ap_compability_arr, $post;
			$compability_mode = false;
			if($ap_compability_arr['marketpress']['activated'] &&  strpos('>'.$post->post_content, '[mp_list_products]')>0){
				$compability_mode = true;
				set_ap_query_n($ap_compability_arr['marketpress']['ap_query']);
			}		
			
			return $compability_mode;	

		}
	}
	if(!function_exists('ap_where_clause')){
		function ap_where_clause($where=''){
			
			global $wpdb, $ap_queries, $post, $ap_query, $ap, $ap_customp, $where_meta, $ap_allowed_pages, $ap_query_number, $ap_implementation, $ap_all_plugins, $ap_plugins_activated;
			
			$ap_queries++;
			
			$compability_mode = ap_compability();
			

			
			//pree($ap_query.' | '.$ap_queries);
			//pree($ap_allowed_pages);
			//pree($post);
			//pree(is_page());
			//pree($post);
			
			if(is_page()){
				//pree($ap_query.' | '.$ap_queries);
				$q_obj = get_queried_object();
				if(isset($q_obj->ID) && in_array($q_obj->ID, $ap_allowed_pages)){
					
					if(array_key_exists($q_obj->ID, $ap_query_number) && $ap_query_number[$q_obj->ID]>0){
						$ap_query = $ap_query_number[$q_obj->ID];
					}
					//pree($q_obj);
				}elseif(!$compability_mode){
					//pree(is_page());
					
					return $where;
				}
			}
			
			if($compability_mode){
				
			}elseif($ap_implementation!=AP_CUSTOM){
				$ap_query = 1;
			}

			
			$dt = debug_backtrace();
			//pree($dt[1]['function']);
			
			
			
			

			
			
			$where_meta = get_option('ap_where_meta');
			
			
			
			$ap_query = (int)$ap_query;
			//pree($ap_query.' | '.$ap_queries);
			if(!$ap_query || ($ap_query && $ap_query!=$ap_queries))
			return $where;
			
			//pree($ap_query.' | '.$ap_queries);
			//pree($ap_queries);
			//$ap_query && $ap_query==$ap_queries && 

			
			if($ap=='numeric'){
				$where .= ' AND '.$wpdb->prefix.'posts.post_title NOT REGEXP \'^[[:alpha:]]\'';
			}else{
				$ap_arr = explode('-', $ap);
				$ap_arr = array_filter($ap_arr, 'strlen');
				if(count($ap_arr)>1){
					$ap_arr = range(current($ap_arr), end($ap_arr));
					$where .= ' AND (';
					$mwhere = array();
					foreach($ap_arr as $ap){
						$mwhere[] = $wpdb->prefix.'posts.post_title LIKE '.ap_char_type().'"'.esc_sql($ap).'%"';
					}
					//COLLATE utf8_bin
					$where .= implode(' OR ', $mwhere).')';
				}elseif($ap!=''){
				
					$where = ap_where_meta($where);
				}
				
				
			}
			
			
			//pree($where);
			$where = ap_where_meta_clean($where);
			//pree($obt);
			//pre($where);
			//echo $where;
			if(function_exists('ap_disable_empty')){
				
				//pree($ap_queries);
				ap_disable_empty($where);
			}
			ready_alphabets();
						
			//pree($ap_queries);
			//echo $where.'<br /><br />';
			if(
				array_key_exists('woocommerce/woocommerce.php', $ap_all_plugins)
				&&				
				in_array('woocommerce/woocommerce.php', $ap_plugins_activated)
				&&
				ap_is_woocommerce_page()
				//(!empty($_GET) && (isset($_GET['orderby']) || isset($_GET['order'])))
				
			){
			}else{
				add_filter('posts_orderby', 'ap_search_orderby', 999);
				
			}
			
			$where = ($where_meta!=''?' AND ':'').$where;
			//$where = ap_where_meta_clean($where);
			//pree($where);
			
			//pree($where);
			//pree($ap_queries);	
			
			return $where;
			
	
		}
	}
	if(!function_exists('ap_is_woocommerce_page')){
		function ap_is_woocommerce_page () {
				if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
						return true;
				}
				$woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
												"woocommerce_terms_page_id" ,
												"woocommerce_cart_page_id" ,
												"woocommerce_checkout_page_id" ,
												"woocommerce_pay_page_id" ,
												"woocommerce_thanks_page_id" ,
												"woocommerce_myaccount_page_id" ,
												"woocommerce_edit_address_page_id" ,
												"woocommerce_view_order_page_id" ,
												"woocommerce_change_password_page_id" ,
												"woocommerce_logout_page_id" ,
												"woocommerce_lost_password_page_id" ) ;
				foreach ( $woocommerce_keys as $wc_page_id ) {
						if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
								return true ;
						}
				}
				return false;
		}	
	}
	if(!function_exists('set_ap_query_1')){
		function set_ap_query_1(){
			global $ap_query;
			$ap_query = 1;
		}
	}	
	if(!function_exists('set_ap_query_2')){
		function set_ap_query_2(){
			global $ap_query;
			$ap_query = 2;
		}
	}	
	if(!function_exists('set_ap_query_3')){
		function set_ap_query_3(){
			global $ap_query;
			$ap_query = 3;
		}
	}	
	if(!function_exists('set_ap_query_4')){
		function set_ap_query_4(){
			global $ap_query;
			$ap_query = 4;
		}
	}	
	if(!function_exists('set_ap_query_5')){
		function set_ap_query_5(){
			global $ap_query;
			$ap_query = 5;
		}
	}	
	if(!function_exists('set_ap_query_6')){
		function set_ap_query_6(){
			global $ap_query;
			$ap_query = 6;
		}
	}						

	if(!function_exists('set_ap_query_n')){
		function set_ap_query_n($n){
			global $ap_query;
			$ap_query = $n;
		}
	}		
	
	if(!function_exists('ap_pagination')){
		function ap_pagination($query){


			
			if(!is_admin()){

				global $ap_customp, $ap_implementation;
				//pree($query->is_main_query());
				//pree($ap_customp.' | '.$ap_implementation);
				if($query->is_main_query() && $ap_implementation=='auto'){
					ap_where_filter();
				} 
			}
			

		}
		
	}
	
	if(!function_exists('ap_where')){
		function ap_where($where){

			//pree($where);
			$where = ap_where_clause($where);
			//pree($where);
			return $where;

		}

	}

	if(!function_exists('ap_where_filter')){
		function ap_where_filter(){
			
			global $wpdb;
			add_filter( 'posts_where' , 'ap_where' );	
			
			pre_render_alphabets();
		}
	}
	
	if(!function_exists('ready_alphabets')){
		function ready_alphabets(){
			global $rendered_alphabets_arr;
			//if(empty($rendered_alphabets_arr))
			$rendered_alphabets_arr[] = alphabets_bar();
		}
	}


	if(!function_exists('render_alphabets')){
		function render_alphabets($settings = array()){
	
		global $ap_implementation, $rendered, $rendered_alphabets_arr;
		
		if(empty($rendered_alphabets_arr)){
			ready_alphabets();
		}
		//return;
		//if(isset($_GET['debug']))
		//pre(ap_get_queries());
		//pree(alphabets_bar());
		$default_place = get_option('ap_dom')==''?'#content':get_option('ap_dom');
		
		
		//pree($default_place);exit;
		//$alphabets_bar = alphabets_bar();
		
		//pre($alphabets_bar);
		//pre($default_place);
		//pree($rendered_alphabets_arr);exit;
		if(!empty($rendered_alphabets_arr)){
			$alphabets_bar = implode('', $rendered_alphabets_arr);
		}
		//pree($alphabets_bar);exit;
		$script = '<script type="text/javascript" language="javascript">jQuery(document).ready(function($) {
			setTimeout(function(){	
				$("'.$default_place.'").prepend(\''.$alphabets_bar.'\');	
			
			}, 100);
		
		});';
		
		
		
		if(get_option('ap_layout')=='V'){		
			$script .= '		
				setTimeout(function(){		
					var p = jQuery("'.$default_place.'");		
					var position = p.position();		
					jQuery(".layout_V").css({left:position.left-26}); 
				}, 300);
			';
		}		
		$script .= '</script>';
		
		//echo $script;
		//pre($rendered);
		
		$style = '<style type="text/css">';
		$style = ap_sign_visibility($style);
		$style .= '</style>';
		
		//pree(ap_compability());exit;
	
		echo '<link href="'.plugins_url('css/mobile.css', dirname(__FILE__)).'" type="text/css" rel="stylesheet" />';
		
			if(!$rendered){
			
				if($ap_implementation==AP_CUSTOM){
			
					$rendered=TRUE;
			
					//echo $script;		
			
				}elseif(ap_go() || ap_compability()){
			
					$rendered=TRUE;
			
					echo $script.$style;
			
				}
			
			}										
	
		}

	}

		
	if(!function_exists('ap_sign_visibility')){
	function ap_sign_visibility($style=''){
			

		$ap_numeric_sign = (get_option('ap_numeric_sign')==0?false:true);
		
		if(!$ap_numeric_sign){
			$style .= 'ul.ap_pagination li.ap_numeric{ display:none; } ';
		}		
		
		$ap_reset_sign = (get_option('ap_reset_sign')==0?false:true);
		
		if(!$ap_reset_sign){
			$style .= 'ul.ap_pagination li.ap_reset{ display:none; } ';
		}		
					
		return $style;	
	}
	}

	if(!function_exists('ap_get_alphabets')){
		function ap_get_alphabets(){
		
			$alpha_array = range('a','z');
			
			return $alpha_array;
		
		}
	}
					
	if(!function_exists('ap_alphabets')){
		function ap_alphabets(){

			$languages_selected = get_option('ap_lang');
			
			if(empty($languages_selected))
			$languages_selected = array();
			
			require_once('languages.php');
			global $ap_langs, $ap_langin;
			$ap_langs = is_array($ap_langs)?$ap_langs:array();
			$alphabets = array();
			
			//pree($languages_selected);//exit;
			if(empty($languages_selected) || in_array('English', $languages_selected)){
			
				//LETS START WITH AN OLD STRING
				
				

				
				$alphabets['english'] = ap_get_alphabets();		
			
			}
			
			if(!empty($languages_selected)){
			
				foreach($languages_selected as $language_selected){
				
					$language_selected = strtolower($language_selected);
					
					if(in_array($language_selected, array_keys($ap_langs)) && !isset($alphabets[$language_selected])){
					
						$alphabets[$language_selected] = $ap_langs[$language_selected];
					
					}
				}
			}			
			if(defined('ICL_LANGUAGE_CODE') && array_key_exists(ICL_LANGUAGE_CODE, $ap_langin)){
				$lang_name = $ap_langin[ICL_LANGUAGE_CODE];		
				if($lang_name!=''){	
					
					switch($lang_name){
						case 'english':
							$alphabets['english'] = ap_get_alphabets();
						break;
						default:
							$alphabets[$lang_name] = $ap_langs[$lang_name];
						break;
					}
					
				
					
				}
			}

			if(is_admin()){
				$alphabets['english'] = ap_get_alphabets();		
				$alphabets = array_merge($ap_langs, $alphabets);
				//pree($alphabets);
			}
			//pre($alphabets);
			
			return $alphabets;

			

		}

	}
	
	if(!function_exists('pre_render_alphabets')){
		function pre_render_alphabets( $settings=array() ) {
			//render_alphabets($settings);
			add_action("wp_footer", 'render_alphabets', 100);
		}
	}




	function ap_plugin_links($links) { 
		global $ap_premium_link, $ap_customp;
		
		$settings_link = '<a href="options-general.php?page=alphabetc_pagination">'.__('Settings', 'alphabetic-pagination').'</a>';
		
		if($ap_customp){
			array_unshift($links, $settings_link); 
		}else{
			 
			$ap_premium_link = '<a href="'.$ap_premium_link.'" title="'.__('Go Premium', 'alphabetic-pagination').'" target=_blank>'.__('Go Premium', 'alphabetic-pagination').'</a>'; 
			array_unshift($links, $settings_link, $ap_premium_link); 
		
		}
		
		
		return $links; 
	}
	
	function register_ap_scripts() {
		
		
		
		wp_enqueue_script(
			'ap-scripts',
			plugins_url('js/scripts.js', dirname(__FILE__)),
			array('jquery')
		);	
		
		wp_register_style('ap-front', plugins_url('css/front-style.css', dirname(__FILE__)));
			wp_enqueue_style( 'ap-front' );
			
		if(!is_admin()){			
			//wp_enqueue_style('ap-mobile', plugins_url('css/mobile.css', dirname(__FILE__)), array(), date('Ymd'), 'all' );
		}
		
	
	}
	
		
	function ap_admin_style() {
		
		global $css_arr;
		
		
		wp_register_style('ap-admin', plugins_url('css/admin-style.css', dirname(__FILE__)));
		
		
		wp_enqueue_style( 'ap-admin' );
		
	}
			
	
	function ap_pro_admin_style() {
		
		global $css_arr;
		

		
		$css_arr[] = '#menu-settings li.current {
					border-left: 4px #25bcf0 solid;
					border-right: 4px #fc5151 solid;
					}
					#menu-settings li.current a{
						margin-left:-4px;
					}';
	}		
	
	function ap_get_queries(){
		global $wpdb;
		
		return $wpdb->queries;
	}
	
	if(!$ap_customp){
	
		if(!function_exists('ap_pagination_custom')){
			function ap_pagination_custom( $atts ) {
				global $ap_datap, $ap_premium_link;
				
				return $ap_datap['Name'].' '.__('shortcodes are available in', 'alphabetic-pagination').' <a href="'.$ap_premium_link.'" target="_blank">'.__('premium version', 'alphabetic-pagination').'</a>.';
			}
		}
		
		if(!function_exists('ap_pagination_results')){
			function ap_pagination_results( $atts ) {
				global $ap_datap, $ap_premium_link;
				
				return $ap_datap['Name'].' '.__('shortcodes are available in', 'alphabetic-pagination').' <a href="'.$ap_premium_link.'" target="_blank">'.__('premium version', 'alphabetic-pagination').'</a>.';
			}
		}		

	}
	