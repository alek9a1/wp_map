<?php
function getMiasta(){

				header('Content-Type: application/json');

				$search = array();
				$lista = array();
				$all = array();

				$woj = $_POST['woj'];
				if ($woj == 'cala') {

					$argsi = array(
                                'post_type' => 'lokalizacja', 
                                'posts_per_page' => -1
                            );
							

				} else {
					$argsi = array(
                                'post_type' => 'lokalizacja', 
                                'tax_query' => array(
                                    array (
                                        'taxonomy' => 'wojewodztwa',
                                        'field' => 'slug',
                                        'terms' => $woj,
                                    )
                                ),
                                'posts_per_page' => -1);
				}
				
                               
					$querys = new WP_Query($argsi);
					while($querys -> have_posts()) : $querys -> the_post();

					$post_id = get_the_ID();
					$tit = get_the_title();
					$obraz = get_the_post_thumbnail_url( $post_id, 'full' ); 
					$url = get_permalink();
					$miasto = get_post_meta(get_the_ID(), 'wpcf-miejscowosc', true);
					$ulica = get_post_meta(get_the_ID(), 'wpcf-ulica', true);
					$telefon = get_post_meta(get_the_ID(), 'wpcf-telefon', true);
					$email = get_post_meta(get_the_ID(), 'wpcf-emial', true);
					$pozycja = get_post_meta(get_the_ID(), 'wpcf-pozycja', true);
					$kod = get_post_meta(get_the_ID(), 'wpcf-kod', true);
					$poczta = get_post_meta(get_the_ID(), 'wpcf-poczta-miejscowosc', true);
					if (empty($poczta)) {
						$poczta = $miasto;
					}

					$dane = [$tit,$miasto,$ulica,$telefon,$email,$kod,$poczta,$pozycja];

					array_push($search, $miasto);
					array_push($lista, $dane);

				endwhile;
				$search = array_unique($search);
				sort($search);
				$new_array = array_values($search);

				array_push($all, $new_array, $lista);
				echo json_encode($all);

			die();
}


add_action('wp_ajax_getMiasta', 'getMiasta');
add_action('wp_ajax_nopriv_getMiasta', 'getMiasta'); // not really needed