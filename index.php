<?php
require_once('inc/class/db.php');
require_once('inc/class/sitemap.php');
header("Content-type: text/xsl");
if (isset($_GET['lng']) && !empty($_GET['lng'])) {

    $checkLang = array("fa", "en", "ru");
    if (in_array(($_GET['lng']), $checkLang)) {
        $lng = $_GET['lng'];
        $lang =$lng.'/';
        $lng ='_'.$lng;
        $laang=$_GET['lng'];

    } else {
        $lng = "";
        $lang='fa/';
    }
} else {
    $lng = "";
    $lang='fa/';
}
if($lng=='_fa'){
    $lng = "";
    $lang='fa/';
    $laang='fa';
}




if(isset($_GET['type']) && !empty($_GET['type'])){
$type = $_GET['type'];
    echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.urlsitemap.'main-sitemap.xsl"?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'?>
<?php

switch ($type) {
    case "post"; //*********** Post SiteMap MB ************//?>
        <url>
            <loc><?= url.sm::htmlMB('/')?></loc>
            <lastmod><?= sm::timeMB(time()) ?></lastmod>
            <image:image>
                <image:loc><?= url.sm::htmlMB('/')?></image:loc>
                <image:title><![CDATA[<?= str_replace(' ','-',"$title");?>]]></image:title>
            </image:image>
        </url>
        <?php
        break;
    case "page";
        break;
    case "product";
        if(isset($_GET['n']) && !empty($_GET['n'])){
            $n=($_GET['n']);
        }else{$n=1;}
        $n=$n*1000;
        $end=1000;
        $n=$n-1000;
        if($n == '0'){$n=1;}
        $product = db::select("`products" . $lng . "`", '`active`=1 ', "ORDER BY `id` DESC LIMIT " . $n . "," . $end);
        if (!empty($product)) {
            foreach ($product as $pr) {
                if(!empty($pr['permalink'])) {
                    if(preg_match("#esgtrade.com#",$pr['permalink'])){$url=$pr['permalink'];}else{$url='';}
                    $id=$pr['id'];
                    $url=$pr['permalink'];
                    echo '<url><loc>'.sm::urlproductMB("$lang","$id","$url").'</loc>';
                    if (!empty($pr['image'])) {
                        if (preg_match("#|#", $pr['image'])) {
                            $image = explode('|', $pr['image']);
                        } else {
                            $image[0] = $pr['image'];
                        }
                        echo '<lastmod>'.sm::timeMB($pr['date']).'</lastmod>';
                        $image = array_reverse($image);
                        foreach ($image as $img) {
                            if(!empty($img)) {
                                echo '<image:image>
                                <image:loc>'.$img.'</image:loc>
                                <image:caption><![CDATA['.$pr['title'].']]></image:caption>
                            </image:image>';
                            }
                        }
                    }
                    echo '</url>';
                }
            }

        }

        break;
    case "category";
        break;
    case "brand";
        break;
    case "product_cat";
        break;
    case "author";
        break;
    default:
        header("Location: ".url."404", true, 301);
        exit();
        ?>
<?php
}
?>
</urlset>
<?php }else{ //*********** Index SiteMap MB ************//
echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.urlsitemap.'main-sitemap.xsl"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
?>

    <sitemap>
        <loc><?= url.$lang.sm::htmlMB('post-sitemap.xml') ?></loc>
        <lastmod><?= sm::timeMB(time()) ?></lastmod>
    </sitemap>

    <sitemap>
        <loc><?= url.$lang.sm::htmlMB('page-sitemap.xml')?></loc>
        <lastmod><?= sm::timeMB(time()) ?></lastmod>
    </sitemap>
    <?php
    $products = db::count("`products".$lng.'`',"`active`=1")[0][0];
    $count = $products / 1000;
    for ($i = 1; $i <= $count; $i++) {
        ?>
        <sitemap>
            <loc><?= sm::urlproduct2MB($lang,$i) ?></loc>
            <lastmod><?= sm::timeMB(time()) ?></lastmod>
        </sitemap>
        <?PHP
    }
    ?>
    <sitemap>
        <loc><?= url.$lang.sm::htmlMB('category-sitemap.xml')?></loc>
        <lastmod><?= sm::timeMB(time()) ?></lastmod>
    </sitemap>

    <sitemap>
        <loc><?= url.$lang.sm::htmlMB('product_cat-sitemap.xml')?></loc>
        <lastmod><?= sm::timeMB(time()) ?></lastmod>
    </sitemap>

    <sitemap>
        <loc><?= url.$lang.sm::htmlMB('brand-sitemap.xml')?></loc>
        <lastmod><?= sm::timeMB(time()) ?></lastmod>
    </sitemap>

    <sitemap>
        <loc><?= url.$lang.sm::htmlMB('author-sitemap.xml')?></loc>
        <lastmod><?= sm::timeMB(time()) ?></lastmod>
    </sitemap>

</sitemapindex>
<?php } ?>
<!-- XML Sitemap generated by PluginYoast -->
