<?php
function show_most_used_words() {
	$ci = & get_instance();
	$prominent_words = $content_array = $count_words = $arr = array();
	// Words which we are removing from output
	$ignore_words = array("a","an","with","also","only","all","I","he","his","him","she","her","you","your","they","them","their","the","this","that","these","those","till","after","although","as","because","before","how","if","once","since","than","that","though","unless","until","when","whenever","where","wherever","whether","while","for","and","not","neither","nor","but","either","or","yet","so","both","then","there","from","to","is","was","be","can","could","would', 'should","give","has","had","have","are","some","it","in","of","on","at","an","who","what","why","we","been","may","maybe","using","further","by","isn't","isn’t","wasn’t","wasn't","something","top","out","will","be","being","told","said","too");

	//$pattern_page = array("+",",",".","-","'","\"","&","!","?",":",";","#","~","=","/","$","£","^","(",")","_","<",">");
 
	$source_content = $ci->input->post( 'full_desc' );
	//$source_content = str_replace( $pattern_page, ' ', strip_tags( $source_content ) );
	
	$content_array = explode( " ", strip_tags( $source_content ) );


	foreach( $content_array as $str ) {
		if( ! in_array( strtolower($str), array_map('strtolower', $ignore_words ) ) )
			$content[] = $str;
	}

	$count_words = array_count_values( $content );
	
	// Sort array elements in ascending order on behalf of maximum used words
	arsort( $count_words );

	// Get prominent 20 words from source content
	$prominent_words = array_slice( $count_words, 0, 20, true );

	// Add font-size for tag cloud font impression and number of occurrance with words
	$size = 20;
	if( ! empty( $prominent_words) ) {
		foreach( $prominent_words as $words => $count ) {
			$words_array[] = array( 'tag' => $words, 'count' => $count, 'font_size' => $size );
			$size -= 0.6;
		}
	}

	// Shuffled Array
	$shuffle_array = $ci->shuffle_assoc( $words_array );

	$ci->show_admin_tags( $shuffle_array );
}

// Shuffle associative array
function shuffle_assoc( Array $arr ) { 
	if ( ! is_array( $arr ) )
		return $arr;

	$keys = array_keys( $arr ); 
	shuffle( $keys ); 
	$random = array(); 
	foreach ( $keys as $key ) { 
		$random[$key] = $arr[$key]; 
	}

	return $random; 
}

// Show word cloud at back end
function show_admin_tags( Array $arr ) {
	if( ! empty( $arr ) ) :
		echo "<ul class='word_cloud'>";
		foreach( $arr as $words ) :
			$tag = trim($words['tag']);
			if( $tag != "" ) {
				echo "<li><label><input type='checkbox' name='add_tags[]' id='".$tag."' class='addtags ace' value='".$tag."' onclick='get_tag(\"".$tag."\");' /><span class='lbl' style='font-size:".$words['font_size']."px;'><span class='hash-tag'>#</span> ".$tag.' ('.$words['count'].")</span></label></li>";
			}
			else {
				echo '<li>No Suggestion</li>';
			}
		endforeach;
		echo "</ul>";
	endif;
}

// Show word cloud at front end
function show_front_word_cloud( Array $arr ) {
	if( ! empty( $arr ) ) :
		echo "<ul class='word_cloud'>";
		foreach( $arr as $words ) :
			echo "<li><a href='".base_url()."tag/".$words['tag']."'><span style='font-size:".$words['font_size']."px;'><span class='hash-tag'>#</span> ".$words['tag']."</span></a></li>";
		endforeach;
		echo "</ul>";
	endif;
}