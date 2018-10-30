<?php
/**
* Plugin Name: Lokalizacje
* Plugin URI: http://asander.pl
* Description: Pokazuje lokalizacje
* Version: 1.0
* Author: Alek
* Author URI: http://asander.pl
*/

/*Register post type and tax*/
include(plugin_dir_path( __FILE__ ).'inc/typ_postu.php');
include(plugin_dir_path( __FILE__ ).'inc/ajax.php');


function giveMeLokalizajce() { 

  $key = ''; //put your map key here

  ?>

	<div id="gdzie_kupic" home-url="<?=get_home_url()?>">
        <div class="row">
          <div class="col-md-6 col-lg-5">
              <div class="szukajka">
                <h2>Województwo</h2>
                <div class="selec_woj woj">Wybierz województwo</div>
                <ul class="wojewodztwa">
                    <?php 
                    $terms = get_terms( array(
                        'taxonomy' => 'wojewodztwa',
                        'parent' => 0,
                        'hide_empty' => true,
                        ) );

                    $i=0;
                    foreach ( $terms as $term ) : ?>
                    <li data-id="<?=$term->slug?>"><?=$term->name?></li>
                    <?php 
                        $i++;
                        endforeach;
                    ?>

                    <li data-id="cala">wszystkie</li>
                </ul>

                <h2>Miasto</h2>
                <div class="selec_woj mias">Wybierz miasto</div>
                <ul class="miasta">
                  
                </ul>
              </div>
              <h1 class="line">Wyniki wyszukiwania</h1>
              <div class="lista_sklepow small_text">
                  <div class="row">
                  </div>
              </div>
          </div>
          <div class="col-md-6 col-lg-7">
            <div class="floater">
              <div id="map"><!-- <img src="<?=get_stylesheet_directory_uri()?>/img/mapa_points.png"> --></div>
          </div>
          </div>
        </div>
        </div>
        



   <script src="https://maps.googleapis.com/maps/api/js?key=<?=$key?>"></script>


<?php 

wp_enqueue_style( 'lokalizacje', plugin_dir_url( __FILE__ ) . '/assets/lok.css', array(), 'all' );
wp_enqueue_script( 'lok.js', plugin_dir_url( __FILE__ ) . '/assets/lok_front.js', array('jquery'), '', true );

}


add_shortcode( 'lokalizacje' , 'giveMeLokalizajce' );

function lokjs_admin() {

	wp_enqueue_script( 'lok.js', plugin_dir_url( __FILE__ ) . '/assets/lok_back.js', array('jquery'), '', true );
}
add_action( 'admin_enqueue_scripts', 'lokjs_admin' );