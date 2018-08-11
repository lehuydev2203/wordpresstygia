<?php
/*
Plugin Name: Ty Gia & Gia Vang
Plugin URI: http://www.tygia.com/
Description: Widget Tỷ giá & Giá Vàng by www.tygia.com
Version: 1.3
Author: Quang Nguyen
Author URI: http://www.tygia.com/
License: GPLv2 or later
*/

function register_ty_gia_gia_vang_widget() {
    register_widget( 'Ty_Gia_Gia_Vang_Widget' );
}
add_action( 'widgets_init', 'register_ty_gia_gia_vang_widget' );

class Ty_Gia_Gia_Vang_Widget extends WP_Widget {

    public $maNT = array(
            'USD', 'JPY', 'EUR', 'GBP','AUD', 'CAD', 'CHF', 'DKK', 'HKD', 'INR', 'KRW', 'KWD', 'MYR', 'NOK', 'RUB', 'SAR', 'SEK', 'SGD','THB'
            ,'---',
            'BTC',
            'ETH',
            'XRP',
            'BCH',
            'LTC',
            'DASH',
            'XEM',
            'BCC',
            'NEO',
            'XMR',
            'MIOTA',
            'ETC',
            'QTUM',
            'ADA',
            'LSK',
            'ZEC',
            'XLM',
            'WAVES',
            'HSR',
            'STRAT',
            'ARK',
            'STEEM',
            'PIVX',
            'FRST',
            'KMD',
            'VTC',
            'MONA',
            'DCR',
            'FCT',
            'BTS',
            'GAME',
            'GBYTE',
            'REC',
            'ETP',
            'BLOCK',
            'BTCD',
            'LKK',
            'SYS',
            'GXS',
            'VEN',
            'NXS',
            'PURA',
            'BDL',
            'NXT',
            'ZEN',
            'PART',
            'SMART',
            'UBQ',
            'NEBL',
            'NAV',
            'NLC2',
            'ATB',
            'IOC',
            'XAS',
            'XZC',
            'FAIR',
            'NLG',
            'PPC',
            'CLOAK',
            'RISE',
            'CMP',
            'LEO',
            'AEON',
            'CRW',
            'RBY',
            'VIA',
            'BAY',
            'DCT',
            'XEL',
            'SKY',
            'XCP',
            'EMC',
            'ION',
            'DMD',
            'SIB',
            'NMC',
            'TCC',
            'ENRG',
            'UNO',
            'PPY',
            'EMC2',
            'MUE',
            'POT',
            'LBC',
            'XRB',
            'SLS',
            'OK',
            'GOLOS',
            'CSC',
            'GRC',
            'EXP',
            'BLK',
            'TX',
            'OMNI',
            'VRC',
            'FLO',
            'RADS',
            'ECN',
            'LMC'
    );
    public $banks=array(
            'EXIM'=>'Exim Bank',
            'HSBC'=>'HSBC',
            'VIETIN'=>'Vietin Bank',
            'TECHCOM'=>'Techcom Bank',
            'AGRI'=>'AgriBank',
            'ACB'=>'ACB',
            'BIDV'=>'BIDV',
            'VIETCOM'=>'Vietcom Bank',
            'Crypto'=>'Coin Market',
            'DAB'=>'NH Đông Á',
            'MBB'=>'NH Quân Đội',
            'STB'=>'Sacom Bank',
            'SCB'=>'Saigon Commercial Bank',
            'SEABANK'=>'SeABank',
            'SHB'=>'SHB Bank',
            'VPBANK'=>'VP Bank',
            'PVCOM'=>'PVcom Bank',
            'XD'=>'Petrolimex',
            'NHNN'=>'NHNN'
    );

    public function __construct() {
        parent::__construct(
                'ty_gia_gia_vang_widget', // Base ID
                'Tỷ giá & Giá Vàng', // Name
                array( 'description' =>'Tỷ giá & Giá Vàng by www.tygia.com') // Args
        );

    }

    public function widget( $args, $instance ) {
        $isos='';
        foreach ($this->maNT as $value) {
            if (1== $instance[$value] ){
                if($isos!='')
                    $isos =$isos.','.$value;
                else
                    $isos=$value;

            }
        }
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        //color
        $color=$instance['color'];
        if($color==null || (strlen($color)!=3 && strlen($color)!=6) || !preg_match('/^[a-f0-9]+$/i', $color)  ){
            $color= get_header_textcolor();
        }
        if(strlen($color)==3){
            $color=substr($color,0,1).substr($color,0,1)
                    .substr($color,1,1).substr($color,1,1)
                    .substr($color,2,1).substr($color,2,1);
        }else if(strlen($color)!=6){
            $color='333333';
        }

        $titleColor=$instance['titleColor'];
        if($titleColor==null || strlen($titleColor)!=6  || !preg_match('/^[a-f0-9]+$/i', $titleColor)  ){
            $titleColor= "fefefe";
        }

        $upColor=$instance['upColor'];
        if($upColor==null || strlen($upColor)!=6  || !preg_match('/^[a-f0-9]+$/i', $upColor)  ){
            $upColor= "00bb00";
        }

        $downColor=$instance['downColor'];
        if($downColor==null || strlen($downColor)!=6  || !preg_match('/^[a-f0-9]+$/i', $downColor)  ){
            $downColor= "bb0000";
        }

        $textColor=$instance['textColor'];
        if($textColor==null || strlen($textColor)!=6  || !preg_match('/^[a-f0-9]+$/i', $textColor)  ){
            $textColor= "333333";
        }

        $bgColor=$instance['bgColor'];
        if($bgColor==null || strlen($bgColor)!=6  || !preg_match('/^[a-f0-9]+$/i', $bgColor)  ){
            $bgColor= "";
        }
        $css=$instance['css'];
        if($css==null)$css='';
        $css=str_replace('#','%23',str_replace('\r','',str_replace('\n','',$css)));

        $new_args="auto=".$instance['auto']."&change=".$instance['change']."&flag=".$instance['flagr']."&column=".($instance['column2']=='1'?'2':'3')."&titlecolor=".$titleColor."&upcolor=".$upColor."&downcolor=".$downColor."&textcolor=".$textColor."&gbcolor=".$bgColor."&css=".htmlspecialchars($css, ENT_QUOTES);;
        //size
        $fontsize=$instance['font_size'];
        if($fontsize==null || strlen($fontsize)<2 || strlen($fontsize)>3 || !preg_match('/^[0-9]+$/i', $fontsize)  ){
            if( strpos('Twenty',get_current_theme())==0)
                $fontsize=60;
            else
                $fontsize=80;
        }
        $language=$instance['language'];
        echo "<iframe style='padding:0;border:none;overflow: hidden;' width=".$instance['width']." height=".$instance['height']." src='//www.tygia.com/api2.php?$new_args&title=0&chart=".$instance['chart']."&gold=".$instance['gold']."&rate=".$instance['rate']."&ngoaite=$isos&expand=".$instance['expand']."&color=".$color."&nganhang=".$instance['bank']."&fontsize=".$fontsize."&ngay".($language==null?'':'&locale='.$language)."' ></iframe>";
        echo $args['after_widget'];
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['bank'] = strip_tags($new_instance['bank']);
        $instance['color'] = strip_tags($new_instance['color']);
        $instance['font_size'] = strip_tags($new_instance['font_size']);
        $instance['rate'] = !empty($new_instance['rate']) ? 1 : 0;
        $instance['gold'] =  !empty($new_instance['gold']) ? 1 : 0;
        $instance['chart'] =  !empty($new_instance['chart']) ? 1 : 0;
        $instance['width'] = strip_tags($new_instance['width']);
        $instance['height'] = strip_tags($new_instance['height']);
        $instance['expand'] =!empty($new_instance['expand']) ? 1 : 0;

        $instance['auto'] =  !empty($new_instance['auto']) ? 1 : 0;//false
        $instance['change'] = !empty($new_instance['change']) ? 1 : 0;//false
        $instance['flagr'] =  !empty($new_instance['flagr']) ? 1 : 0;//false
        $instance['column2'] = !empty($new_instance['column2']) ? 1 : 0;//false
        $instance['titleColor'] = strip_tags($new_instance['titleColor']);//ffffff
        $instance['upColor'] = strip_tags($new_instance['upColor']);//00ee00
        $instance['downColor'] = strip_tags($new_instance['downColor']);//ee0000
        $instance['textColor'] = strip_tags($new_instance['textColor']);//444444
        $instance['bgColor'] = strip_tags($new_instance['bgColor']);//null
        $instance['css'] = strip_tags($new_instance['css']);
        $instance['language'] = strip_tags($new_instance['language']);
        foreach ($this->maNT as $value) {
            $instance[$value] = !empty($new_instance[$value]) ? 1 : 0;
        }

        return $instance;
    }

    public function form( $instance ) {



        $instance = wp_parse_args( (array) $instance, array( 'USD' => 1,'JPY'=>1,'EUR'=>1,'GBP'=>1 ,'AUD'=>1,'bank'=>'','rate'=>1,'gold'=>1,'chart'=>0,'width'=>'100%','height'=>'300','expand'=>0,'font_size'=>'80','language'=>'vn') );

        $title = ! empty( $instance['title'] ) ? $instance['title'] : 'Tỷ giá & Giá Vàng';
        $color = $instance['color'] ;
        $tcolor = $instance['titleColor'] ;
        $ucolor = $instance['upColor'] ;
        $dcolor = $instance['downColor'] ;
        $txtcolor = $instance['textColor'] ;
        $bgcolor = $instance['bgColor'] ;
        $css = $instance['css'] ;
        $language=$instance['language'] ;
        $font_size = (int)$instance['font_size'] ;

        if($font_size==null || $font_size<70 || $font_size>150)$font_size=80;
        foreach ($this->maNT as $value) {
            $$value = isset($instance[$value]) ? (bool) $instance[$value] :false;
        } ?>

        <div  style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

        </div>

        <div  style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label style='width:50%' for="<?php echo $this->get_field_id( 'bank' ); ?>">Ngân hàng</label>
            <label  style='width:45%;float: right;' for="<?php echo $this->get_field_id( 'language' ); ?>">Ngôn ngữ</label>
            <div class='clear:both'></div>
            <select style='width:50%' name="<?php echo $this->get_field_name( 'bank' ); ?>" id="<?php echo $this->get_field_id( 'bank' ); ?>">
                <option  value=''>[Mới nhất]</option>
                <?php foreach ($this->banks as $key=>$value) {
                    echo "<option ".selected( $instance['bank'], $key )." value='$key'>$value </option>";
                } ?>
            </select>
            <select style='width:45%' name="<?php echo $this->get_field_name( 'language' ); ?>" id="<?php echo $this->get_field_id( 'language' ); ?>">

                <?php
                echo "<option ".selected( $instance['language'], 'vn' )." value='vn'>Tiếng Việt </option>";
                echo "<option ".selected( $instance['language'], 'en-us' )." value='en-us'>Tiếng Anh </option>";
                ?>
            </select>
        </div>




        <div  style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <div style="width: 50%; float: left;">
                <input id="<?php echo $this->get_field_id( 'gold' ); ?>" name="<?php echo $this->get_field_name( 'gold' ); ?>" <?php checked( $instance['gold'] ); ?> class="checkbox" type="checkbox"> <label
                        for="<?php echo $this->get_field_id( 'gold' ); ?>">Giá vàng</label>
            </div>
            <div style="width: 50%; float: left;">

                <input id="<?php echo $this->get_field_id( 'chart' ); ?>" name="<?php echo $this->get_field_name( 'chart' ); ?>" <?php checked( $instance['chart'] ); ?> class="checkbox" type="checkbox"> <label
                        for="<?php echo $this->get_field_id( 'chart' ); ?>" >Biểu đồ</label>
            </div>
        </div>
        <div  style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <div style="width: 50%;float: left;">
                <input id="<?php echo $this->get_field_id( 'rate' ); ?>" name="<?php echo $this->get_field_name( 'rate' ); ?>" <?php checked( $instance['rate'] ); ?> class="checkbox" type="checkbox">
                <label for="<?php echo $this->get_field_id( 'rate' ); ?>" title='Hiển thị tỷ giá'>Tỷ giá</label>
            </div>
            <div style="width: 50%;float: left;">
                <input id="<?php echo $this->get_field_id( 'column2' ); ?>" name="<?php echo $this->get_field_name( 'column2' ); ?>" <?php checked( $instance['column2'] ); ?> class="checkbox" type="checkbox">
                <label for="<?php echo $this->get_field_id( 'column2' ); ?>" title='Chỉ hiển thị hai cột mua và bán'>Hiện 2 Cột</label>
            </div>
        </div>

        <div  style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <div style="width: 50%; float: left;">
                <input id="<?php echo $this->get_field_id( 'change' ); ?>" name="<?php echo $this->get_field_name( 'change' ); ?>" <?php checked( $instance['change'] ); ?> class="checkbox" type="checkbox"> <label
                        for="<?php echo $this->get_field_id( 'change' ); ?>" title='Hiển thị giá trị tăng giảm so với ngày trước (tỷ giá phải chọn kiểu 2 cột)'>Hiển thị thay đổi</label>

            </div>
            <div style="width: 50%; float: left;">

                <input id="<?php echo $this->get_field_id( 'flagr' ); ?>" name="<?php echo $this->get_field_name( 'flagr' ); ?>" <?php checked( $instance['flagr'] ); ?> class="checkbox" type="checkbox"> <label
                        for="<?php echo $this->get_field_id( 'flagr' ); ?>" title="Cờ quốc gia theo ngoại tệ">Cờ theo tỷ giá</label>

            </div>
        </div>


        <div  style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <div style="width: 50%; float: left;">
                <input  id="<?php echo $this->get_field_id( 'expand' ); ?>" name="<?php echo $this->get_field_name( 'expand' ); ?>" <?php checked( $instance['expand'] ); ?> class="checkbox" type="checkbox"> <label
                        for="<?php echo $this->get_field_id( 'expand' ); ?>" title="Hiển thị tất cả tỷ giá và giá vàng">Hiển thị tất cả</label>
            </div>
            <div style="width: 50%; float: left;  ">
                <div title="Chỉ hiển thị thu gọn theo ngoại tệ được chọn" style="padding: 0 0 5px 0;display: inline-block;  ">Hiển thị thu gọn</div>
                <div style='max-height: 100px; overflow-y: scroll;border:solid 1px #aaa; '>
                    <?php foreach ($this->maNT as $value) { ?>
                        <input id="<?php echo $this->get_field_id( $value ); ?>" name="<?php echo $this->get_field_name( $value ); ?>" <?php checked( $$value ); ?> class="checkbox" type="checkbox"> <label
                                for="<?php echo $this->get_field_id( $value ); ?>"><?php echo $value; ?></label> <br>
                    <?php } ?>
                </div>
            </div>
        </div>





        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <div style="width: 50%; float: left;">
                <label title="Chiều rộng widget " for="<?php echo $this->get_field_id( 'width' ); ?>">Width</label> <input style="width: 70px" id="<?php echo $this->get_field_id( 'width' ); ?>"
                                                                                                                           name="<?php echo $this->get_field_name( 'width' ); ?>" value='<?php echo esc_attr( $instance['width']); ?>' class="checkbox" type="text">

            </div>
            <div style="width: 50%; float: left;">
                <label title='Chiều cao widget' for="<?php echo $this->get_field_id( 'height' ); ?>">Height</label> <input placeholder="270" style="width: 70px" id="<?php echo $this->get_field_id( 'height' ); ?>"
                                                                                                                           name="<?php echo $this->get_field_name( 'height' ); ?>" value='<?php echo esc_attr( $instance['height']); ?>' class="checkbox" type="text">
            </div>
        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">

            <input id="<?php echo $this->get_field_id( 'auto' ); ?>" name="<?php echo $this->get_field_name( 'auto' ); ?>" <?php checked( $instance['auto'] ); ?> class="checkbox" type="checkbox"> <label
                    for="<?php echo $this->get_field_id( 'auto' ); ?>" >Tự động cập nhật mỗi 30 giây</label>
        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'font_size' ); ?>">Font size(%)</label>

            <select name="<?php echo $this->get_field_name( 'font_size' ); ?>" id="<?php echo $this->get_field_id( 'font_size' ); ?>">
                <option  ></option>"
                <?php for ($vv=130;$vv>=70;$vv-=2) {
                    echo "<option ".($font_size==$vv?'selected':'' )." value='$vv'>$vv % </option>";
                } ?>
            </select>

        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'color' ); ?>">Màu nền Title #</label>
            <input style="float: right;"  placeholder="1d4c75" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" value='<?php echo esc_attr( $color ); ?>' class="checkbox" type="text">
        </div>

        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'titleColor' ); ?>">Màu chữ Title #</label>
            <input style="float: right;"  placeholder="fefefe" id="<?php echo $this->get_field_id( 'titleColor' ); ?>" name="<?php echo $this->get_field_name( 'titleColor' ); ?>" value='<?php echo esc_attr( $tcolor ); ?>' class="checkbox" type="text">
        </div>
        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'upColor' ); ?>">Màu tăng #</label>
            <input style="float: right;"  placeholder="00bb00" id="<?php echo $this->get_field_id( 'upColor' ); ?>" name="<?php echo $this->get_field_name( 'upColor' ); ?>" value='<?php echo esc_attr( $ucolor ); ?>' class="checkbox" type="text">
        </div>
        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'downColor' ); ?>">Màu giảm #</label>
            <input style="float: right;"  placeholder="bb0000" id="<?php echo $this->get_field_id( 'downColor' ); ?>" name="<?php echo $this->get_field_name( 'downColor' ); ?>" value='<?php echo esc_attr( $dcolor ); ?>' class="checkbox" type="text">
        </div>
        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'textColor' ); ?>">Màu chữ #</label>
            <input style="float: right;"  placeholder="333333" id="<?php echo $this->get_field_id( 'textColor' ); ?>" name="<?php echo $this->get_field_name( 'textColor' ); ?>" value='<?php echo esc_attr( $txtcolor ); ?>' class="checkbox" type="text">
        </div>
        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <label for="<?php echo $this->get_field_id( 'bgColor' ); ?>">Màu nền #</label>
            <input style="float: right;" placeholder="" id="<?php echo $this->get_field_id( 'bgColor' ); ?>" name="<?php echo $this->get_field_name( 'bgColor' ); ?>" value='<?php echo esc_attr( $bgcolor ); ?>' class="checkbox" type="text">
        </div>
        <div style="padding: 5px 0 5px 0;   display: inline-block; width: 100%">
            <div title="vd:hien thi gia vang DN:#SJC_N_ng{display: table-row !important;}">Customize css:</div>
            <textarea  placeholder="#SJC_N_ng{display: table-row !important;}" style="width: 100%;" rows="3" placeholder="" id="<?php echo $this->get_field_id( 'css' ); ?>" name="<?php echo $this->get_field_name( 'css' ); ?>"  class="textarea" ><?php echo esc_attr( $css ); ?></textarea>
        </div>


        <?php
    }
}
