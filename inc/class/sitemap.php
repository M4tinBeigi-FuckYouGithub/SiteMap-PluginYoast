<?php
require_once str_replace('\\','/',dirname(dirname(__FILE__))).'/' . 'config.php';

class sm
{
    public static function timeMB($time){

        return date('c',$time);

    }
    public static function htmlMB($value){

        return htmlspecialchars($value);

    }
    public static function linkMB($value){


        $value =  preg_replace("#/#",'-', $value);
        $value = str_replace(' ','-',"$value");
        $value = str_replace('--','-',"$value");
        $value = str_replace('---','-',"$value");
        $value = str_replace('----','-',"$value");
        $value = str_replace('-----','-',"$value");
        $value = str_replace('------','-',"$value");
        $value = str_replace('-------','-',"$value");
        $value = str_replace('--------','-',"$value");
        $value = str_replace('---------','-',"$value");
        $value = trim($value, '-');

        $value = sm::htmlMB($value);

        $value = urlencode($value);
        return $value;

    }
    public static function urlproductMB($lang,$id,$link){

        return url.$lang.'product-'.html_entity_decode($id).'/' . sm::linkMB($link) .'/';

    }
    public static function urlproduct2MB($lang,$i){

        return url.$lang.'sitemap/product-sitemap-'.$i.'.xml';

    }




}