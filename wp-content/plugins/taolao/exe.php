<?php
/**
 * Created by PhpStorm.
 * User: nhoxk
 * Date: 8/13/2018
 * Time: 12:38 PM
 */?>

<div id='response'></div>

        <script>
        function loadpage(){
            var xmlhttp= new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if(this.readyState == 4 && this.status == 200) {
                    document.getElementById('response').innerHTML=this.responseText;
                    //loadpage();
                }
            }
        xmlhttp.open('GET',"wp-content/plugins/taolao/getExchangesVietcom.php", true);
        xmlhttp.send();
        setTimeout("loadpage()",30000);
        }
        window.load=loadpage()
            </script>
