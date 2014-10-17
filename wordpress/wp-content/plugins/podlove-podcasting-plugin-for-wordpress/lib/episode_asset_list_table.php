<?php
namespace Podlove;

class Episode_Asset_List_Table extends \Podlove\List_Table {
	
	function __construct(){
		global $status, $page;
		        
		// Set parent defaults
		parent::__construct( array(
		    'singular'  => 'episode_asset',   // singular name of the listed records
		    'plural'    => 'episode_assets',  // plural name of the listed records
		    'ajax'      => false       // does this table support ajax?
		) );
	}
	
	public function column_title( $episode_asset ) {

		$link = function ( $title, $action = 'edit' ) use ( $episode_asset ) {
			return sprintf(
				'<a href="?page=%s&action=%s&episode_asset=%s">' . $title . '</a>',
				$_REQUEST['page'],
				$action,
				$episode_asset->id
			) . '<input type="hidden" class="position" value="' . $episode_asset->position . '">'
			  . '<input type="hidden" class="asset_id" value="' . $episode_asset->id . '">';
		};

		$actions = array(
			'edit'         => $link( __( 'Edit', 'podlove' ) ),
			'batch_enable' => $link( __( 'Activate for all existing Episodes', 'podlove' ), 'batch_enable' ),
			'delete'       => $link( __( 'Delete', 'podlove' ), 'delete' )
		);
	
		$title = ( $episode_asset->title ) ? $episode_asset->title : __( '- title missing -', 'podlove' );

		return sprintf( '%1$s %2$s',
		    $link( $title ),
		    $this->row_actions( $actions )
		);
	}
	
	public function column_file_type( $episode_asset ) {
		$format = $episode_asset->file_type();
		return ( $format ) ? $format->title() : "-";
	}

	public function column_downloadable( $episode_asset ) {
		return $episode_asset->downloadable ? '✓' : '×';
	}

	public function column_move( $episode_asset ) {
		return '<i class="reorder-handle podlove-icon-reorder"></i>';
	}

	public function get_columns(){
		return array(
			'title'     => __( 'Episode Asset', 'podlove' ),
			'file_type' => __( 'File Type', 'podlove' ),
			'downloadable' => __( 'Downloadable', 'podlove' ),
			'move' => '',
		);
	}
	
	public function prepare_items() {
		// number of items per page
		$per_page = 10;
		
		// define column headers
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		
		// retrieve data
		$data = \Podlove\Model\EpisodeAsset::all( 'ORDER BY position ASC' );

		// get current page
		$current_page = $this->get_pagenum();
		// get total items
		$total_items = count( $data );
		// extrage page for current page only
		$data = array_slice( $data, ( ( $current_page - 1 ) * $per_page ) , $per_page );
		// add items to table
		$this->items = $data;
		
		// register pagination options & calculations
		$this->set_pagination_args( array(
		    'total_items' => $total_items,
		    'per_page'    => $per_page,
		    'total_pages' => ceil( $total_items / $per_page )
		) );
	}

}
