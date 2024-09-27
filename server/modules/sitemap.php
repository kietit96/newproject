<?php
include_once('../config.php');
include_once('../modules/control.php');
$file = "sitemap.xml";
// $url = baseUrl;
$url = 'http://' . $domain . '/';
if (isset($_GET["url"])) {
    $url = $_GET["url"];
}
define('CLI', false);
define('VERSION', "1.0");
define('NL', CLI ? "\n" : "<br>");

$pf = fopen('../' . $file, "w");
if (!$pf) {
    echo "Cannot create $file!" . NL;
    return;
}
fwrite($pf, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
    "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n" .
    "        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n" .
    "        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n" .
    "        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n" .
    "  <url>\n" .
    "    <loc>$url</loc>\n" .
    "    <changefreq>daily</changefreq>\n" .
    "  </url>\n");
$listLang = $db->listMenuChild($menuLang->id);
foreach ($listLang as $key => $lang1) {
    if ($lang1->name == 'en') {
        foreach ($listMenu as $key => $menu) {
            //Filler
            if ($menu->file == 'shop') continue;

            $listMenuChild = $db->listMenuChild($menu->id);
            $listData = $db->allListDataChild($menu->id);
            $linkId = $db->findOrCreateSlug($menu->title, 'menu', $menu->id);
            fwrite(
                $pf,
                "<url>\n" .
                    "   <loc>" . $url . $linkId->slugName . "</loc>\n" .
                    "   <changefreq>daily</changefreq>\n" .
                    "   <priority>0.5</priority>\n" .
                    "</url>\n"
            );

            $db->loopMenuSitemap($listMenuChild, $menu->name, $pf);
            foreach ($listData as $key => $data) {
                $linkId = $db->findOrCreateSlug($data->title, 'data', $data->id);
                if ($menu->file != 'home' && $menu->file != 'contact') {
                    fwrite(
                        $pf,
                        "<url>\n" .
                            "   <loc>" . $url . $linkId->slugName . "</loc>\n" .
                            "   <changefreq>daily</changefreq>\n" .
                            "   <priority>0.5</priority>\n" .
                            "</url>\n"
                    );
                }
            }
        }
    } else {
        foreach ($listMenu as $key => $menu) {
            //Filler
            if ($menu->file == 'shop') continue;

            $listMenuChild = $db->listMenuChild($menu->id);
            $listData = $db->allListDataChild($menu->id);
            $linkId = $db->findOrCreateSlug($menu->title, 'menu', $menu->id);
            fwrite(
                $pf,
                "<url>\n" .
                    "   <loc>" . $url . $linkId->slugName . "?lang=$lang1->name" . "</loc>\n" .
                    "   <changefreq>daily</changefreq>\n" .
                    "   <priority>0.5</priority>\n" .
                    "</url>\n"
            );

            $db->loopMenuSitemap($listMenuChild, $menu->name, $pf);
            foreach ($listData as $key => $data) {
                $linkId = $db->findOrCreateSlug($data->title, 'data', $data->id);
                if ($menu->file != 'home' && $menu->file != 'contact') {
                    fwrite(
                        $pf,
                        "<url>\n" .
                            "   <loc>" . $url . $linkId->slugName . "?lang=$lang1->name" . "</loc>\n" .
                            "   <changefreq>daily</changefreq>\n" .
                            "   <priority>0.5</priority>\n" .
                            "</url>\n"
                    );
                }
            }
        }
    }
}

fwrite($pf, "</urlset>\n");
fclose($pf);
echo "$file đã cập nhật thành công.";
