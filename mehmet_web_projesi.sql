CREATE DATABASE IF NOT EXISTS `mehmet_web_projesi` CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;
USE `mehmet_web_projesi`;

DROP TABLE IF EXISTS `support_tickets`;
DROP TABLE IF EXISTS `contact_messages`;
DROP TABLE IF EXISTS `career_applications`;
DROP TABLE IF EXISTS `faqs`;
DROP TABLE IF EXISTS `media`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `references`;
DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `services`;
DROP TABLE IF EXISTS `pages`;
DROP TABLE IF EXISTS `menus`;
DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `title` varchar(160) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `content_type` varchar(50) NOT NULL,
  `content_slug` varchar(180) DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(180) NOT NULL,
  `title` varchar(180) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `side_note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(180) NOT NULL,
  `category` varchar(120) NOT NULL,
  `title` varchar(180) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `service_code` varchar(40) NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(180) NOT NULL,
  `title` varchar(180) NOT NULL,
  `status` varchar(80) NOT NULL,
  `sector` varchar(120) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `references` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(180) NOT NULL,
  `ref_type` varchar(120) NOT NULL,
  `sector` varchar(120) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(180) NOT NULL,
  `post_type` varchar(40) NOT NULL,
  `category` varchar(120) NOT NULL,
  `title` varchar(180) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `published_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `media` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(180) NOT NULL,
  `media_type` varchar(40) NOT NULL,
  `url` varchar(255) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `career_applications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(160) NOT NULL,
  `email` varchar(160) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `position` varchar(140) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `contact_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(160) NOT NULL,
  `email` varchar(160) NOT NULL,
  `subject` varchar(180) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

CREATE TABLE `support_tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(160) NOT NULL,
  `email` varchar(160) NOT NULL,
  `phone` varchar(60) NOT NULL,
  `company` varchar(160) DEFAULT NULL,
  `priority` varchar(40) NOT NULL,
  `subject` varchar(180) NOT NULL,
  `details` text NOT NULL,
  `status` varchar(40) NOT NULL DEFAULT 'Yeni',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

INSERT INTO `admin_users` VALUES (1, 'mehmet', '24660210054', 'MEHMET UĞURLUAKDOĞAN');

INSERT INTO `menus` VALUES
(1,NULL,'Ana Sayfa','ana-sayfa','home','ana-sayfa',1,1),
(2,NULL,'Kurumsal','kurumsal','page','kurumsal',2,1),
(3,2,'Hakkımızda','hakkimizda','page','hakkimizda',1,1),
(4,3,'Tarihçe','tarihce','page','tarihce',1,1),
(5,3,'Misyon','misyon','page','misyon',2,1),
(6,3,'Vizyon','vizyon','page','vizyon',3,1),
(7,2,'Ekibimiz','ekibimiz','page','ekibimiz',2,1),
(8,7,'Yönetim Kadrosu','yonetim-kadrosu','page','yonetim-kadrosu',1,1),
(9,7,'Uzmanlarımız','uzmanlarimiz','page','uzmanlarimiz',2,1),
(10,2,'Sertifikalarımız ve Kalite Politikamız','sertifikalarimiz-ve-kalite-politikamiz','page','sertifikalarimiz-ve-kalite-politikamiz',3,1),
(11,2,'Kariyer','kariyer','career','kariyer',4,1),
(12,NULL,'Çözümlerimiz & Hizmetlerimiz','cozumlerimiz-hizmetlerimiz','services','tum-hizmetler',3,1),
(13,12,'Bireysel Hizmetler','bireysel-hizmetler','services','Bireysel Hizmetler',1,1),
(14,13,'Hizmet Detayı 1','hizmet-detayi-1','service_detail','hizmet-detayi-1',1,1),
(15,13,'Hizmet Detayı 2','hizmet-detayi-2','service_detail','hizmet-detayi-2',2,1),
(16,12,'Kurumsal Danışmanlık','kurumsal-danismanlik','services','Kurumsal Danışmanlık',2,1),
(17,16,'Hizmet Detayı 3','hizmet-detayi-3','service_detail','hizmet-detayi-3',1,1),
(18,16,'Hizmet Detayı 4','hizmet-detayi-4','service_detail','hizmet-detayi-4',2,1),
(19,NULL,'Çalışmalarımız','calismalarimiz','projects','tum-projeler',4,1),
(20,19,'Referanslarımız','referanslarimiz','references','tum-referanslar',1,1),
(21,20,'Sektörel Referanslar','sektorel-referanslar','references','Sektörel Referans',1,1),
(22,20,'Kurumsal Çözüm Ortakları','kurumsal-cozum-ortaklari','references','Kurumsal Çözüm Ortağı',2,1),
(23,19,'Tamamlanan Projeler','tamamlanan-projeler','projects','Tamamlanan',2,1),
(24,19,'Devam Eden Projeler','devam-eden-projeler','project_gallery','Devam Eden',3,1),
(25,NULL,'Medya ve Bilgi Merkezi','medya-ve-bilgi-merkezi','media_center','medya',5,1),
(26,25,'Blog','blog','blog','tum-blog',1,1),
(27,26,'Sektörel Haberler','sektorel-haberler','blog','Sektörel Haberler',1,1),
(28,26,'İpuçları ve Rehberler','ipuclari-ve-rehberler','blog','İpuçları ve Rehberler',2,1),
(29,25,'Video Galeri','video-galeri','videos','Video',2,1),
(30,25,'Duyurular','duyurular','announcements','Duyuru',3,1),
(31,25,'Sıkça Sorulan Sorular','sss','faqs','sss',4,1),
(32,NULL,'İletişim','iletisim','contact','iletisim',6,1),
(33,32,'İletişim Bilgilerimiz','iletisim-bilgilerimiz','contact','iletisim',1,1),
(34,32,'Müşteri Destek Talebi','musteri-destek-talebi','support','destek',2,1);

INSERT INTO `pages` (`slug`,`title`,`summary`,`content`,`side_note`) VALUES
('kurumsal','Kurumsal','Uğurlu Yazılım Ajansı yazılım ve web çözümleri üretir.','Ajansımız web sitesi, içerik yönetimi, müşteri destek talebi ve proje tanıtımı gibi alanlarda örnek çözümler üretir. Bu proje ders ödevi için hazırlanmıştır.','Hazırlayan: MEHMET UĞURLUAKDOĞAN - 24660210054'),
('hakkimizda','Hakkımızda','Web ve yazılım işleri yapan örnek bir ajansız.','Uğurlu Yazılım Ajansı küçük işletmeler için web sitesi, blog, galeri ve iletişim formları hazırlayan örnek bir yazılım ajansıdır.','İçerikler veritabanından gelir.'),
('tarihce','Tarihçe','Ajans fikri web projeleri üzerine kurulmuştur.','2024 yılında küçük web işleri ile başlayan ajans fikri, 2026 yılında yönetilebilir kurumsal site yapısına dönüşmüştür.','Bu bilgiler örnek proje senaryosudur.'),
('misyon','Misyon','Kullanımı kolay ve anlaşılır web çözümleri yapmak.','Misyonumuz işletmelerin web üzerindeki tanıtım, iletişim ve destek süreçlerini kolaylaştırmaktır.','Admin panel ile içerik yönetilir.'),
('vizyon','Vizyon','Yerel işletmeler için güvenilir yazılım desteği sunmak.','Vizyonumuz Mersin ve çevresindeki işletmelere anlaşılır, sade ve çalışır web çözümleri hazırlamaktır.','Proje PHP ve MySQL kullanır.'),
('ekibimiz','Ekibimiz','Ekibimiz farklı görevlerden oluşur.','Ekipte proje sorumlusu, web geliştirici, içerik editörü ve destek sorumlusu gibi roller yer alır.','Örnek ekip yapısıdır.'),
('yonetim-kadrosu','Yönetim Kadrosu','Yönetim kadrosu proje sürecini takip eder.','Yönetim kadrosu müşteri görüşmesi, proje planı, içerik kontrolü ve teslim süreçleri ile ilgilenir.','Kurumsal alt menüdür.'),
('uzmanlarimiz','Uzmanlarımız','Uzmanlarımız web ve veritabanı alanında çalışır.','Uzmanlarımız PHP, MySQL, arayüz tasarımı ve form işlemleri üzerinde çalışan kişiler olarak kurgulanmıştır.','Ekibimiz alt menüsüdür.'),
('sertifikalarimiz-ve-kalite-politikamiz','Sertifikalarımız ve Kalite Politikamız','Kalite politikamız çalışır ve anlaşılır proje teslim etmektir.','Projelerde düzgün çalışan formlar, doğru veritabanı bağlantısı ve sade arayüz kullanılmasına dikkat edilir.','Ödev kriterlerine uygun hazırlanmıştır.'),
('kariyer','Kariyer','İş başvurusu yapmak isteyenler formu doldurabilir.','Kariyer alanında adaylar ad soyad, e-posta, telefon, pozisyon ve açıklama bilgilerini gönderir.','Başvurular admin panelde görünür.'),
('iletisim','İletişim Bilgilerimiz','Bize iletişim formu üzerinden ulaşabilirsiniz.','Telefon: 0(324) 123 45 67. Adres: Mersin Üniversitesi Mersin Meslek Yüksekokulu Uzaktan Eğitim. Bu telefon gerçek değildir, ödev için örnek olarak yazılmıştır.','Harita ve iletişim formu bu sayfadadır.');

INSERT INTO `services` (`slug`,`category`,`title`,`summary`,`content`,`service_code`,`sort_order`) VALUES
('hizmet-detayi-1','Bireysel Hizmetler','Kişisel Tanıtım Sitesi','Öğrenci ve bireysel kullanıcılar için tanıtım sitesi.','Kişisel bilgiler, projeler ve iletişim formu bulunan sade web sitesi hazırlanır.','BH-01',1),
('hizmet-detayi-2','Bireysel Hizmetler','Blog Kurulumu','Yazı paylaşmak isteyenler için blog yapısı.','Kategori, yazı ve duyuru mantığı olan yönetilebilir blog alanı hazırlanır.','BH-02',2),
('hizmet-detayi-3','Kurumsal Danışmanlık','Kurumsal Web Sitesi','Firmalar için yönetilebilir kurumsal site.','Hakkımızda, hizmetler, referanslar, projeler ve iletişim sayfaları olan site hazırlanır.','KD-01',1),
('hizmet-detayi-4','Kurumsal Danışmanlık','Destek Talebi Sistemi','Müşteri taleplerini kaydeden form sistemi.','Müşteriler destek talebi gönderir, admin panelinden durum takibi yapılır.','KD-02',2);

INSERT INTO `projects` (`slug`,`title`,`status`,`sector`,`summary`,`content`,`image_path`,`sort_order`) VALUES
('klinik-web','Klinik Web Sitesi','Tamamlanan','Sağlık','Klinik için kurumsal web sitesi.','Hizmet sayfaları, iletişim formu ve duyuru alanı hazırlanmıştır.','assets/img/proje.svg',1),
('lojistik-panel','Lojistik İçerik Paneli','Tamamlanan','Lojistik','Lojistik firması için içerik paneli.','Firma içerikleri ve referansları yönetilebilir hale getirilmiştir.','assets/img/proje.svg',2),
('galeri-projesi','Galeri Yapısı','Devam Eden','Tasarım','Devam eden projeler için galeri alanı.','Görsel galeri ve proje açıklamaları üzerinde çalışılmaktadır.','assets/img/proje.svg',3),
('destek-sistemi','Destek Talebi Sistemi','Devam Eden','Teknoloji','Müşteri destek talepleri için sistem.','Formdan gelen talepler admin panelinde listelenmektedir.','assets/img/proje.svg',4);

INSERT INTO `references` (`title`,`ref_type`,`sector`,`summary`,`sort_order`) VALUES
('Akdeniz Klinik','Sektörel Referans','Sağlık','Kurumsal web sitesi çalışması yapılmıştır.',1),
('Liman Lojistik','Sektörel Referans','Lojistik','İçerik yönetimi ve referans alanı hazırlanmıştır.',2),
('Mersin Kreatif Studio','Kurumsal Çözüm Ortağı','Tasarım','Görsel içerik desteği sağlayan çözüm ortağıdır.',3),
('Toros Veri Danışmanlığı','Kurumsal Çözüm Ortağı','Teknoloji','Veritabanı ve analiz konusunda destek verir.',4);

INSERT INTO `posts` (`slug`,`post_type`,`category`,`title`,`summary`,`content`,`published_at`) VALUES
('web-sitesi-guncel-kalmali','Blog','Sektörel Haberler','Web Sitesi Neden Güncel Kalmalı?','Güncel web sitesi kullanıcı güvenini artırır.','Firmaların web sitelerinde hizmet bilgileri ve iletişim bilgileri güncel olmalıdır.','2026-05-10'),
('php-mysql-form','Blog','İpuçları ve Rehberler','PHP MySQL Form Kullanımı','Form kayıtları veritabanına güvenli şekilde eklenmelidir.','Bu projede form bilgileri prepared statement ile veritabanına kaydedilir.','2026-05-12'),
('destek-talebi-acildi','Duyuru','Duyuru','Destek Talebi Açıldı','Müşteri destek talebi formu aktif edildi.','Ziyaretçiler destek taleplerini form üzerinden gönderebilir.','2026-05-15'),
('kariyer-basvurulari','Duyuru','Duyuru','Kariyer Başvuruları Açıldı','İş başvuru formu aktif edildi.','Başvurular admin panelinde görüntülenebilir.','2026-05-16');

INSERT INTO `media` (`title`,`media_type`,`url`,`summary`,`sort_order`) VALUES
('Ajans Tanıtım Videosu','Video','https://www.youtube.com/embed/dQw4w9WgXcQ','Örnek tanıtım videosu.',1),
('Panel Kullanım Videosu','Video','https://www.youtube.com/embed/dQw4w9WgXcQ','Admin panel kullanım videosu.',2);

INSERT INTO `faqs` (`question`,`answer`,`sort_order`) VALUES
('Bu projede kaç PHP dosyası var?','Projede sadece index.php ve admin.php dosyaları vardır.',1),
('Admin kullanıcı adı ve şifre nedir?','Kullanıcı adı mehmet, şifre 24660210054.',2),
('Telefon gerçek mi?','Hayır. Telefon bilgisi ödev şartına uygun olarak gerçek olmayan örnek numaradır.',3),
('Hazır tema kullanıldı mı?','Hayır. Stil dosyası özel olarak yazılmıştır.',4);
