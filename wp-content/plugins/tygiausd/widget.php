<?php

/**
Plugin Name: Widget tỷ giá $
Description: Thực hành tạo widget item.
Author: Lê Huy
Version: 1.0
Author URI: https://examhtmlcss.000webhostapp.com/contact
*/

function tygiausd(){
    register_widget('Lehuy_widget');
}
add_action('widgets_init','tygiausd');
/**
 * Tạo class Lehuy_widget
 */
class Lehuy_widget extends WP_Widget {
 
    /**
     * Thiết lập widget: đặt tên, base ID
     */
    public function __construct() {
            parent::__construct(
                'ty_giawidget', // Base ID
                'Tỷ giá ', // Name
                array( 'description' =>'Tỷ giá $') // Args
            );
    }

    /**
     * Tạo form option cho widget
     */
    public function form( $instance ) {
    parent::form( $instance );

    //Biến tạo các giá trị mặc định trong form
    $default = array(
            'title' => 'Tiêu đề widget'
    );

    //Gộp các giá trị trong mảng $default vào biến $instance để nó trở thành các giá trị mặc định
    $instance = wp_parse_args( (array) $instance, $default);

    //Tạo biến riêng cho giá trị mặc định trong mảng $default
    $title = esc_attr( $instance['title'] );

    //Hiển thị form trong option của widget
    echo "Nhập tiêu đề <input class='widefat' type='text' name='".$this->get_field_name('title')."' value='".$title."' />";

    }
    /**
     * save widget form
     */
    public function update( $new_instance, $old_instance ) {
        parent::update( $new_instance, $old_instance );
 
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /**
     * Show widget
     */
    public function widget( $args, $instance )
    {

        echo $args['before_widget'];
        echo"
        <div onload='loadpage()'>
        <div id='response'></div>

        <script>
        function loadpage(){
        var xmlhttp= new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if(this.readyState == 4 && this.status == 200) {
                document.getElementById('response').innerHTML=this.responseText;
            }
        }
        xmlhttp.open('GET', 'wp-content/plugins/tygiausd/getExchangesVietcom.php', true);
        xmlhttp.send();
        setTimeout('loadpage()',500);
    }
    loadpage();

        </script>
        </div>
        ";
        echo $args['after_widget'];

    }
}
