<?php
/**
Plugin Name: Widget tỷ giá $
Description: Thực hành tạo widget item.
Author: Lê Huy
Version: 1.0
Author URI: https://examhtmlcss.000webhostapp.com/contact
 */

function tygia_register_widget() {

register_widget( 'tygia_usd_widget' );

}
add_action( 'widgets_init', 'tygia_register_widget' );
class tygia_usd_widget extends WP_Widget {
function __construct() {

parent::__construct(

// widget ID

'tygia_usd_widget',

// widget name

__('Ty Gia USD', ' hstngr_widget_domain'),

// widget description

array( 'description' => __( 'Ty Gia USD', 'hstngr_widget_domain' ), )

);

}

public function widget( $args, $instance ) {

$title = apply_filters( 'widget_title', $instance['title'] );

echo $args['before_widget'];

//if title is present

if ( ! empty( $title ) )

echo $args['before_title'] . $title . $args['after_title'];

//output

    ?>
        <div onload="loadpage()">
        <div id='response'></div>

        <script>
        function loadpage(){
        var xmlhttp= new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if(this.readyState == 4 && this.status == 200) {
                document.getElementById('response').innerHTML=this.responseText;
            }
        }
        xmlhttp.open('GET', 'wp-content/plugins/taolao/getExchangesVietcom.php', true);
        xmlhttp.send();
        //setTimeout(loadpage(),10000);
        }
        //loadpage();
        </script>
        </div>
        <a onclick="loadpage()" class="btn  btn-info btn-outline-info " id="idcolor"> Cập Nhập </a>
        <?


echo $args['after_widget'];

}

public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) )

$title = $instance[ 'title' ];

else

$title = __( 'Default Title', 'hstngr_widget_domain' );

?>

<p>

<!--label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>

<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /-->

</p>

<?php

}

public function update( $new_instance, $old_instance ) {

$instance = array();

$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

return $instance;

}

}