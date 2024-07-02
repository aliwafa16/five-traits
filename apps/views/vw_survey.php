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

    <div class="container mb-3">
        <div class="row align-items-center mt-5 justify-content-center">
            <div class="col-lg-8 col-sm-12">
                <div id="smartwizard">
                    <ul class="nav" style="display:none">
                        <li class="nav-item">
                            <a class="nav-link" href="#step-1">
                                <div class="num">1</div>
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $max_loop; $i++) : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="#step-<?= $i + 1 ?>">
                                    <div class="num"><?= $i + 1 ?></div>
                                </a>
                            </li>
                        <?php endfor; ?>
                    </ul>

                    <div class="tab-content">
                        <div id="step-1" class="tab-pane bg-light" role="tabpanel" aria-labelledby="step-1">
                            <form id="form-survey-1" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="username">Nama</label>
                                    <input type="nama" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email" required>
                                </div>
                            </form>
                        </div>
                        <?php $step = 1 ?>
                        <?php foreach ($item_pernyataan as $key => $value) : ?>
                            <div id="step-<?= $step + 1 ?>" class="tab-pane" role="tabpanel" aria-labelledby="step-<?= $step + 1 ?>">
                                <form id="form-survey-<?= $step + 1 ?>" enctype="multipart/form-data">
                                    <?php foreach ($value as $key_item => $value_item) : ?>
                                        <div class="mb-4 border-primary card shadow ">
                                            <div class="card-header gradient-bg">
                                                <blockquote class="blockquote">
                                                    <p class="mb-0 text-center font-weight-bold text-light"><?= $value_item['f_item'] ?></p>
                                                </blockquote>
                                            </div>
                                            <div class="card-body">
                                                <table class="table-container">
                                                    <tr class="text-center">
                                                        <td style="width: 23%;">
                                                            <input type="radio" id="pertanyaan_<?= $value_item['f_id'] ?>" name="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-input" value="1" required>
                                                            <label for="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-label">Tidak berlaku sama sekali</label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="pertanyaan_<?= $value_item['f_id'] ?>" name="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-input" value="2" required>
                                                            <label for="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-label"></label>
                                                        </td>
                                                        <td style="width: 20%;">
                                                            <input type="radio" id="pertanyaan_<?= $value_item['f_id'] ?>" name="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-input" value="3" required>
                                                            <label for="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-label">Berlaku di beberapa situasi</label>
                                                        </td>
                                                        <td>
                                                            <input type="radio" id="pertanyaan_<?= $value_item['f_id'] ?>" name="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-input" value="4" required>
                                                            <label for="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-label"></label>
                                                        </td>
                                                        <td style="width: 20%;">
                                                            <input type="radio" id="pertanyaan_<?= $value_item['f_id'] ?>" name="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-input" value="5" required>
                                                            <label for="pertanyaan_<?= $value_item['f_id'] ?>" class="radio-label">Selalu berlaku untuk Anda</label>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </form>
                            </div>
                            <?php $step++; ?>
                        <?php endforeach; ?>
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

    <script>
        $(document).ready(function() {

            var formInputs = $('#form-survey-1').find(':input:not(:radio)');

            // Loop melalui setiap elemen formulir
            formInputs.each(function() {
                var inputName = $(this).attr('name');

                // Periksa apakah ada nilai di local storage untuk kunci yang sesuai
                var storedValue = localStorage.getItem(inputName);

                // Jika ada nilai di local storage, atur nilai tersebut ke dalam elemen formulir
                if (storedValue !== null) {
                    $(this).val(storedValue);
                }
            });


            var radioButtons = $('.tab-content').find(':radio');

            // Loop through each radio button
            radioButtons.each(function() {
                var radioName = $(this).attr('name');

                // Check if there is a value in local storage for the corresponding key
                var storedValueRadio = localStorage.getItem(radioName);

                // If a value is found in local storage, check the radio button with that value
                if (storedValueRadio !== null && $(this).val() === storedValueRadio) {
                    $(this).prop('checked', true);
                }
            });
            $(function() {
                // SmartWizard initialize
                $('#smartwizard').smartWizard({
                    theme: 'dots',
                    lang: { // Language variables for button
                        next: 'Selanjutnya',
                        previous: 'Sebelumnya'
                    },
                    toolbar: {
                        extraHtml: `<button class="btn btn-success" type="button" id="finish-btn" onclick="onFinish()">Finish</button>`
                    },

                });

                $('#smartwizard').on('showStep', function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
                    // Hide the finish button initially
                    $('#finish-btn').hide();

                    // Show the finish button only on the last step
                    if (stepPosition === 'last') {
                        $('#finish-btn').show();
                    }
                });

                $("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
                    // Update the progress bar width and aria-valuenow attribute
                    if (currentStepIndex == 0) {
                        var formData1 = $('#form-survey-' + (currentStepIndex + 1)).find(':input:not(:radio)').map(function() {
                            localStorage.setItem($(this).attr('name'), $(this).val());
                        }).get();
                    } else {
                        var formData = $('#form-survey-' + (currentStepIndex + 1)).find(':radio:checked').map(function() {
                            localStorage.setItem($(this).attr('name'), $(this).val());
                        }).get();
                    }

                    let totalSteps = $('#smartwizard ul.nav > li').length;
                    let progressValue = (currentStepIndex + 1) / (totalSteps - 1) * 100;

                    // Update the progress bar width and aria-valuenow attribute
                    $('.progress-bar').css('width', progressValue + '%').attr('aria-valuenow', progressValue);
                    const originalNumber = parseFloat($('.progress-bar').attr('aria-valuenow'));
                    $('.progress-bar').text(originalNumber.toFixed(2) + '%');


                    if (stepDirection == 'forward') {
                        if (currentStepIndex + 1 == 1) {
                            let form = document.getElementById('form-survey-' + (currentStepIndex + 1));
                            if (form) {
                                if (!form.checkValidity()) {
                                    form.classList.add('was-validated');
                                    $('#smartwizard').smartWizard("setState", [currentStepIndex], 'error');
                                    $("#smartwizard").smartWizard('fixHeight');
                                    return false;
                                }
                                $('#smartwizard').smartWizard("unsetState", [currentStepIndex], 'error');
                            }
                        }

                        if (currentStepIndex + 1 > 1) {
                            // Mendapatkan semua grup name radio button di dalam formulir dengan ID 'form-survey-2'
                            var groupNames = $('#form-survey-' + (currentStepIndex + 1) + ' input[type="radio"]').map(function() {
                                return this.name;
                            }).get();

                            console.log(groupNames);

                            // Menghapus duplikasi grup name
                            var uniqueGroupNames = [...new Set(groupNames)];

                            // Menguji apakah setiap grup memiliki setidaknya satu radio button yang dipilih
                            var allGroupsSelected = true;

                            // Menyimpan perilaku yang belum memiliki radio button yang dipilih
                            var behaviorsWithoutSelection = [];



                            uniqueGroupNames.forEach(function(groupName) {

                                var groupRadioInputs = $('input[name="' + groupName + '"]');
                                console.log(groupRadioInputs);
                                if (groupRadioInputs.filter(':checked').length === 0) {
                                    var behaviorName = $('[name="' + groupName + '"]').closest('tr').find('td:first').text();
                                    behaviorsWithoutSelection.push(behaviorName);
                                    console.log({
                                        ini_behavior: behaviorName
                                    })
                                    allGroupsSelected = false;
                                    return false; // Hentikan loop jika ada grup yang belum dipilih
                                }
                            });

                            console.log({
                                ini_: allGroupsSelected
                            })

                            // Tampilkan pesan sesuai dengan validitas formulir
                            if (allGroupsSelected) {
                                window.scrollTo({
                                    top: 0,
                                    behavior: 'smooth'
                                }); // Scroll to top
                                console.log("Setiap grup radio button memiliki setidaknya satu yang dipilih.");
                                return true;
                            } else {
                                cuteAlert({
                                    type: "warning",
                                    title: 'Oopss....',
                                    message: 'Ada Pernyataan yang belum dipilih. <br>Silahkan cek kembali',
                                    buttonText: 'OK'
                                })
                                window.scrollTo({
                                    top: 0,
                                    behavior: 'smooth'
                                }); // Scroll to top
                                return false;
                            }

                        }
                    }
                });

            });
        })

        function onFinish() {
            cuteAlert({
                type: "question",
                title: 'Yakin melanjutkan ?',
                message: 'Data yang sudah disimpan tidak bisa diubah',
                confirmText: 'Lanjutkan',
                cancelText: 'Batal'
            }).then((e) => {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

                var hours = String(today.getHours()).padStart(2, '0');
                var minutes = String(today.getMinutes()).padStart(2, '0');
                var seconds = String(today.getSeconds()).padStart(2, '0');

                today = mm + '-' + dd + '-' + yyyy + ' ' + hours + ':' + minutes + ':' + seconds;


                let formDataArray = [];

                for (let i = 1; i <= 14; i++) {
                    let formId = '#form-survey-' + i;
                    let formData = new FormData($(formId)[0]);
                    formDataArray.push(formData);
                }

                // Combine all arrays into a single array of key-value pairs
                let combinedKeyValuePairs = [].concat(...formDataArray.map(formData => [...formData.entries()]));

                let unique_code = '<?= $this->input->get('unique_code') ?>'

                let resultObject = combinedKeyValuePairs.reduce((result, [key, value]) => {
                    result[key] = value;
                    return result;
                }, {});

                if (e == "confirm") {

                    console.log(resultObject);
                    const url = '<?= base_url() ?>c/fnSaveFinish/<?= $sAccount ?>/<?= $alias ?>';
                    const data = resultObject;

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(results => {
                            if (results.code != 200) {
                                cuteAlert({
                                    type: "error",
                                    title: 'Opps...',
                                    message: `${results.msg}`,
                                    buttonText: 'OK'
                                });
                            } else {
                                cuteAlert({
                                    type: "success",
                                    title: 'Selamat',
                                    message: `${results.msg}`,
                                    buttonText: 'OK'
                                }).then(() => {
                                    window.localStorage.clear();
                                    window.location.href = '<?= base_url() ?>c/finish/' + results.url;
                                });
                            }
                        })
                        .catch(error => {
                            cuteAlert({
                                type: "error",
                                title: 'Error',
                                message: `An error occurred: ${error}`,
                                buttonText: 'OK'
                            });
                        });

                } else {
                    console.log('gak confirm')
                }
            })
        }
    </script>
</body>

</html>