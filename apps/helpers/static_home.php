<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Welcome :: Subsite Direktorat PMPU BPOM</title>
    <!-- Stylesheets -->
    <link href="<?=base_url()?>assets/globex/css/bootstrap.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/globex/css/style.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/globex/css/responsive.css" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&amp;family=Nunito+Sans:wght@300;600;700;800;900&amp;display=swap"
        rel="stylesheet">

    <!-- Color Switcher Mockup -->
    <link href="<?=base_url()?>assets/globex/css/color-switcher-design.css" rel="stylesheet">


    <!-- Color Themes -->
    <link id="theme-color-file" href="<?=base_url()?>assets/globex/css/color-themes/default-theme.css" rel="stylesheet">
    <link id="theme-color-file" href="<?=base_url()?>assets/globex/css/datatable.css" rel="stylesheet">

    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <link rel="icon" href="<?=base_url()?>assets/globex/images/favicon.png" type="image/x-icon">

    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <script>
    let base = '<?= base_url() ?>'
    </script>
    <script>
    let url = '<?= $this->uri->segment(3) ?>'
    </script>
    <!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script><![endif]-->
    <!--[if lt IE 9]><script src="js/respond.js"></script><![endif]-->


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-C1QBRRVVN1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-C1QBRRVVN1');
    </script>

</head>

<body class="hidden-bar-wrapper">
    <script src="<?=base_url()?>assets/globex/js/jquery.js"></script>
    <script src="<?=base_url()?>assets/globex/js/datatables.min.js"></script>
    <link href="<?=base_url()?>assets/js/swal/sweetalert.css" rel="stylesheet">
    <link href="<?=base_url()?>assets/js/swal/bootstrap-sweetalert.js" rel="stylesheet">
    <link href="<?=base_url()?>assets/js/swal/sweetalert.js" rel="stylesheet">
    <?php $url = $this->uri->segment(1)?>
    <div class="page-wrapper">
        <?php 
    $ip    = $this->input->ip_address(); // Mendapatkan IP user
        $date  = date("Y-m-d"); // Mendapatkan tanggal sekarang
        $waktu = time(); //
        $timeinsert = date("Y-m-d H:i:s");
        $s = $this->db->query("SELECT * FROM pmpu_visitor WHERE ip='".$ip."' AND date='".$date."'")->num_rows();
        $ss = isset($s)?($s):0;
        if($ss == 0){
            $data = ['ip' => $ip,
                     'date'=> $date,
                     'hits' => 1,
                     'online' => $waktu,
                     'time'=> $timeinsert];
            $this->db->insert('pmpu_visitor', $data);
            
        }else{
            $this->db->query("UPDATE pmpu_visitor SET hits=hits+1, online='".$waktu."' WHERE ip='".$ip."' AND date='".$date."'");
        }
        $pengunjunghariini  = $this->db->query("SELECT * FROM pmpu_visitor WHERE date='".$date."' GROUP BY ip")->num_rows();
        $dbpengunjung = $this->db->query("SELECT COUNT(hits) as hits FROM pmpu_visitor")->row(); 

        $totalpengunjung = isset($dbpengunjung->hits)?($dbpengunjung->hits):0; 
        $bataswaktu = time() - 300;
        $pengunjungonline  = $this->db->query("SELECT * FROM pmpu_visitor WHERE online > '".$bataswaktu."'")->num_rows();

    
    ?>
        <!-- Preloader -->
        <div class="preloader"></div>

        <!-- Main Header-->
        <header class="main-header header-style-three">

            <!-- Header Top Two -->
            <div class="header-top-two">
                <div class="outer-container">
                    <div class="clearfix">

                        <!-- Top Left -->
                        <div class="top-left clearfix">
                            <!-- Info List -->
                            <ul class="info-list">
                                <li>Subsite Direktorat Pemberdayaan Masyarakat dan Pelaku Usaha Pangan Olahan<strong><a
                                            href="#"></a>BPOM RI</strong></li>
                            </ul>
                        </div>

                        <!-- Top Right -->
                        <div class="top-right pull-right clearfix">
                            <!-- Social Box -->
                            <ul class="social-box">
                                <li><a href="<?= base_url('login')  ?>"><span class="fa fa-sign-in"></span> Login</a>
                                </li>
                                <!-- <li><a href="<?= base_url('Home/peta_situs')  ?>"><span class="fa fa-dribbble"></span> Peta Situs</a></li> -->
                                <!--<li><a href="direktoratpmpu@pom.go.id"><span class="icon flaticon-email"></span> direktoratpmpu@pom.go.id</a></li>-->
                                <li><a href="tel:+6221 - 42878701"><span class="icon flaticon-telephone"></span> +6221 -
                                        42878701</a></li>
                                <li><a href="https://web.facebook.com/ditpmpupo" target="_blank"
                                        class="fa fa-facebook-f"></a></li>
                                <li><a href="https://www.instagram.com/ditpmpu_po" target="_blank"
                                        class="fa fa-instagram"></a></li>
                                <!-- <li><a href="<?= base_url('Not_Found'); ?>" class="fa fa-google"></a></li> -->
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <!--Header-Upper-->
            <div class="header-upper">
                <div class="auto-container">
                    <div class="clearfix">

                        <div class="pull-left logo-box">
                            <div class="logo"><a href="<?= base_url('')?>"><img width="220px"
                                        src="<?=base_url()?>assets/globex/images/BPOM/logo_bpom.png" alt=""
                                        title=""></a>

                            </div>
                        </div>

                        <div class="pull-right upper-right clearfix">

                            <!--Info Box-->
                            <div class="upper-column info-box">
                                <div class="icon-box"><span class="flaticon-pin"></span></div>
                                <ul>
                                    <li><strong>Alamat</strong></li>
                                    <li>Jalan Percetakan Negara Nomor 23 <br>Jakarta - 10560 - Indonesia</li>
                                </ul>
                            </div>

                            <!--Info Box-->
                            <div class="upper-column info-box">
                                <div class="icon-box"><span class="flaticon-email-1"></span></div>
                                <ul>
                                    <li><strong>E-Mail</strong></li>
                                    <li>direktoratpmpu@pom.go.id</li>
                                </ul>
                            </div>
                            <!--Info Box-->
                            <div class="upper-column info-box">
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!--End Header Upper-->

            <!--Header Lower-->
            <div class="header-lower">

                <div class="auto-container clearfix">
                    <div class="nav-outer clearfix">

                        <!-- Grid Box -->
                        <div class="grid-box navSidebar-button">
                            <a href="#" class="icon flaticon-menu-2"></a>
                        </div>
                        <!-- End Grid Box -->

                        <!-- Mobile Navigation Toggler -->
                        <div class="mobile-nav-toggler"><span class="icon flaticon-menu-2"></span></div>
                        <!-- Main Menu -->
                        <nav class="main-menu navbar-expand-md">
                            <div class="navbar-header">
                                <!-- Toggle Button -->
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="navbar-collapse collapse clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix mr-5">
                                    <li class="dropdown"><a href="#">Profil</a>
                                        <ul>
                                            <li><a href="<?= base_url('latarbelakang'); ?>">Latar belakang</a></li>
                                            <li><a href="<?= base_url('tupoksi'); ?>">Tupoksi</a></li>
                                            <li><a href="<?=base_url('visi-misi-motto');?>">Visi Misi</a></li>
                                            <li><a href="<?=base_url('profil-penghargaan');?>">Penghargaan</a></li>
                                            <li><a href="<?=base_url('quickwin');?>">Quick Win</a></li>
                                            <li><a href="<?= base_url('struktur-organisasi'); ?>">Struktur
                                                    Organisasi</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#">Program</a>
                                        <ul>
                                            <li><a href="<?= base_url('germas'); ?>">Germas SAPA</a></li>
                                            <li><a href="<?= base_url('peta-integrasi'); ?>">Peta Integrasi</a></li>
                                            <li><a href="<?= base_url('integrasi-data') ?>">Integrasi Data</a></li>
                                            <li><a href="https://gkpd.pom.go.id" target="_blank">Desa Pangan Aman</a>
                                            </li>
                                            <li><a href="https://siapsapa.pom.go.id" target="_blank">Pangan Jajanan Anak
                                                    Sekolah Aman</a></li>
                                            <li><a href="https://puspaman.pom.go.id" target="_blank">Pasar Pangan Aman
                                                </a></li>
                                            <li><a href="https://istanaumkm.pom.go.id/id" target="_blank">Usaha Mikro
                                                    Kecil dan Menengah</a></li>
                                        </ul>
                                    </li>
                                    <li class="dropdown"><a href="#">Zona Integritas</a>
                                        <ul>
                                            <li><a href="<?= base_url('program-manajemen-perubahan'); ?>">Manajemen
                                                    Perubahan</a></li>
                                            <li class="dropdown"><a href="#">Tata Laksana</a>
                                                <ul>
                                                    <li><a href="<?= base_url('sistem-sertifikat'); ?>">Sistem Manajemen
                                                            Mutu</a></li>
                                                    <!-- <li><a href="<?= base_url('keterbukaan-dasar-hukum-ppid'); ?>">Keterbukaan
                                                            Informasi Publik</a></li> -->
                                                    <li><a href="https://ppid.pom.go.id" target="_blank">Keterbukaan
                                                            Informasi Publik</a></li>
                                                    <li><a href="<?= base_url('monev-pengukuran-kinerja'); ?>">Monev
                                                            Pemanfaatan IT</a></li>
                                                </ul>
                                            </li>
                                            <li class="dropdown"><a href="#">Akuntabilitas</a>
                                                <ul>
                                                    <li><a href="<?= base_url('perencanaan'); ?>">Perencanaan dan Target
                                                            Kinerja</a></li>
                                                    <li><a href="<?= base_url('data-perbulan'); ?>">Data Capaian</a>
                                                    </li>
                                                    <li><a href="<?= base_url('lapkin'); ?>">Laporan Kinerja</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="<?= base_url('sdm-profil-pegawai'); ?>">SDM</a></li>
                                            <li><a href="<?= base_url('pengawasan-wbs'); ?>">Pengawasan</a></li>
                                        </ul>
                                    </li>
                                    <li class="<?= $url == 'layanan' ? 'current' : '' ?> dropdown"><a href="#">Layanan
                                            Publik</a>
                                        <ul>
                                            <li><a href="<?= base_url('jadwal-layanan'); ?>">Jadwal Layanan</a></li>
                                            <li><a href="<?= base_url('media-gambar'); ?>">Media Informasi</a></li>
                                            <li><a href="<?= base_url('formulir-konsultasi'); ?>">Konsultasi</a></li>
                                            <li><a href="<?= base_url('yanblik-faq'); ?>">FAQ</a></li>
                                            <li><a href="<?= base_url('perpustakaan-ebook'); ?>">Perpustakaan Online</a>
                                            </li>
                                            <li class="dropdown"><a href="#">Standar Pelayanan</a>
                                                <ul>
                                                    <li><a href="<?= base_url('sk_juknis'); ?>">Kebijakan</a></li>
                                                    <li><a href="<?= base_url('sk-tim-pelaksana'); ?>">SOP Pelayanan</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="dropdown"><a href="#">Budaya Pelayanan Prima</a>
                                                <ul>
                                                    <li><a href="<?= base_url('kapasiti-building'); ?>">Capacity
                                                            Building</a></li>
                                                    <li><a href="<?= base_url('punishment-kode-etik'); ?>">Reward
                                                            Punishment</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="<?= base_url('event'); ?>">Event</a></li>
                                    <li class="dropdown"><a href="#">Pengaduan</a>
                                        <ul>
                                            <li><a href="<?= base_url('kontak-kami'); ?>">Kontak Kami</a></li>
                                            <li><a href="<?= base_url('formulir-pengaduan'); ?>">Formulir Pengaduan</a>
                                            </li>
                                            <li><a href="<?= base_url('tindak-lanjut'); ?>">Tindak Lanjut</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>

                            <!--Search Box-->
                            <div class="search-box-outer">
                                <div class="search-box-btn"><span class="fa fa-search"></span></div>
                            </div>
                        </nav>
                        <!-- Main Menu End-->

                        <!-- Options Box -->
                        <div class="options-box clearfix">
                            <div class="option-inner">
                                <span class="icon flaticon-telephone"></span>
                                <div class="number"><span>Layanan Online &nbsp;&nbsp;&nbsp;</span><a
                                        href="tel: 1-500-533"> 1-500-533</a></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End Header Lower -->

            <!-- Sticky Header  -->
            <div class="sticky-header">
                <div class="auto-container clearfix">
                    <!--Logo-->
                    <div class="logo pull-left">
                        <a href="<?= base_url('')?>"><img width="220px"
                                src="<?=base_url()?>assets/globex/images/BPOM/logo_bpom.png" alt="" title=""></a>
                    </div>
                    <!--Right Col-->
                    <div class="pull-right">
                        <!-- Main Menu -->
                        <nav class="main-menu">
                            <!--Keep This Empty / Menu will come through Javascript-->
                        </nav><!-- Main Menu End-->

                    </div>
                </div>
            </div><!-- End Sticky Menu -->

            <!-- Mobile Menu  -->
            <div class="mobile-menu">
                <div class="menu-backdrop"></div>
                <div class="close-btn"><span class="icon flaticon-multiply"></span></div>

                <nav class="menu-box">
                    <div class="nav-logo"><a href="<?= base_url('')?>"><img
                                src="<?=base_url()?>assets/globex/images/BPOM/logo_bpom.png" alt="" title=""></a></div>
                    <div class="menu-outer">
                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                    </div>
                </nav>
            </div><!-- End Mobile Menu -->

        </header>
        <!-- End Main Header -->

        <!-- Sidebar Cart Item -->
        <div class="xs-sidebar-group info-group">
            <div class="xs-overlay xs-bg-black"></div>
            <div class="xs-sidebar-widget">
                <div class="sidebar-widget-container">
                    <div class="widget-heading">
                        <a href="#" class="close-side-widget">
                            X
                        </a>
                    </div>
                    <div class="sidebar-textwidget">

                        <!-- Sidebar Info Content -->
                        <div class="sidebar-info-contents">
                            <div class="content-inner">
                                <div class="logo">
                                    <a href="<?= base_url('')?>"><img
                                            src="<?=base_url()?>assets/globex/images/BPOM/logo_bpom.png" alt=""
                                            title=""></a>
                                </div>
                                <div class="content-box">
                                    <h2>Tentang Kami</h2>
                                    <p class="text">Subsite ini merupakan Subsite Direktorat Pemberdayaan Masyarakat dan
                                        Pelaku Usaha Pangan Olahan (PMPUPO) Badan POM RI yang mengintegrasikan Program
                                        Desa Pangan Aman, Pasar Pangan Aman Berbasis Komunitas, dan Pangan Jajanan Anak
                                        Sekolah berbasis data terpadu. Selain itu sebagai bentuk transparansi dalam
                                        rangka mewujudkan pemerintahan yang bersih dan melayani.</p>
                                </div>
                                <div class="contact-info">
                                    <h2>Contact Info</h2>
                                    <ul class="list-style-one">
                                        <li><span class="icon fa fa-location-arrow"></span>Jalan Percetakan Negara Nomor
                                            23 Jakarta - 10560 - Indonesia</li>
                                        <li><span class="icon fa fa-phone"></span>+6221 - 42878701</li>
                                        <li><span class="icon fa fa-envelope"></span>direktoratpmpu@pom.go.id</li>
                                    </ul>
                                </div>
                                <!-- Social Box -->
                                <ul class="social-box">
                                    <li><a href="https://web.facebook.com/ditpmpupo" target="_blank"
                                            class="fa fa-facebook-f"></a></li>
                                    <li><a href="https://www.instagram.com/ditpmpu_po/" target="_blank"
                                            class="fa fa-instagram"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END sidebar widget item -->

            <?php echo $contents; ?>

            <!-- Main Footer -->
            <footer class="main-footer style-three">
                <div class="pattern-layer-three"></div>
                <div class="pattern-layer-four"></div>
                <!--Waves end-->
                <div class="auto-container">
                    <!--Widgets Section-->
                    <div class="widgets-section">
                        <div class="row clearfix">

                            <!-- Footer Column -->
                            <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                                <div class="footer-widget logo-widget">
                                    <h5>Tentang Kami</h5>
                                    <div class="text" style="text-align:justify;">Subsite ini merupakan Subsite
                                        Direktorat Pemberdayaan Masyarakat dan Pelaku Usaha Pangan Olahan (PMPUPO) Badan
                                        POM RI yang mengintegrasikan Program Desa Pangan Aman, Pasar Pangan Aman
                                        Berbasis Komunitas, dan Pangan Jajanan Anak Sekolah berbasis data terpadu.
                                        Selain itu Subsite ini juga sebagai bentuk transparansi dalam rangka mewujudkan
                                        pemerintahan yang bersih dan melayani.</div>
                                </div>
                            </div>

                            <!-- Footer Column -->
                            <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                                <div class="footer-widget links-widget">
                                    <h5>Quick Links</h5>
                                    <ul class="list-link">
                                        <li><a href="<?= base_url('germas'); ?>">Germas SAPA</a></li>
                                        <li><a href="<?= base_url('akuntabilitas'); ?>">Akuntabilitas</a></li>
                                        <li><a href="<?= base_url('perpustakaan-ebook'); ?>">Perpustakaan Online</a>
                                        </li>
                                        <li><a href="<?= base_url('peta-integrasi'); ?>">Peta Integrasi</a></li>
                                    </ul>
                                </div>
                            </div>


                            <div class="footer-column col-lg-3 col-md-6 col-sm-12">
                                <div class="footer-widget links-widget">
                                    <h5>Pengunjung</h5>
                                    <ul class="list-link">
                                        <li class="text-light">Pengunjung Hari ini : <?= $pengunjunghariini ?> orang
                                        </li>
                                        <li class="text-light">Total Pengunjung : <?= $totalpengunjung ?> orang</li>
                                        <li class="text-light">Pengunjung Online : <?= $pengunjungonline ?> orang</li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <!-- Footer Bottom -->
                <div class="footer-bottom">
                    <div class="auto-container">
                        <div class="row clearfix">
                            <!-- Column -->
                            <div class="column col-lg-8 col-md-12 col-sm-12">
                                <div class="copyright">Copyright &copy; <?= date('Y'); ?> Direktorat Pemberdayaan
                                    Masyarakat dan Pelaku Usaha Pangan Olahan - BPOM RI. All Right Reserved.</div>
                            </div>
                            <!-- Column -->
                            <div class="column col-lg-4 col-md-12 col-sm-12">
                                <ul class="footer-nav">
                                    <li><a href="<?= base_url('event'); ?>">Event</a></li>
                                    <li><a href="<?= base_url('kontak-kami'); ?>">Kontak Kami</a></li>
                                    <!-- <li><a href="<?= base_url('Home/peta_situs'); ?>">Peta Situs</a></li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </footer>


        </div>
        <!--End pagewrapper-->



        <!-- Search Popup -->
        <div class="search-popup">
            <button class="close-search style-two"><span class="flaticon-multiply"></span></button>
            <button class="close-search"><span class="flaticon-up-arrow-1"></span></button>
            <form method="post" action="https://expert-themes.com/html/globex/blog.html">
                <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="Search Here" required="">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <!-- End Header Search -->

        <!--Scroll to top-->
        <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-arrow-up"></span></div>

        <script src="<?=base_url()?>assets/globex/js/popper.min.js"></script>
        <script src="<?=base_url()?>assets/globex/js/bootstrap.min.js"></script>
        <script src="<?=base_url()?>assets/globex/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script src="<?=base_url()?>assets/globex/js/jquery.fancybox.js"></script>
        <script src="<?=base_url()?>assets/globex/js/appear.js"></script>
        <script src="<?=base_url()?>assets/globex/js/mixitup.js"></script>
        <script src="<?=base_url()?>assets/globex/js/parallax.min.js"></script>
        <script src="<?=base_url()?>assets/globex/js/tilt.jquery.min.js"></script>
        <script src="<?=base_url()?>assets/globex/js/jquery.paroller.min.js"></script>
        <script src="<?=base_url()?>assets/globex/js/owl.js"></script>
        <script src="<?=base_url()?>assets/globex/js/wow.js"></script>
        <script src="<?=base_url()?>assets/globex/js/nav-tool.js"></script>
        <script src="<?=base_url()?>assets/globex/js/jquery-ui.js"></script>
        <script src="<?=base_url()?>assets/globex/js/script.js"></script>
        <script src="<?=base_url()?>assets/globex/js/color-settings.js"></script>

</body>

</html>