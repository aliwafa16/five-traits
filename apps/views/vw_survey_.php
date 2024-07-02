<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Survey">
    <meta name="author" content="ACT Consulting">
    <title>Customer Experience</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="<?= ASSETS_URL; ?>images/BUMN.png" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="<?= SURVEY_URL; ?>img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="<?= SURVEY_URL; ?>img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?= SURVEY_URL; ?>img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?= SURVEY_URL; ?>img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="<?= SURVEY_URL; ?>css/animate.min.css" rel="stylesheet">
    <link href="<?= SURVEY_URL; ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= SURVEY_URL; ?>css/style.css" rel="stylesheet">
    <link href="<?= SURVEY_URL; ?>css/icon_fonts/css/all_icons_min.css" rel="stylesheet">
    <link href="<?= SURVEY_URL; ?>css/magnific-popup.min.css" rel="stylesheet">
    <link href="<?= SURVEY_URL; ?>css/skins/square/blue.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- YOUR CUSTOM CSS -->
    <link href="<?= SURVEY_URL; ?>css/custom.css" rel="stylesheet">
    <style>
        /*--------------------------------------------------------------
        # Preloader
        --------------------------------------------------------------*/
        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            overflow: hidden;
            background: #1c2954;
        }

        .controls {
            display: flex !important;
        }

        .radio {
            flex: 1 0 auto !important;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
        }

        .table {
            width: 100% !important;
            border-collapse: collapse;
            font-family: 'Poppins', sans-serif;
            border-radius: 10;
            vertical-align: middle;
        }

        .background-yellow {
            background-color: #F9D949 !important;
            color: black !important;
        }

        .background-green {
            background-color: green !important;
            color: white !important;
        }

        .background-blue {
            background-color: navy !important;
            color: white !important;
        }


        table,
        th {
            /* border: 1px solid; */
            padding: 0;
            margin: 0;
            border-style: none !important;
            /* font-size: 12px */
        }

        table tbody td {
            border-style: none !important;

        }



        /* table,
        tr,
        td {
            border: 1px solid #A3A3A3;
            padding: 0;
            margin: 0
        } */

        #preloader:before {
            content: "";
            position: fixed;
            top: calc(50% - 30px);
            left: calc(50% - 30px);
            border: 6px solid #25a0ab;
            border-top-color: #fff;
            border-bottom-color: #fff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            -webkit-animation: animate-preloader 1s linear infinite;
            animation: animate-preloader 1s linear infinite;
        }


        /* CSS ICHECK */

        /* Hide the input */
        input[type=checkbox] {
            position: absolute;
            opacity: 0;
            z-index: -1;
        }

        .check-trail {
            display: flex;
            align-items: center;
            width: 6em;
            height: 3em;
            background: #FC2947;
            border-radius: 2.5em;
            transition: all 0.5s ease;
            cursor: pointer;
        }

        .check-handler {
            display: flex;
            margin-left: 0.5em;
            justify-content: center;
            align-items: center;
            width: 2em;
            height: 2em;
            background: #D21312;
            border-radius: 50%;
            transition: all 0.5s ease;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
        }

        .check-handler:before {
            content: "×";
            color: white;
            font-size: 2em;
            font-weight: bold;
        }

        input[type=checkbox]:checked+.check-trail {
            background: #16a085;
        }

        input[type=checkbox]:checked+.check-trail .check-handler {
            margin-left: 50%;
            background: #1abc9c;
        }

        input[type=checkbox]:checked+.check-trail .check-handler::before {
            content: "✔";
        }


        #wizard_container {
            border-left: none;
        }

        .subheader {
            border-bottom: none;
        }

        #bottom-wizard {
            border-top: none;
        }


        /* // X-Small devices (portrait phones, less than 576px) */
        @media (max-width: 575.98px) {

            table tr {
                font-size: 12px !important;
                font-weight: 500 !important;
                border-style: none !important;
            }

            table tbody td {
                border-style: none !important;

            }

            .subheader {
                height: 200px;
            }

        }

        /* // Small devices (landscape phones, less than 768px) */
        /* @media (max-width: 767.98px) {
            ...
        } */

        /* // Medium devices (tablets, less than 992px) */
        /* @media (max-width: 991.98px) {
            p {
                font-size: .75em !important;
                font-weight: 500 !important;
            }

            table tr td {
                font-size: .75em !important;
                font-weight: 500 !important;
            }
        } */

        /* // Large devices (desktops, less than 1200px) */
        /* @media (max-width: 1199.98px) {
            ...
        } */

        /* // X-Large devices (large desktops, less than 1400px) */
        /* @media (max-width: 1399.98px) {
            ...
        } */

        /* // XX-Large devices (larger desktops)
        // No media query since the xxl breakpoint has no upper bound on its width */

        @-webkit-keyframes animate-preloader {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes animate-preloader {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #main_container {
            background: #1973db00 url(<?= base_url('assets/survey/img/5315093.jpg'); ?>) no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <!-- <div id="preloader"></div> -->
    <div id="loader_form">
        <div data-loader="circle-side-2"></div>
    </div><!-- /Loader_form -->

    <div id="main_container" class="visible">
        <?php
        $fsetting = json_decode($setting_survey->f_setting, true);
        $fwelcome = $fsetting['f_page_welcome']['indonesian']['content'];
        $fdemografi = $fsetting['f_page_howto']['indonesian']['content'];
        $fpersonal = json_decode($setting_survey->f_page_personal, true);
        $step1 = $fpersonal['judul']['indonesian'] . ' ' . $fpersonal['indonesian'];
        $fleaderc = json_decode($setting_survey->f_page_leaderc, true);
        $step2 = $fleaderc['judul']['indonesian'] . ' ' . $fleaderc['indonesian'];
        $fleaderd = json_decode($setting_survey->f_page_leaderd, true);
        $step3 = $fleaderd['judul']['indonesian'] . ' ' . $fleaderd['indonesian'];
        ?>


        <div class="wrapper_in">
            <div class="container-fluid">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab_1">
                        <div class="subheader" id="quote"></div>
                        <div class="row justify-content-center" id="rubah">
                            <div class="col-xl-6 col-lg-6 col-sm-12">
                                <h3 class="text-center mb-3">Motive Inventory Test</h3>
                                <div id="wizard_container">
                                    <form name="example-1" id="wrapped" method="POST">
                                        <input id="website" name="website" type="text" value="">
                                        <div id="middle-wizard">
                                            <?php
                                            // echo survey_penerimaan();
                                            // $kode = $this->uri->segment(2);
                                            // echo motive($kode);

                                            // // var_dump($sAccount . '/' . $alias . '/' . $eventId);
                                            // die;
                                            ?>

                                            <!-- START STEP DEMOGRAFY -->
                                            <div class="step">
                                                <div class="form-group row" style="margin-bottom:0px;">
                                                    <label class="col-md-4 labelme">Nama</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="f_survey_name" id="f_survey_name" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom:0px;">
                                                    <label class="col-md-4 labelme">Email <span class="text-danger">*</span></label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="f_survey_email" id="f_survey_email" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row" style="margin-bottom:0px;">
                                                    <label class="col-md-4 labelme">No Telp</label>
                                                    <div class="col-md-8">
                                                        <input type="text" name="f_survey_telp" id="f_survey_telp" class="form-control">
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group row form-lainnya" style="margin-bottom:0px;">
                                                    <div class="col-md-8 offset-md-4">
                                                        <input type="text" name="f_survey_name" id="f_survey_name" class="form-control">
                                                    </div>
                                                </div> -->
                                            </div>
                                            <!-- END STEP DEMOGRAFY -->

                                            <?php
                                            // echo survey_penerimaan($sAccount);
                                            // echo customer_experience($sAccount);
                                            $kode = $this->uri->segment(2);
                                            echo motive($kode);
                                            ?>

                                            <!-- START STEP OPEN QUESTION -->
                                            <!-- <div class="step">
                                                <div class="form-group row" style="margin-bottom:0px;">
                                                    <h3>A. Pemahaman/Memahami</h3>
                                                    <label>Hal-hal yang perlu dilakukan untuk meningkatkan pemahaman mengenai core values AKHLAK dan 18 Panduan Perilaku bagi seluruh SDM BUMN?</label>
                                                    <textarea name="a1" id="a1" class="form-control" style="height:150px;" placeholder="..."></textarea>
                                                </div>
                                                <div class="form-group row" style="margin-bottom:0px;">
                                                    <h3>B. c/Menerima</h3>
                                                    <label>Dukungan yang dibutuhkan oleh SDM BUMN agar proses internalisasi AKHLAK dan 18 Panduan Perilaku dapat berjalan secara optimal ?</label>
                                                    <textarea name="a2" id="a2" class="form-control" style="height:150px;" placeholder="..."></textarea>
                                                </div>
                                                <div class="form-group row" style="margin-bottom:0px;">
                                                    <h3>C. Penerapan</h3>
                                                    <label>Jelaskan bagaimana cara yang efektif agar dapat mengajak orang lain untuk melakukan dan menjalankan ?</label>
                                                    <textarea name="a3" id="a3" class="form-control" style="height:150px;" placeholder="..."></textarea>
                                                </div>
                                            </div> -->

                                        </div><!-- /middle-wizard -->
                                        <div id="bottom-wizard">
                                            <button type="button" name="backward" class="backward">Backward </button>
                                            <button type="button" name="forward" class="forward">Forward</button>
                                            <button type="submit" name="process" class="submit">Submit</button>
                                        </div><!-- /bottom-wizard -->
                                    </form>
                                </div><!-- /Wizard container -->

                            </div><!-- /col -->
                        </div>
                    </div>
                    <center>
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <figure class="highcharts-figure">
                                    <div id="container-chart"></div>
                                </figure>
                            </div>
                        </div>
                    </center>

                </div>
            </div>
        </div>
    </div>
    <<style>
        .modal-footer{display:content}
        </style>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <?php echo $fwelcome; ?>
                    </div>
                    <div class="modal-footer" align="center" style="display:content">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- SCRIPTS -->
        <!-- Jquery-->
        <script src="<?= SURVEY_URL; ?>js/jquery-3.6.0.min.js"></script>
        <!-- Common script -->
        <script src="<?= SURVEY_URL; ?>js/common_scripts_min.js"></script>
        <!-- Theme script --
    <script src="<?= SURVEY_URL; ?>js/functions_no_side_panel.js"></script>
-->
        <script src="<?= SURVEY_URL; ?>js/jquery.wizard.js"></script>
        <script src="<?= PLUG_URL; ?>jquery/jquery.form.min.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/data.js"></script>
        <script src="https://code.highcharts.com/modules/drilldown.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script>
            AOS.init({
                duration: 800, // Durasi animasi dalam milidetik
                easing: 'ease-in-out', // Jenis animasi (ease, linear, ease-in, ease-out, dsb.)
                once: true // Animasi hanya berlangsung sekali
            });

            let scrollRef = 0;
            $(window).on("resize scroll", function() {
                // increase value up to 10, then refresh AOS
                scrollRef <= 10 ? scrollRef++ : AOS.refresh();
            });
        </script>
        <script type="text/javascript">
            //var demograp = '<?php echo urlencode($fdemografi); ?>';
            //var step1 = '<?php echo urlencode($step1); ?>';
            //var step2 = '<?php echo urlencode($step2); ?>';
            //var step3 = '<?php echo urlencode($step3); ?>';
            //<?php foreach ($variable as $key => $value) { ?>
            //var step<?= $key + 1; ?> = '<h2><?= $value['f_variabel_name'] ?></h2>';
            //<?php } ?>
            // var step4 = '<h2>Pertanyaan Terbuka</h2>';


            (function($) {
                "use strict";

                /*Aside panel + nav*/
                var $Main_nav = $('.main_nav');
                var $Mc = $('#main_container');
                var $Btn_m = $('#menu-button-mobile');
                var $Tabs_c = $('.main_nav .nav-tabs a');

                $Tabs_c.on('click', function(e) {
                    var href = $(this).attr('href');
                    $('.wrapper_in').animate({
                        scrollTop: $(href).offset().top
                    }, 'fast');
                    e.preventDefault();
                    if ($(window).width() <= 767) {
                        $Btn_m.removeClass("active");
                        $Main_nav.slideToggle(300);
                    }
                });
                $Btn_m.on("click", function() {
                    $Main_nav.slideToggle(500);
                    $(this).toggleClass("active");
                });

                $(window).on("resize", function() {
                    var width = $(window).width();
                    if (width <= 767) {
                        $Main_nav.hide();
                    } else {
                        $Main_nav.show();
                    }
                });

                /* Scroll to top small screens: chanhe the top position offset based on your content*/
                var $Scrolbt = $('button.backward,button.forward');
                var $Element = $('.wrapper_in');

                if (window.innerWidth < 800) {
                    $Scrolbt.on("click", function() {
                        $Element.animate({
                            scrollTop: 500
                        }, "slow");
                        return false;
                    });
                }

                if (window.innerWidth < 600) {
                    $Scrolbt.on("click", function() {
                        $Element.animate({
                            scrollTop: 610
                        }, "slow");
                        return false;
                    });
                }

                /* Tooltip*/
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl)
                })

                /*  Wizard */
                jQuery(function($) {
                    "use strict";
                    // Chose here which method to send the email, available:
                    // Simple phpmail text/plain > quote_send.php (default)
                    // PHPMailer text/html > phpmailer/quote_phpmailer.php
                    // PHPMailer text/html SMTP > phpmailer/quote_phpmailer_smtp.php
                    // PHPMailer with html template > phpmailer/quote_phpmailer_template.php
                    // PHPMailer with html template SMTP> phpmailer/quote_phpmailer_template_smtp.php
                    //$('form#wrapped').attr('action', 'quote_send.php');
                    $("#wizard_container").wizard({
                        stepsWrapper: "#wrapped",
                        submit: ".submit",
                        beforeSelect: function(event, state) {
                            //if ($('input#website').val().length != 0) {
                            //return false;
                            //}
                            if (!state.isMovingForward)
                                return true;
                            var inputs = $(this).wizard('state').step.find(':input');
                            return !inputs.length || !!inputs.valid();
                        },
                    }).validate({
                        errorPlacement: function(error, element) {
                            if (element.is(':radio') || element.is(':checkbox')) {
                                error.insertBefore(element.next());
                                error.appendTo($(".pesan_" + element.attr("id")));
                            } else {
                                error.insertAfter(element);
                            }
                        }
                    });
                    //  progress bar
                    $("#progressbar").progressbar();
                    $("#wizard_container").wizard({
                        afterSelect: function(event, state) {
                            console.log(state.percentComplete + ' ' + state.stepsComplete + ' ' + state.stepsPossible);
                            if (state.stepsComplete == 0) {
                                $(".fdemografi").show();
                                $(".fstep1").hide();
                                $(".fstep2").hide();
                                $(".fstep3").hide();
                                //$("#change_step").html(demograp);
                                $("#change_step").addClass('animate__animated animate__zoomInDown')
                                setTimeout(function() {
                                    $("#change_step").removeClass('animate__animated animate__zoomInDown')
                                }, 1000);
                            }
                            if (state.stepsComplete == 1) {
                                $(".fdemografi").hide();
                                $(".fstep1").show();
                                $(".fstep2").hide();
                                $(".fstep3").hide();
                                //$("#change_step").html(step1);
                                $("#change_step").addClass('animate__animated animate__zoomInDown')
                                setTimeout(function() {
                                    $("#change_step").removeClass('animate__animated animate__zoomInDown')
                                }, 1000);
                            }
                            if (state.stepsComplete == 2) {
                                $(".fdemografi").hide();
                                $(".fstep1").hide();
                                $(".fstep2").show();
                                $(".fstep3").hide();
                                //$("#change_step").html(step2);
                                $("#change_step").addClass('animate__animated animate__zoomInDown')
                                setTimeout(function() {
                                    $("#change_step").removeClass('animate__animated animate__zoomInDown')
                                }, 1000);
                            }
                            if (state.stepsComplete == 3) {
                                $(".fdemografi").hide();
                                $(".fstep1").hide();
                                $(".fstep2").hide();
                                $(".fstep3").show();
                                //$("#change_step").html(step3);
                                $("#change_step").addClass('animate__animated animate__zoomInDown')
                                setTimeout(function() {
                                    $("#change_step").removeClass('animate__animated animate__zoomInDown')
                                }, 1000);
                            }
                            // if(state.stepsComplete >= 4) {
                            //     $("#change_step").html(step4);
                            //     $("#change_step").addClass('animate__animated animate__zoomInDown')
                            //     setTimeout(function(){
                            //         $("#change_step").removeClass('animate__animated animate__zoomInDown')
                            //     }, 1000);
                            // }
                            $("#progressbar").progressbar("value", state.percentComplete);
                            $("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
                            $('.wrapper_in').animate({
                                scrollTop: $('div.container-fluid').position().top
                            }, 2000);
                            var bystep = $(".step").length;
                            if (state.stepsComplete == (bystep - 1)) {
                                $('button.submit').show().removeAttr('disabled');
                            } else {
                                $('button.submit').hide().attr('disabled', 'disabled');
                            }
                        }
                    });
                });

                $('form').on('submit', function(e) {
                    e.preventDefault();
                    var form = $("form#wrapped");
                    form.validate();
                    var today = new Date();
                    var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                    var time = today.getHours() + ':' + today.getMinutes() + ':' + today.getSeconds();

                    var url = "<?php echo site_url('c/fnSaveFinishCustomer/' . $sAccount . '/' . $alias . '/' . $eventId); ?>?mycode=" + date + '_' + time;
                    var rec = $('form#wrapped').serializeArray();
                    var oForm = $('form#wrapped');
                    var numberOfChecked = $('input:radio:checked').length;

                    if (form.valid()) {
                        $("#loader_form").fadeIn();
                        $('form').ajaxSubmit({
                            dataType: 'json',
                            url: url,
                            success: function(data) {
                                if (data.status == 200) {
                                    console.log(data)
                                    $('#loader_form').fadeOut();
                                    $("#rubah").html('<div class="col-12 animate__animated animate__heartBeat" align="center"><h5 style="font-size:48pt;color:#1c2954;">TERIMA KASIH</h5></div>')
                                    Highcharts.chart('container-chart', {
                                        chart: {
                                            type: 'column'
                                        },
                                        accessibility: {
                                            announceNewData: {
                                                enabled: true
                                            }
                                        },
                                        title: {
                                            align: 'center',
                                            text: 'Hasil Motive Inventory Test'
                                        },
                                        xAxis: {
                                            type: 'category'
                                        },
                                        yAxis: {
                                            min: 0,
                                            max: 10
                                        },
                                        legend: {
                                            enabled: false
                                        },
                                        plotOptions: {
                                            series: {
                                                borderWidth: 0,

                                            }
                                        },

                                        series: [{
                                            name: 'Kategori',
                                            colorByPoint: true,
                                            data: data.data
                                        }],
                                    });
                                } else {
                                    $('#loader_form').fadeOut();
                                }
                            },
                            error: function(data) {
                                $('#loader_form').fadeOut();
                            }
                        });

                        //$.post(url, rec, function(msg){
                        //$('#loader_form').fadeOut();
                        //$("#rubah").html('<div class="col-12 animate__animated animate__heartBeat" align="center"><h1 style="font-size:48pt;color:#1c2954;"><u>TERIMA KASIH</u></h1></div>')
                        //},'json').fail(function(e){
                        //$('#loader_form').fadeOut();
                        //});

                    }
                });

                /* Check and radio input styles */
                $('input.icheck').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                });

            })(window.jQuery); // JavaScript Document
            $(document).ready(function() {
                $('#staticBackdrop').modal('show');
                setTimeout(function() {
                    $("#change_step").removeClass('animate__animated animate__zoomInDown')
                    $('#preloader').hide();

                }, 1000);

                <?php if ($listdemo['f_level2'] == 1) { ?>
                    $("#level1").on('change', function(e) {
                        $.post("<?php echo site_url("c/fnPositionComboDataChange/2/$alias"); ?>", {
                            f_parents: $(this).val()
                        }, function(data) {
                            if (data.length > 0) {
                                var option_select = '<option value="" selected="selected">--- Pilih ---</option>';
                                $.each(data, function(k, v) {
                                    option_select += '<option value="' + v.id + '" >' + v.text + '</option>';
                                })
                                $("select#level2").html(option_select);
                            }
                        }, 'json');

                        <?php if ($listdemo['f_level3'] == 1) { ?>
                            $("select#level3").html('<option value="" selected="selected">--- Pilih ---</option>');
                        <?php    } ?>

                    });
                <?php    } ?>

            })
        </script>

        <script>
            $('#select_pekerjaan').on('change', function() {
                console.log('ok')
            })
        </script>

</body>

</html>