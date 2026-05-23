<?php
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

function adminYonlendir($bolum, $mesaj)
{
    header("Location: admin.php?bolum=" . urlencode($bolum) . "&mesaj=" . urlencode($mesaj));
    exit;
}

function bolumler()
{
    return array(
        "pages" => array(
            "baslik" => "Sayfa İçerikleri",
            "tablo" => "pages",
            "sql_tablo" => "pages",
            "alanlar" => array(
                "slug" => array("etiket" => "Slug", "tip" => "text"),
                "title" => array("etiket" => "Başlık", "tip" => "text"),
                "summary" => array("etiket" => "Özet", "tip" => "text"),
                "content" => array("etiket" => "İçerik", "tip" => "textarea"),
                "side_note" => array("etiket" => "Yan Not", "tip" => "text")
            ),
            "liste" => array("slug", "title", "summary")
        ),
        "services" => array(
            "baslik" => "Hizmetler",
            "tablo" => "services",
            "sql_tablo" => "services",
            "alanlar" => array(
                "slug" => array("etiket" => "Slug", "tip" => "text"),
                "category" => array("etiket" => "Kategori", "tip" => "select", "secenek" => array("Bireysel Hizmetler", "Kurumsal Danışmanlık")),
                "title" => array("etiket" => "Başlık", "tip" => "text"),
                "summary" => array("etiket" => "Özet", "tip" => "text"),
                "content" => array("etiket" => "İçerik", "tip" => "textarea"),
                "service_code" => array("etiket" => "Hizmet Kodu", "tip" => "text"),
                "sort_order" => array("etiket" => "Sıra", "tip" => "number")
            ),
            "liste" => array("service_code", "category", "title")
        ),
        "projects" => array(
            "baslik" => "Projeler",
            "tablo" => "projects",
            "sql_tablo" => "projects",
            "alanlar" => array(
                "slug" => array("etiket" => "Slug", "tip" => "text"),
                "title" => array("etiket" => "Başlık", "tip" => "text"),
                "status" => array("etiket" => "Durum", "tip" => "select", "secenek" => array("Tamamlanan", "Devam Eden")),
                "sector" => array("etiket" => "Sektör", "tip" => "text"),
                "summary" => array("etiket" => "Özet", "tip" => "text"),
                "content" => array("etiket" => "Açıklama", "tip" => "textarea"),
                "image_path" => array("etiket" => "Görsel Yolu", "tip" => "text"),
                "sort_order" => array("etiket" => "Sıra", "tip" => "number")
            ),
            "liste" => array("status", "sector", "title")
        ),
        "references" => array(
            "baslik" => "Referanslar",
            "tablo" => "references",
            "sql_tablo" => "`references`",
            "alanlar" => array(
                "title" => array("etiket" => "Başlık", "tip" => "text"),
                "ref_type" => array("etiket" => "Tür", "tip" => "select", "secenek" => array("Sektörel Referans", "Kurumsal Çözüm Ortağı")),
                "sector" => array("etiket" => "Sektör", "tip" => "text"),
                "summary" => array("etiket" => "Özet", "tip" => "text"),
                "sort_order" => array("etiket" => "Sıra", "tip" => "number")
            ),
            "liste" => array("ref_type", "sector", "title")
        ),
        "posts" => array(
            "baslik" => "Blog ve Duyurular",
            "tablo" => "posts",
            "sql_tablo" => "posts",
            "alanlar" => array(
                "slug" => array("etiket" => "Slug", "tip" => "text"),
                "post_type" => array("etiket" => "Tür", "tip" => "select", "secenek" => array("Blog", "Duyuru")),
                "category" => array("etiket" => "Kategori", "tip" => "text"),
                "title" => array("etiket" => "Başlık", "tip" => "text"),
                "summary" => array("etiket" => "Özet", "tip" => "text"),
                "content" => array("etiket" => "İçerik", "tip" => "textarea"),
                "published_at" => array("etiket" => "Yayın Tarihi", "tip" => "date")
            ),
            "liste" => array("post_type", "category", "title")
        ),
        "media" => array(
            "baslik" => "Video Galeri",
            "tablo" => "media",
            "sql_tablo" => "media",
            "alanlar" => array(
                "title" => array("etiket" => "Başlık", "tip" => "text"),
                "media_type" => array("etiket" => "Tür", "tip" => "select", "secenek" => array("Video", "Galeri")),
                "url" => array("etiket" => "Video URL", "tip" => "text"),
                "summary" => array("etiket" => "Özet", "tip" => "text"),
                "sort_order" => array("etiket" => "Sıra", "tip" => "number")
            ),
            "liste" => array("media_type", "title", "url")
        ),
        "faqs" => array(
            "baslik" => "SSS",
            "tablo" => "faqs",
            "sql_tablo" => "faqs",
            "alanlar" => array(
                "question" => array("etiket" => "Soru", "tip" => "text"),
                "answer" => array("etiket" => "Cevap", "tip" => "textarea"),
                "sort_order" => array("etiket" => "Sıra", "tip" => "number")
            ),
            "liste" => array("question", "sort_order")
        )
    );
}

function girisYapildiMi()
{
    return isset($_SESSION["admin_giris"]) && $_SESSION["admin_giris"] == true;
}

function girisKontrol()
{
    if (isset($_GET["cikis"])) {
        session_destroy();
        header("Location: admin.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] != "POST" || formDegeri("giris_formu") != "1") {
        return "";
    }

    $kullaniciAdi = formDegeri("kullanici_adi");
    $sifre = formDegeri("sifre");
    $admin = tekKayit("SELECT * FROM admin_users WHERE username=?", array($kullaniciAdi));

    if ($admin && $admin["password_hash"] == $sifre) {
        $_SESSION["admin_giris"] = true;
        $_SESSION["admin_ad"] = $admin["full_name"];
        adminYonlendir("panel", "ok");
    }

    return "Kullanıcı adı veya şifre hatalı.";
}

function kayitIslemleri($bolum)
{
    if ($_SERVER["REQUEST_METHOD"] != "POST" || !girisYapildiMi()) {
        return;
    }

    $tumBolumler = bolumler();
    if (!isset($tumBolumler[$bolum])) {
        return;
    }

    $db = baglan();
    if (!$db) {
        return;
    }

    $ayar = $tumBolumler[$bolum];
    $tablo = $ayar["sql_tablo"];
    $islem = formDegeri("islem");
    $id = intval(formDegeri("id"));

    try {
        if ($islem == "sil" && $id > 0) {
            $sorgu = $db->prepare("DELETE FROM $tablo WHERE id=?");
            $sorgu->execute(array($id));
            adminYonlendir($bolum, "silindi");
        }

        if ($islem == "kaydet") {
            $alanAdlari = array_keys($ayar["alanlar"]);
            $degerler = array();

            foreach ($alanAdlari as $alan) {
                $degerler[] = formDegeri($alan);
            }

            if ($id > 0) {
                $setler = array();
                foreach ($alanAdlari as $alan) {
                    $setler[] = "$alan=?";
                }
                $degerler[] = $id;
                $sorgu = $db->prepare("UPDATE $tablo SET " . implode(",", $setler) . " WHERE id=?");
                $sorgu->execute($degerler);
                adminYonlendir($bolum, "guncellendi");
            } else {
                $soruIsaretleri = array_fill(0, count($alanAdlari), "?");
                $sorgu = $db->prepare("INSERT INTO $tablo (" . implode(",", $alanAdlari) . ") VALUES (" . implode(",", $soruIsaretleri) . ")");
                $sorgu->execute($degerler);
                adminYonlendir($bolum, "eklendi");
            }
        }
    } catch (Exception $hata) {
        adminYonlendir($bolum, "hata");
    }
}

function destekDurumGuncelle()
{
    if ($_SERVER["REQUEST_METHOD"] != "POST" || formDegeri("islem") != "destek_durum") {
        return;
    }

    $db = baglan();
    if (!$db) {
        return;
    }

    $sorgu = $db->prepare("UPDATE support_tickets SET status=? WHERE id=?");
    $sorgu->execute(array(formDegeri("durum"), intval(formDegeri("id"))));
    adminYonlendir("support", "guncellendi");
}

function mesajYaz()
{
    $mesaj = $_GET["mesaj"] ?? "";
    $yazilar = array(
        "ok" => "İşlem tamamlandı.",
        "eklendi" => "Kayıt eklendi.",
        "guncellendi" => "Kayıt güncellendi.",
        "silindi" => "Kayıt silindi.",
        "hata" => "İşlem sırasında hata oluştu."
    );

    if (isset($yazilar[$mesaj])) {
        echo "<div class='mesaj'>" . temizle($yazilar[$mesaj]) . "</div>";
    }
}

function alanYaz($ad, $bilgi, $kayit)
{
    $deger = $kayit[$ad] ?? "";
    echo "<label>" . temizle($bilgi["etiket"]);

    if ($bilgi["tip"] == "textarea") {
        echo "<textarea name='" . temizle($ad) . "' required>" . temizle($deger) . "</textarea>";
    } elseif ($bilgi["tip"] == "select") {
        echo "<select name='" . temizle($ad) . "' required>";
        foreach ($bilgi["secenek"] as $secenek) {
            $secildi = ($deger == $secenek) ? "selected" : "";
            echo "<option $secildi>" . temizle($secenek) . "</option>";
        }
        echo "</select>";
    } else {
        echo "<input type='" . temizle($bilgi["tip"]) . "' name='" . temizle($ad) . "' value='" . temizle($deger) . "' required>";
    }

    echo "</label>";
}

function duzenlemeEkrani($bolum, $ayar)
{
    $id = intval($_GET["duzenle"] ?? 0);
    $kayit = $id > 0 ? tekKayit("SELECT * FROM " . $ayar["sql_tablo"] . " WHERE id=?", array($id)) : array();
    $kayitlar = listele("SELECT * FROM " . $ayar["sql_tablo"] . " ORDER BY id DESC");

    echo "<section class='admin-calisma'>";
    echo "<div class='admin-form'>";
    echo "<h2>" . temizle($ayar["baslik"]) . "</h2>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='islem' value='kaydet'>";
    echo "<input type='hidden' name='id' value='" . temizle($id) . "'>";
    foreach ($ayar["alanlar"] as $ad => $bilgi) {
        alanYaz($ad, $bilgi, $kayit);
    }
    echo "<button>Kaydet</button>";
    echo "</form></div>";

    echo "<div class='admin-liste'><h2>Kayıtlar</h2><table><tr><th>ID</th>";
    foreach ($ayar["liste"] as $kolon) {
        echo "<th>" . temizle($kolon) . "</th>";
    }
    echo "<th>İşlem</th></tr>";

    foreach ($kayitlar as $satir) {
        echo "<tr><td>" . temizle($satir["id"]) . "</td>";
        foreach ($ayar["liste"] as $kolon) {
            echo "<td>" . temizle($satir[$kolon] ?? "") . "</td>";
        }
        echo "<td class='islem'>";
        echo "<a href='admin.php?bolum=" . temizle($bolum) . "&duzenle=" . temizle($satir["id"]) . "'>Düzenle</a>";
        echo "<form method='post'><input type='hidden' name='islem' value='sil'><input type='hidden' name='id' value='" . temizle($satir["id"]) . "'><button>Sil</button></form>";
        echo "</td></tr>";
    }

    echo "</table></div></section>";
}

function panelOzeti()
{
    $sayilar = array(
        "Sayfa" => "pages",
        "Hizmet" => "services",
        "Proje" => "projects",
        "Mesaj" => "contact_messages",
        "Başvuru" => "career_applications",
        "Destek" => "support_tickets"
    );

    echo "<section class='admin-hero'><span>Yönetim Paneli</span><h1>İçerik Yönetimi</h1><p>Bu bölümden site içerikleri eklenir, güncellenir ve silinir.</p></section>";
    echo "<section class='sayaclar'>";
    foreach ($sayilar as $baslik => $tablo) {
        $sayi = tekKayit("SELECT COUNT(*) AS adet FROM $tablo");
        echo "<article><span>$baslik</span><b>" . temizle($sayi["adet"] ?? 0) . "</b></article>";
    }
    echo "</section>";
}

function menuListesi()
{
    $menuler = listele("SELECT m.*, u.title AS ust_menu FROM menus m LEFT JOIN menus u ON u.id=m.parent_id ORDER BY COALESCE(m.parent_id,0), m.sort_order");
    echo "<section class='admin-liste tek'><h2>Site Haritası</h2><table><tr><th>ID</th><th>Üst Menü</th><th>Başlık</th><th>Slug</th><th>Tür</th></tr>";
    foreach ($menuler as $menu) {
        echo "<tr><td>" . temizle($menu["id"]) . "</td><td>" . temizle($menu["ust_menu"] ?? "-") . "</td><td>" . temizle($menu["title"]) . "</td><td>" . temizle($menu["slug"]) . "</td><td>" . temizle($menu["content_type"]) . "</td></tr>";
    }
    echo "</table></section>";
}

function tabloGoster($baslik, $tablo, $kolonlar)
{
    $kayitlar = listele("SELECT * FROM $tablo ORDER BY id DESC");
    echo "<section class='admin-liste tek'><h2>$baslik</h2><table><tr><th>ID</th>";
    foreach ($kolonlar as $kolon) {
        echo "<th>" . temizle($kolon) . "</th>";
    }
    echo "</tr>";

    foreach ($kayitlar as $satir) {
        echo "<tr><td>" . temizle($satir["id"]) . "</td>";
        foreach ($kolonlar as $kolon) {
            echo "<td>" . temizle($satir[$kolon] ?? "") . "</td>";
        }
        echo "</tr>";
    }
    echo "</table></section>";
}

function destekleriGoster()
{
    $kayitlar = listele("SELECT * FROM support_tickets ORDER BY id DESC");
    echo "<section class='admin-liste tek'><h2>Destek Talepleri</h2><table><tr><th>ID</th><th>Ad Soyad</th><th>Konu</th><th>Durum</th><th>Detay</th></tr>";
    foreach ($kayitlar as $satir) {
        echo "<tr><td>" . temizle($satir["id"]) . "</td><td>" . temizle($satir["full_name"]) . "</td><td>" . temizle($satir["subject"]) . "</td>";
        echo "<td><form method='post'><input type='hidden' name='islem' value='destek_durum'><input type='hidden' name='id' value='" . temizle($satir["id"]) . "'><select name='durum'>";
        foreach (array("Yeni", "İnceleniyor", "Tamamlandı") as $durum) {
            $secildi = ($satir["status"] == $durum) ? "selected" : "";
            echo "<option $secildi>$durum</option>";
        }
        echo "</select><button>Kaydet</button></form></td><td>" . temizle($satir["details"]) . "</td></tr>";
    }
    echo "</table></section>";
}

$girisHatasi = girisKontrol();
$bolum = $_GET["bolum"] ?? "panel";
$bolum = preg_replace("/[^a-z_]/", "", strtolower($bolum));
kayitIslemleri($bolum);
destekDurumGuncelle();
$dbVarMi = baglan() ? true : false;
$tumBolumler = bolumler();
?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Paneli - <?php echo temizle($ogrenciNo); ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="admin-body">
<?php if (!$dbVarMi) { ?>
    <main class="giris">
        <section class="giris-kutu">
            <h1>Veritabanı bağlantısı yok</h1>
            <p>MySQL çalıştırılıp SQL dosyası import edilmelidir.</p>
        </section>
    </main>
<?php } elseif (!girisYapildiMi()) { ?>
    <main class="giris">
        <form method="post" class="giris-kutu">
            <input type="hidden" name="giris_formu" value="1">
            <h1>Admin Girişi</h1>
            <p><?php echo temizle($ogrenciAdi); ?> - <?php echo temizle($ogrenciNo); ?></p>
            <?php if ($girisHatasi != "") echo "<div class='mesaj'>" . temizle($girisHatasi) . "</div>"; ?>
            <label>Kullanıcı Adı<input name="kullanici_adi" required></label>
            <label>Şifre<input name="sifre" type="password" required></label>
            <button>Giriş Yap</button>
            <small>mehmet / 24660210054</small>
        </form>
    </main>
<?php } else { ?>
    <div class="admin-sayfa">
        <aside class="admin-menu">
            <a class="logo" href="admin.php"><img src="assets/img/logo.svg" alt=""> Admin</a>
            <nav>
                <a href="admin.php?bolum=panel">Özet</a>
                <a href="admin.php?bolum=menus">Site Haritası</a>
                <?php foreach ($tumBolumler as $anahtar => $ayar) { ?>
                    <a href="admin.php?bolum=<?php echo temizle($anahtar); ?>"><?php echo temizle($ayar["baslik"]); ?></a>
                <?php } ?>
                <a href="admin.php?bolum=contacts">İletişim Mesajları</a>
                <a href="admin.php?bolum=careers">Kariyer Başvuruları</a>
                <a href="admin.php?bolum=support">Destek Talepleri</a>
            </nav>
            <a class="cikis" href="admin.php?cikis=1">Çıkış</a>
        </aside>

        <main class="admin-icerik">
            <header class="admin-ust">
                <div><span>Giriş yapan</span><b><?php echo temizle($_SESSION["admin_ad"]); ?></b></div>
                <a href="index.php?sayfa=ana-sayfa">Siteyi Aç</a>
            </header>
            <?php
            mesajYaz();
            if ($bolum == "panel") panelOzeti();
            elseif ($bolum == "menus") menuListesi();
            elseif (isset($tumBolumler[$bolum])) duzenlemeEkrani($bolum, $tumBolumler[$bolum]);
            elseif ($bolum == "contacts") tabloGoster("İletişim Mesajları", "contact_messages", array("full_name", "email", "subject", "message", "created_at"));
            elseif ($bolum == "careers") tabloGoster("Kariyer Başvuruları", "career_applications", array("full_name", "email", "phone", "position", "message", "created_at"));
            elseif ($bolum == "support") destekleriGoster();
            else panelOzeti();
            ?>
        </main>
    </div>
<?php } ?>
</body>
</html>
