<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

$sunucu = "sql211.infinityfree.com";
$veritabani = "if0_42002856_mehmet_web_projesi";
$kullanici = "if0_42002856";
$sifre = "mYiYxIhwO9DQnQV";

$ogrenciAdi = "MEHMET UĞURLUAKDOĞAN";
$ogrenciNo = "24660210054";

function baglan()
{
    global $sunucu, $veritabani, $kullanici, $sifre;

    try {
        $db = new PDO("mysql:host=$sunucu;dbname=$veritabani;charset=utf8mb4", $kullanici, $sifre);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    } catch (Exception $hata) {
        return false;
    }
}

function temizle($yazi)
{
    return htmlspecialchars($yazi ?? "", ENT_QUOTES, "UTF-8");
}

function listele($sql, $degerler = array())
{
    $db = baglan();
    if (!$db) {
        return array();
    }

    $sorgu = $db->prepare($sql);
    $sorgu->execute($degerler);
    return $sorgu->fetchAll();
}

function tekKayit($sql, $degerler = array())
{
    $sonuc = listele($sql, $degerler);
    return isset($sonuc[0]) ? $sonuc[0] : null;
}

function formDegeri($ad)
{
    return trim($_POST[$ad] ?? "");
}

function yonlendir($sayfa, $mesaj)
{
    header("Location: index.php?sayfa=" . urlencode($sayfa) . "&mesaj=" . urlencode($mesaj));
    exit;
}

function formlariKaydet($aktifSayfa)
{
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return;
    }

    $db = baglan();
    if (!$db) {
        return;
    }

    $form = formDegeri("form_turu");

    try {
        if ($form == "iletisim") {
            $sorgu = $db->prepare("INSERT INTO contact_messages (full_name,email,subject,message) VALUES (?,?,?,?)");
            $sorgu->execute(array(formDegeri("ad_soyad"), formDegeri("email"), formDegeri("konu"), formDegeri("mesaj")));
            yonlendir($aktifSayfa, "iletisim_ok");
        }

        if ($form == "kariyer") {
            $sorgu = $db->prepare("INSERT INTO career_applications (full_name,email,phone,position,message) VALUES (?,?,?,?,?)");
            $sorgu->execute(array(formDegeri("ad_soyad"), formDegeri("email"), formDegeri("telefon"), formDegeri("pozisyon"), formDegeri("mesaj")));
            yonlendir($aktifSayfa, "kariyer_ok");
        }

        if ($form == "destek") {
            $sorgu = $db->prepare("INSERT INTO support_tickets (full_name,email,phone,company,priority,subject,details) VALUES (?,?,?,?,?,?,?)");
            $sorgu->execute(array(formDegeri("ad_soyad"), formDegeri("email"), formDegeri("telefon"), formDegeri("firma"), formDegeri("oncelik"), formDegeri("konu"), formDegeri("detay")));
            yonlendir($aktifSayfa, "destek_ok");
        }
    } catch (Exception $hata) {
        yonlendir($aktifSayfa, "hata");
    }
}

function menuAgaci($menuler, $ustId = null)
{
    $sonuc = array();

    foreach ($menuler as $menu) {
        if ($menu["parent_id"] == $ustId) {
            $menu["altlar"] = menuAgaci($menuler, $menu["id"]);
            $sonuc[] = $menu;
        }
    }

    return $sonuc;
}

function menuYaz($menuler, $aktifSayfa)
{
    echo "<ul>";
    foreach ($menuler as $menu) {
        $aktif = ($aktifSayfa == $menu["slug"]) ? "aktif" : "";
        echo "<li class='$aktif'>";
        echo "<a href='index.php?sayfa=" . temizle($menu["slug"]) . "'>" . temizle($menu["title"]) . "</a>";

        if (count($menu["altlar"]) > 0) {
            menuYaz($menu["altlar"], $aktifSayfa);
        }

        echo "</li>";
    }
    echo "</ul>";
}

function bilgiMesaji()
{
    $mesaj = $_GET["mesaj"] ?? "";
    $yazilar = array(
        "iletisim_ok" => "Mesajınız kaydedildi.",
        "kariyer_ok" => "İş başvurunuz kaydedildi.",
        "destek_ok" => "Destek talebiniz kaydedildi.",
        "hata" => "İşlem yapılırken hata oluştu."
    );

    if (isset($yazilar[$mesaj])) {
        echo "<div class='mesaj'>" . temizle($yazilar[$mesaj]) . "</div>";
    }
}

function sayfaBasligi($baslik, $ozet, $etiket = "Uğurlu Yazılım Ajansı")
{
    global $ogrenciAdi, $ogrenciNo;
    echo "<section class='sayfa-baslik'>";
    echo "<div><span>$etiket</span><h1>" . temizle($baslik) . "</h1><p>" . temizle($ozet) . "</p></div>";
    echo "<aside><b>$ogrenciAdi</b><em>$ogrenciNo</em></aside>";
    echo "</section>";
}

function anaSayfa()
{
    $hizmetler = listele("SELECT * FROM services ORDER BY sort_order LIMIT 4");
    $projeler = listele("SELECT * FROM projects ORDER BY sort_order LIMIT 4");
    $duyurular = listele("SELECT * FROM posts ORDER BY published_at DESC LIMIT 3");

    echo "<section class='ana'>";
    echo "<div class='ana-yazi'><span>PHP + MySQL Projesi</span><h1>Uğurlu Yazılım Ajansı</h1>";
    echo "<p>Bu site Web Projesi Yönetimi dersi için hazırlanmıştır. Menü, içerik, formlar ve yönetim paneli veritabanı ile çalışır.</p>";
    echo "<a href='index.php?sayfa=cozumlerimiz-hizmetlerimiz'>Hizmetleri İncele</a></div>";
    echo "<div class='ana-not'><b>Hazırlayan</b><strong>MEHMET UĞURLUAKDOĞAN</strong><small>24660210054</small></div>";
    echo "</section>";

    echo "<section class='bolum'><h2>Hizmetlerimiz</h2><div class='kartlar'>";
    foreach ($hizmetler as $hizmet) {
        echo "<article><span>" . temizle($hizmet["service_code"]) . "</span><h3>" . temizle($hizmet["title"]) . "</h3><p>" . temizle($hizmet["summary"]) . "</p></article>";
    }
    echo "</div></section>";

    echo "<section class='bolum'><h2>Çalışmalarımız</h2><div class='proje-listesi'>";
    foreach ($projeler as $proje) {
        echo "<article><img src='" . temizle($proje["image_path"]) . "' alt=''><div><b>" . temizle($proje["status"]) . "</b><h3>" . temizle($proje["title"]) . "</h3><p>" . temizle($proje["summary"]) . "</p></div></article>";
    }
    echo "</div></section>";

    echo "<section class='bolum'><h2>Medya ve Bilgi Merkezi</h2><div class='duyurular'>";
    foreach ($duyurular as $duyuru) {
        echo "<p><b>" . temizle($duyuru["title"]) . "</b><br>" . temizle($duyuru["summary"]) . "</p>";
    }
    echo "</div></section>";
}

function normalSayfa($slug)
{
    $sayfa = tekKayit("SELECT * FROM pages WHERE slug=?", array($slug));

    if (!$sayfa) {
        sayfaBasligi("Sayfa bulunamadı", "Bu sayfaya ait içerik bulunamadı.", "Bilgi");
        return;
    }

    sayfaBasligi($sayfa["title"], $sayfa["summary"], "Kurumsal");
    echo "<section class='icerik'>";
    echo "<div><p>" . nl2br(temizle($sayfa["content"])) . "</p></div>";
    echo "<aside><b>Not</b><p>" . temizle($sayfa["side_note"]) . "</p></aside>";
    echo "</section>";
}

function hizmetleriYaz($kategori = "")
{
    if ($kategori == "" || $kategori == "tum-hizmetler") {
        $hizmetler = listele("SELECT * FROM services ORDER BY category, sort_order");
    } else {
        $hizmetler = listele("SELECT * FROM services WHERE category=? ORDER BY sort_order", array($kategori));
    }

    sayfaBasligi("Çözümlerimiz & Hizmetlerimiz", "Bireysel ve kurumsal yazılım hizmetleri.", "Hizmetler");
    echo "<section class='kartlar'>";
    foreach ($hizmetler as $hizmet) {
        echo "<article><span>" . temizle($hizmet["category"]) . "</span><h3>" . temizle($hizmet["title"]) . "</h3><p>" . temizle($hizmet["summary"]) . "</p><a href='index.php?sayfa=" . temizle($hizmet["slug"]) . "'>Detay</a></article>";
    }
    echo "</section>";
}

function hizmetDetay($slug)
{
    $hizmet = tekKayit("SELECT * FROM services WHERE slug=?", array($slug));
    if (!$hizmet) {
        hizmetleriYaz();
        return;
    }

    sayfaBasligi($hizmet["title"], $hizmet["summary"], $hizmet["category"]);
    echo "<section class='icerik'><div><h2>" . temizle($hizmet["service_code"]) . "</h2><p>" . temizle($hizmet["content"]) . "</p></div>";
    echo "<aside><b>Teklif için</b><p>İletişim formundan bize ulaşabilirsiniz.</p></aside></section>";
}

function projeleriYaz($durum = "")
{
    if ($durum == "" || $durum == "tum-projeler") {
        $projeler = listele("SELECT * FROM projects ORDER BY sort_order");
    } else {
        $projeler = listele("SELECT * FROM projects WHERE status=? ORDER BY sort_order", array($durum));
    }

    sayfaBasligi("Çalışmalarımız", "Tamamlanan ve devam eden projelerimiz.", "Projeler");
    echo "<section class='proje-listesi buyuk'>";
    foreach ($projeler as $proje) {
        echo "<article><img src='" . temizle($proje["image_path"]) . "' alt=''><div><b>" . temizle($proje["status"]) . " / " . temizle($proje["sector"]) . "</b><h3>" . temizle($proje["title"]) . "</h3><p>" . temizle($proje["content"]) . "</p></div></article>";
    }
    echo "</section>";
}

function referanslariYaz($tur = "")
{
    if ($tur == "" || $tur == "tum-referanslar") {
        $referanslar = listele("SELECT * FROM `references` ORDER BY sort_order");
    } else {
        $referanslar = listele("SELECT * FROM `references` WHERE ref_type=? ORDER BY sort_order", array($tur));
    }

    sayfaBasligi("Referanslarımız", "Sektörel referanslar ve çözüm ortakları.", "Referans");
    echo "<section class='kartlar iki'>";
    foreach ($referanslar as $ref) {
        echo "<article><span>" . temizle($ref["ref_type"]) . "</span><h3>" . temizle($ref["title"]) . "</h3><p>" . temizle($ref["summary"]) . "</p></article>";
    }
    echo "</section>";
}

function blogYaz($kategori = "")
{
    if ($kategori == "" || $kategori == "tum-blog") {
        $yazilar = listele("SELECT * FROM posts WHERE post_type='Blog' ORDER BY published_at DESC");
    } else {
        $yazilar = listele("SELECT * FROM posts WHERE post_type='Blog' AND category=? ORDER BY published_at DESC", array($kategori));
    }

    sayfaBasligi("Blog", "Sektörel haberler, ipuçları ve rehberler.", "Blog");
    echo "<section class='yazi-listesi'>";
    foreach ($yazilar as $yazi) {
        echo "<article><time>" . temizle($yazi["published_at"]) . "</time><h3>" . temizle($yazi["title"]) . "</h3><p>" . temizle($yazi["content"]) . "</p></article>";
    }
    echo "</section>";
}

function duyurularYaz()
{
    $duyurular = listele("SELECT * FROM posts WHERE post_type='Duyuru' ORDER BY published_at DESC");
    sayfaBasligi("Duyurular", "Ajans duyuruları ve haberler.", "Duyuru");
    echo "<section class='yazi-listesi'>";
    foreach ($duyurular as $duyuru) {
        echo "<article><time>" . temizle($duyuru["published_at"]) . "</time><h3>" . temizle($duyuru["title"]) . "</h3><p>" . temizle($duyuru["summary"]) . "</p></article>";
    }
    echo "</section>";
}

function videolarYaz()
{
    $videolar = listele("SELECT * FROM media ORDER BY sort_order");
    sayfaBasligi("Video Galeri", "Tanıtım ve süreç videoları.", "Video");
    echo "<section class='video-listesi'>";
    foreach ($videolar as $video) {
        echo "<article><iframe src='" . temizle($video["url"]) . "' title='" . temizle($video["title"]) . "'></iframe><h3>" . temizle($video["title"]) . "</h3><p>" . temizle($video["summary"]) . "</p></article>";
    }
    echo "</section>";
}

function sssYaz()
{
    $sorular = listele("SELECT * FROM faqs ORDER BY sort_order");
    sayfaBasligi("Sıkça Sorulan Sorular", "Merak edilen konular.", "SSS");
    echo "<section class='sss'>";
    foreach ($sorular as $soru) {
        echo "<details><summary>" . temizle($soru["question"]) . "</summary><p>" . temizle($soru["answer"]) . "</p></details>";
    }
    echo "</section>";
}

function medyaMerkezi()
{
    sayfaBasligi("Medya ve Bilgi Merkezi", "Blog, video galeri, duyurular ve SSS alanı.", "Medya");
    echo "<section class='kartlar'>";
    echo "<article><h3>Blog</h3><p>Yazılım ve web hakkında yazılar.</p><a href='index.php?sayfa=blog'>Aç</a></article>";
    echo "<article><h3>Video Galeri</h3><p>Tanıtım videoları.</p><a href='index.php?sayfa=video-galeri'>Aç</a></article>";
    echo "<article><h3>Duyurular</h3><p>Güncel duyurular.</p><a href='index.php?sayfa=duyurular'>Aç</a></article>";
    echo "<article><h3>SSS</h3><p>Sıkça sorulan sorular.</p><a href='index.php?sayfa=sss'>Aç</a></article>";
    echo "</section>";
}

function kariyerFormu()
{
    normalSayfa("kariyer");
    echo "<section class='form-alani'><form method='post'>";
    echo "<input type='hidden' name='form_turu' value='kariyer'>";
    echo "<label>Ad Soyad<input name='ad_soyad' required></label>";
    echo "<label>E-posta<input name='email' type='email' required></label>";
    echo "<label>Telefon<input name='telefon' required></label>";
    echo "<label>Pozisyon<select name='pozisyon'><option>Junior Web Geliştirici</option><option>İçerik Editörü</option><option>Destek Uzmanı</option></select></label>";
    echo "<label class='tam'>Kendinizi Kısaca Tanıtın<textarea name='mesaj' required></textarea></label>";
    echo "<button>Başvuruyu Gönder</button>";
    echo "</form></section>";
}

function iletisimFormu()
{
    normalSayfa("iletisim");
    echo "<section class='iletisim-alani'>";
    echo "<iframe src='https://www.openstreetmap.org/export/embed.html?bbox=34.520%2C36.760%2C34.640%2C36.830&layer=mapnik'></iframe>";
    echo "<form method='post'><input type='hidden' name='form_turu' value='iletisim'>";
    echo "<label>Ad Soyad<input name='ad_soyad' required></label>";
    echo "<label>E-posta<input name='email' type='email' required></label>";
    echo "<label>Konu<input name='konu' required></label>";
    echo "<label>Mesaj<textarea name='mesaj' required></textarea></label>";
    echo "<button>Mesajı Gönder</button></form></section>";
}

function destekFormu()
{
    sayfaBasligi("Müşteri Destek Talebi", "Ayrıntılı destek formu.", "Destek");
    echo "<section class='form-alani'><form method='post'>";
    echo "<input type='hidden' name='form_turu' value='destek'>";
    echo "<label>Ad Soyad<input name='ad_soyad' required></label>";
    echo "<label>E-posta<input name='email' type='email' required></label>";
    echo "<label>Telefon<input name='telefon' required></label>";
    echo "<label>Firma<input name='firma'></label>";
    echo "<label>Öncelik<select name='oncelik'><option>Normal</option><option>Düşük</option><option>Acil</option></select></label>";
    echo "<label>Konu<input name='konu' required></label>";
    echo "<label class='tam'>Detay<textarea name='detay' required></textarea></label>";
    echo "<button>Talebi Kaydet</button></form></section>";
}

function sayfayiGoster($menu)
{
    if (!$menu) {
        sayfaBasligi("Sayfa bulunamadı", "Menü kaydı bulunamadı.", "Hata");
        return;
    }

    if ($menu["content_type"] == "home") anaSayfa();
    elseif ($menu["content_type"] == "page") normalSayfa($menu["content_slug"]);
    elseif ($menu["content_type"] == "services") hizmetleriYaz($menu["content_slug"]);
    elseif ($menu["content_type"] == "service_detail") hizmetDetay($menu["content_slug"]);
    elseif ($menu["content_type"] == "projects" || $menu["content_type"] == "project_gallery") projeleriYaz($menu["content_slug"]);
    elseif ($menu["content_type"] == "references") referanslariYaz($menu["content_slug"]);
    elseif ($menu["content_type"] == "blog") blogYaz($menu["content_slug"]);
    elseif ($menu["content_type"] == "videos") videolarYaz();
    elseif ($menu["content_type"] == "announcements") duyurularYaz();
    elseif ($menu["content_type"] == "faqs") sssYaz();
    elseif ($menu["content_type"] == "media_center") medyaMerkezi();
    elseif ($menu["content_type"] == "career") kariyerFormu();
    elseif ($menu["content_type"] == "contact") iletisimFormu();
    elseif ($menu["content_type"] == "support") destekFormu();
    else normalSayfa($menu["content_slug"]);
}

$aktifSayfa = $_GET["sayfa"] ?? "ana-sayfa";
$aktifSayfa = preg_replace("/[^a-z0-9\-]/", "", strtolower($aktifSayfa));
if ($aktifSayfa == "") {
    $aktifSayfa = "ana-sayfa";
}

formlariKaydet($aktifSayfa);
$dbVarMi = baglan() ? true : false;
$tumMenuler = $dbVarMi ? listele("SELECT * FROM menus WHERE is_active=1 ORDER BY parent_id, sort_order") : array();
$menu = $dbVarMi ? tekKayit("SELECT * FROM menus WHERE slug=? AND is_active=1", array($aktifSayfa)) : null;
$menuAgaci = menuAgaci($tumMenuler);
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Uğurlu Yazılım Ajansı - <?php echo $ogrenciNo; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="ust">
    <a class="logo" href="index.php?sayfa=ana-sayfa"><img src="assets/img/logo.svg" alt=""> Uğurlu Yazılım Ajansı</a>
    <button class="menu-buton" type="button">Menü</button>
    <p><?php echo temizle($ogrenciAdi); ?> - <?php echo temizle($ogrenciNo); ?></p>
</header>

<div class="sayfa">
    <nav class="sol-menu">
        <h2>Site Haritası</h2>
        <?php if ($dbVarMi) menuYaz($menuAgaci, $aktifSayfa); ?>
        <a class="admin-kisa" href="admin.php">Admin Paneli</a>
    </nav>

    <main>
        <?php bilgiMesaji(); ?>
        <?php
        if (!$dbVarMi) {
            echo "<section class='uyari'><h1>Veritabanı bağlantısı yok</h1><p>Önce XAMPP üzerinden MySQL çalıştırılıp mehmet_web_projesi.sql dosyası import edilmelidir.</p></section>";
        } else {
            sayfayiGoster($menu);
        }
        ?>
    </main>
</div>

<footer>
    <span>Web Projesi Yönetimi Dersi</span>
    <b><?php echo temizle($ogrenciAdi); ?> - <?php echo temizle($ogrenciNo); ?></b>
</footer>
<script src="assets/js/script.js"></script>
</body>
</html>
