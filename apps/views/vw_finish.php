<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="shortcut icon" href="https://survey.actconsulting.co/assets/images/act.png" type="image/x-icon" />

    <!-- Jquery -->
    <script src="<?= base_url('assets/jquery/jquery-3.7.1.js') ?>"></script>

    <!-- Wizard -->
    <link href="<?= base_url('assets/wizards') ?>/dist/css/smart_wizard_dots.css" rel="stylesheet" type="text/css" />

    <!-- Alert -->
    <link rel="stylesheet" href="<?= base_url('assets/alerts/style.css') ?>">

    <title><?= NAME_APL ?></title>

    <style>
        .table-container {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container td {
            padding: 10px;
            text-align: center;
            vertical-align: top;
        }

        .radio-label {
            display: block;
            text-align: center;
            margin-top: 5px;
            /* Ruang antara radio button dan label */
        }

        .radio-input {
            transform: scale(2.3);

        }

        blockquote p {
            font-size: 18px !important;
        }

        .gradient-bg- {
            color: #000;
            background: linear-gradient(145deg, #5a68ff 31%, #002a8e 92%);
        }

        .gradient-bg {
            color: #000;
            background: linear-gradient(145deg, #2d3fff 31%, #00174d 92%);
        }

        .table-container td label {
            color: #070F2B;
            font-weight: 650;
        }

        body {
            background-color: #F3F8FF;
        }



        /* // Extra small devices (portrait phones, less than 576px) */
        @media (max-width: 575.98px) {
            .table-container td label {
                font-size: 12px;
                font-weight: 650;
            }

            .table-container td {
                width: auto !important;
                /* Remove width on small screens */
            }

            .radio-input {
                transform: scale(2.0);
            }

            blockquote p {
                font-size: 16px;
            }
        }

        /* // Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) and (max-width: 767.98px) {}

        /* // Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) and (max-width: 991.98px) {}

        /* // Large devices (desktops, 992px and up) */
        @media (min-width: 992px) and (max-width: 1199.98px) {}

        /* // Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {}
    </style>
</head>

<body>
    <nav class="navbar navbar-light gradient-bg">
        <h3 class="mx-auto text-center text-white"><?= NAME_APL ?></h3>
    </nav>

    <div class="container">
        <div class="row align-items-center mt-5 justify-content-center">
            <div class="col-md-8">
                <div class="mb-4 border-primary card shadow ">
                    <div class="card-header gradient-bg">
                        <blockquote class="blockquote">
                            <h4 class="text-light text-center">Hasil</h4>
                            <h2 class="mb-0 text-center font-weight-bold text-light"><?= $transaksi['f_survey_username'] ?></h2>
                        </blockquote>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered ">
                            <thead>
                                <tr class="thead-light">
                                    <th scope="col">Aspek Emotional Intelligence</th>
                                    <th scope="col" style="text-align: center;">Skor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($survey['jawaban_perkategori'] as $key => $value) : ?>
                                    <?php $textColors = '';
                                    if ($value['colors'] == "#0D1282") {
                                        $textColors = 'white';
                                    }

                                    if ($value['colors'] == "#F4CE14") {
                                        $textColors = 'white';
                                    }

                                    if ($value['colors'] == "#C70039") {
                                        $textColors = 'white';
                                    }
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $value['name'] ?></th>
                                        <td style="background-color: <?= $value['colors'] ?>; text-align:center; color:<?= $textColors ?>;font-weight:700"><?= $value['value'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-items-center justify-content-left">
            <div class="col-md-4 offset-md-2">
                <div class="mb-4 border-primary card shadow ">
                    <div class="card-header gradient-bg">
                        <blockquote class="blockquote">
                            <p class="mb-0 text-center font-weight-bold text-light">
                                Kode warna
                            <p>
                        </blockquote>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" style="font-size: 14px !important;">
                            <thead>
                                <tr class="thead-light">
                                    <th scope="col">Warna</th>
                                    <th scope="col" style="text-align: center;">Definisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="background-color:#0D1282"></td>
                                    <th scope="row">Strength</th>
                                </tr>
                                <tr>
                                    <td style="background-color:#F4CE14"></td>
                                    <th scope="row">Needs Attention</th>
                                </tr>
                                <tr>
                                    <td style="background-color:#C70039"></td>
                                    <th scope="row">Development Priority</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar fixed-bottom navbar-light gradient-bg">
    </nav>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->

    <!-- Wizards -->
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

    <!-- Alerts -->
    <script src="<?= base_url('assets/alerts/cute-alert.js') ?>"></script>
</body>

</html>