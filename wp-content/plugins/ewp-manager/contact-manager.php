<?php
//Our class extends the WP_List_Table class, so we need to make sure that it's there
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Link_List_Table extends WP_List_Table {

	/**
	 * Constructor, we override the parent to pass our own arguments
	 * We usually focus on three parameters: singular and plural labels, as well as whether the class supports AJAX.
	 */
	 function __construct() {
		 parent::__construct( array(
    		'singular'=> 'wp_list_text_link', //Singular label
    		'plural' => 'wp_list_test_links', //plural label, also this well be one of the table css class
    		'ajax'	=> false //We won't support Ajax for this table
		) );
	 }
     
    /**
     * Add extra markup in the toolbars before or after the list
     * @param string $which, helps you decide if you add the markup after (bottom) or before (top) the list
     */
    function extra_tablenav( $which ) {
    	if ( $which == "top" ){
    		//The code that goes before the table is here
//    		echo"Hello, I'm before the table";
    	}
    	if ( $which == "bottom" ){
    		//The code that goes after the table is there
//    		echo"Hi, I'm after the table";
    	}
    }
    
    /**
     * Define the columns that are going to be used in the table
     * @return array $columns, the array of columns to use with the table
     */
    function get_columns() {
    	return $columns= array(
            'cb' => '<input type="checkbox">',
    		'col_name'=>__('Tên'),
    		'col_email'=> 'Email',
    	);
    }
    
    
    /**
     * Decide which columns to activate the sorting functionality on
     * @return array $sortable, the array of columns that can be sorted by the user
     */
    public function get_sortable_columns() {
    	return $sortable = array(
//            'col_status'=> array('status', false),
    		'col_name'=> array('name', false),
            'col_email'=> array('email', false)
    	);
    }
    /**
     * Prepare the table with different parameters, pagination, columns and table elements
     */
    function prepare_items() {
    	global $wpdb, $_wp_column_headers;
        $table_name = $wpdb->prefix . "ewp_contact";
    	$screen = get_current_screen();

	   /* -- Preparing your query -- */
        $query = "SELECT * FROM $table_name";

	   /* -- Ordering parameters -- */
	    //Parameters that are going to be used to order the result
	    $orderby = !empty($_GET["orderby"]) ? mysql_real_escape_string($_GET["orderby"]) : 'ASC';
	    $order = !empty($_GET["order"]) ? mysql_real_escape_string($_GET["order"]) : '';
        
	    if(!empty($orderby) & !empty($order)){ $query.=' ORDER BY '.$orderby.' '.$order; }
        //if(empty($order)){ $query.= ' ORDER BY booking_date DESC';}
        
	   /* -- Pagination parameters -- */
        //Number of elements in your table?
        $totalitems = $wpdb->query($query); //return the total number of affected rows
        //How many to display per page?
        $perpage = 20;
        //Which page is this?
        $paged = !empty($_GET["paged"]) ? mysql_real_escape_string($_GET["paged"]) : '';
        //Page Number
        if(empty($paged) || !is_numeric($paged) || $paged<=0 ){ $paged=1; }
        //How many pages do we have in total?
        $totalpages = ceil($totalitems/$perpage);
        //adjust the query to take pagination into account
	    if(!empty($paged) && !empty($perpage)){
		    $offset=($paged-1)*$perpage;
    		$query.=' LIMIT '.(int)$offset.','.(int)$perpage;
	    }

	   /* -- Register the pagination -- */
		$this->set_pagination_args( array(
			"total_items" => $totalitems,
			"total_pages" => $totalpages,
			"per_page" => $perpage,
		) );
		//The pagination links are automatically built according to those parameters

	   /* -- Register the Columns -- */
		$columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
		$_wp_column_headers[$screen->id]=$columns;
        
        //important
        $this->_column_headers = array($columns, array(), $sortable);
        
	   /* -- Fetch the items -- */
       $this->items = $wpdb->get_results($query);
    }
    
    function get_column_headers(){
        return $this->get_columns();
        
    }
    
    function get_bulk_actions() {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    
      
    /**
     * Display the rows of records in the table
     * @return string, echo the markup of the rows
     */
    function display_rows() {
    
    	//Get the records registered in the prepare_items method
    	$records = $this->items;

    	//Get the columns registered in the get_columns and get_sortable_columns methods

    	list( $columns, $hidden ) = $this->get_column_info();
        
    	//Loop for each record
    	if(!empty($records)){foreach($records as $rec){
    
    		//Open the line
            echo '<tr id="record_'.$rec->id.'">';
            //$columns = $this->get_columns();
            echo '<th class="check-column" scope="row"><input type="checkbox" name="contact[]" value="' . $rec->id . '" /></th>';
            
    		foreach ( $columns as $column_name => $column_display_name ) {
    
    			//Style attributes for each col
    			$class = "class='$column_name column-$column_name'";
    			$style = "";
    			if ( in_array( $column_name, $hidden ) ) $style = ' style="display:none;"';
    			$attributes = $class . $style;
    
    			//edit link
    			$editlink  = '/wp-admin/link.php?action=edit&id='.(int)$rec->id;
    
    			//Display the cell
    			switch ( $column_name ) {
//                    case "col_status": echo '<td '.$attributes.'>'.stripslashes($rec->status).'</td>'; break;
                    case "col_name": echo '<td '.$attributes.'>'.stripslashes($rec->name).'</td>'; break;
                    case "col_email": echo '<td '.$attributes.'>'.stripslashes($rec->email).'</td>'; break;
    			}
    		}
    		//Close the line
    		echo'</tr>';
    	}}
    }
    
    /**
     * delete contact
     */
    function deleteItems(){
        global $wpdb;
        $table_name = $wpdb->prefix . "ewp_contact";
        
        if(isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['contact']) && count($_POST['contact'])){
            $query = "DELETE FROM $table_name WHERE id in (" . implode(',', $_POST['contact']) . ")";
            $wpdb->query($query);
        }
        
    }
}

?>
<div class="wrap">
    <div id="icon-users" class="icon32"></div>
    <h2>Quản lý khách hàng</h2>
    <form method="POST">
        <?php 
            //Prepare Table of elements
            $wp_list_table = new Link_List_Table();
            $wp_list_table->deleteItems();
            $wp_list_table->prepare_items();
            $wp_list_table->display();    
        ?>
    </form>
</div>