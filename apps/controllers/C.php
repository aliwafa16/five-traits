<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('mo_c');
    }

    public function index($alias)
    {
        //error_reporting(-1);
        //ini_set('display_errors', 1);
        $data = array(
            'app_title' => 'survey',
        );
        $search_account = $this->mo_c->alias_url($alias);
        if ($search_account) {
            $idAccount = $search_account['f_account_id'];
            $data['alias']     = $alias;
            $data['sAccount']     = $idAccount;
            $data['nameAccount']     = $search_account['f_account_name'];
            $data['logo_account']     = $search_account['f_account_logo'];
            // if (get_cookie('survey_language')) {
            //     if (file_exists('app/language/' . get_cookie('survey_language') . '/act_lang.php') && is_dir('app/language/' . get_cookie('survey_language'))) {
            //         $this->lang->load('act', get_cookie('survey_language'));
            //         define("LANGUAGE", get_cookie('survey_language'));
            //     }
            //     define("SLANGUAGE", get_cookie('survey_language'));
            // } else {
            //     $this->lang->load('act', $search_account['f_language']);
            //     define("LANGUAGE", $search_account['f_language']);
            //     define("SLANGUAGE", $search_account['f_language']);
            // }
            $data['set_demo']     = $search_account;
            //$this->db->where('f_event_survey',3);
            $event_account             = $this->mo_c->checkEventAccount($idAccount, $alias);
            if ($event_account) {
                $listdemo             = $this->mo_c->listDemo($idAccount);
                $data['listdemo']     = $listdemo;
                //$data['leaders']     = $this->mo_c->comboDataLeaders($idAccount);
                // if ($listdemo['f_region'] == 1)    $data['region']     = $this->mo_c->comboDataRegion($idAccount);
                // if ($listdemo['f_level1'] == 1)    $data['cLevel1']     = $this->mo_c->comboDataLevelofposition1($idAccount);
                // if ($listdemo['f_level_of_work'] == 1)    $data['level_of_work']     = $this->mo_c->comboDataLevelofwork($idAccount);
                // if ($listdemo['f_masakerja'] == 1)    $data['masakerja']     = $this->mo_c->comboDataLengthofservice($idAccount);
                // if ($listdemo['f_gender'] == 1)    $data['gender']     = $this->mo_c->comboDataGender($idAccount);
                // if ($listdemo['f_age'] == 1)        $data['age_ar']     = $this->mo_c->comboDataAge($idAccount);
                // if ($listdemo['f_pendidikan'] == 1)    $data['pendidikan']     = $this->mo_c->comboDataEducation($idAccount);

                //$sql_review = $this->db->select('f_intervensi')->get('t_review')->row();
                //$data['soal_kesiapan'] = $this->db->get('t_soal_area_kesiapan')->result_array();
                //$data_leaders     = $this->mo_c->comboDataLeaders($idAccount);
                ////$data_demograp = json_decode($sql_data_demograp->f_text,true);
                //$data['nama_leader'] = $data_leaders[$data_demograp['f_leaders']];

                // $data['umur'] = $this->db->get('table_age')->result_array();
                // $data['pekerjaan'] = $this->db->get('table_pekerjaan')->result_array();
                // $data['pendapatan'] = $this->db->get('table_pendapatan')->result_array();
                // $data['gender'] = $this->db->get('table_gender')->result_array();



                $this->session->set_userdata('mulai_survey', date('Y-m-d H:i:s'));
                $data['f_rand'] = rand(12345678, 98765432);
                $data['setting_survey'] = $this->getSettingSurvey($idAccount);
                $data['eventId'] = $event_account['f_event_id'];
                $data['variable'] = $this->db->select('*')->from('t_variabel')->get()->result_array();


                // Get item pertanyaan
                $itemPernyataan = $this->db->get('t_item_pernyataan')->result_array();
                $groupedData = array_chunk($itemPernyataan, 10);

                $max_group = 10;
                $data['item_pernyataan'] = $groupedData;
                $data['max_loop'] = count($itemPernyataan) / $max_group;
                $this->load->view('vw_survey', $data);
            } else {
                show_error('<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Survey expired', 404, $heading = '404');
            }
        } else {
            show_error('<i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.', 404, $heading = '404');
        }
    }

    function getSettingSurvey($id)
    {
        $this->db->select('f_setting,f_page_personal,f_page_leaderc,f_page_leaderd', false);
        $this->db->where('f_account_id', $id);
        $sql = $this->db->get('survey_setting')->row();
        return $sql;
    }

    function fnFormDemograp($alias, $search_account)
    {
        $idAccount = $search_account['f_account_id'];
        $data['alias']     = $alias;
        $data['sAccount']     = $idAccount;
        $data['nameAccount']     = $search_account['f_account_name'];
        $data['logo_account']     = $search_account['f_account_logo'];
        //if(get_cookie('survey_language')) {
        //if(file_exists('app/language/'.get_cookie('survey_language').'/act_lang.php') && is_dir('app/language/'.get_cookie('survey_language')))
        //{
        //$this->lang->load('act', get_cookie('survey_language'));
        //define("LANGUAGE", get_cookie('survey_language'));
        //}
        //define("SLANGUAGE", get_cookie('survey_language'));
        //} else {
        //$this->lang->load('act', $search_account['f_language']);
        //define("LANGUAGE", $search_account['f_language']);
        //define("SLANGUAGE", $search_account['f_language']);
        //}
        $data['set_demo']     = $search_account;
        $listdemo             = $this->mo_c->listDemo($idAccount);
        $data['listdemo']     = $listdemo;
        $data['leaders']     = $this->mo_c->comboDataLeaders($idAccount);
        if ($listdemo['f_region'] == 1)    $data['region']     = $this->mo_c->comboDataRegion($idAccount);
        if ($listdemo['f_level1'] == 1)    $data['cLevel1']     = $this->mo_c->comboDataLevelofposition1($idAccount);
        if ($listdemo['f_level_of_work'] == 1)    $data['level_of_work']     = $this->mo_c->comboDataLevelofwork($idAccount);
        if ($listdemo['f_masakerja'] == 1)    $data['masakerja']     = $this->mo_c->comboDataLengthofservice($idAccount);
        if ($listdemo['f_gender'] == 1)    $data['gender']     = $this->mo_c->comboDataGender($idAccount);
        if ($listdemo['f_age'] == 1)        $data['age_ar']     = $this->mo_c->comboDataAge($idAccount);
        if ($listdemo['f_pendidikan'] == 1)    $data['pendidikan']     = $this->mo_c->comboDataEducation($idAccount);

        $html = $this->load->view('vw_demograp', $data, true);
        echo $html;
    }

    function demograp($alias)
    {
        $search_account = $this->mo_c->alias_url($alias);
        $idAccount = $search_account['f_account_id'];
        $data['alias']     = $alias;
        $data['sAccount']     = $idAccount;
        $data['nameAccount']     = $search_account['f_account_name'];
        $data['logo_account']     = $search_account['f_account_logo'];
        if (get_cookie('survey_language')) {
            if (file_exists('app/language/' . get_cookie('survey_language') . '/act_lang.php') && is_dir('app/language/' . get_cookie('survey_language'))) {
                $this->lang->load('act', get_cookie('survey_language'));
                define("LANGUAGE", get_cookie('survey_language'));
            }
            define("SLANGUAGE", get_cookie('survey_language'));
        } else {
            $this->lang->load('act', $search_account['f_language']);
            define("LANGUAGE", $search_account['f_language']);
            define("SLANGUAGE", $search_account['f_language']);
        }
        $data['set_demo']     = $search_account;
        $listdemo             = $this->mo_c->listDemo($idAccount);
        $data['listdemo']     = $listdemo;
        $data['leaders']     = $this->mo_c->comboDataLeaders($idAccount);
        if ($listdemo['f_region'] == 1)    $data['region']     = $this->mo_c->comboDataRegion($idAccount);
        if ($listdemo['f_level1'] == 1)    $data['cLevel1']     = $this->mo_c->comboDataLevelofposition1($idAccount);
        if ($listdemo['f_level_of_work'] == 1)    $data['level_of_work']     = $this->mo_c->comboDataLevelofwork($idAccount);
        if ($listdemo['f_masakerja'] == 1)    $data['masakerja']     = $this->mo_c->comboDataLengthofservice($idAccount);
        if ($listdemo['f_gender'] == 1)    $data['gender']     = $this->mo_c->comboDataGender($idAccount);
        if ($listdemo['f_age'] == 1)        $data['age_ar']     = $this->mo_c->comboDataAge($idAccount);
        if ($listdemo['f_pendidikan'] == 1)    $data['pendidikan']     = $this->mo_c->comboDataEducation($idAccount);

        $html = $this->load->view('vw_redemograp', $data, true);
        echo $html;
    }

    function fnPositionComboData($id, $alias)
    {
        $search_account = $this->mo_c->alias_url($alias);
        $DataJson = array();
        if ($search_account) {
            $parent_field = 'f_id' . ($id - 1);
            if ($this->input->get('term')) $this->db->like('f_position_desc', $this->input->get('term')); // pencarian name
            if ($this->input->get('f_parents')) $this->db->where($parent_field, $this->input->get('f_parents')); // saat pencarian update
            if ($this->input->get('id')) $this->db->where('f_id', $this->input->get('id')); // saat pencarian update

            $this->db->where('f_account_id', $search_account['f_account_id']); // pencarian Account
            $this->db->where('f_aktif', 1); // Aktif
            $table_name = 'table_level_position' . $id;
            $this->db->order_by('f_id', 'asc');
            $result = $this->db->get($table_name)->result();
            foreach ($result as $row) :
                $data['id']    = $row->f_id; // value
                $data['text']    = $row->f_position_desc; // change display
                array_push($DataJson, $data);
            endforeach;
        }
        $json['result'] = $DataJson;
        echo json_encode($json);
    }

    function saveDemo($alias)
    {
        $search_account = $this->mo_c->alias_url($alias);
        if ($search_account) {
            $demograp_data['demograp_data1'] = array(
                'f_leaders'     => $this->input->post('leaders'),
                'f_ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            if ($this->input->post('gender')) $demograp_data['demograp_data1']['f_gender'] = $this->input->post('gender');
            if ($this->input->post('age')) $demograp_data['demograp_data1']['f_age'] = $this->input->post('age');
            if ($this->input->post('masakerja')) $demograp_data['demograp_data1']['f_length_of_service'] = $this->input->post('masakerja');
            if ($this->input->post('region')) $demograp_data['demograp_data1']['f_region'] = $this->input->post('region');
            if ($this->input->post('level_of_work')) $demograp_data['demograp_data1']['f_level_of_work'] = $this->input->post('level_of_work');
            if ($this->input->post('level1')) $demograp_data['demograp_data1']['f_level1'] = $this->input->post('level1');
            if ($this->input->post('level2')) $demograp_data['demograp_data1']['f_level2'] = $this->input->post('level2');
            if ($this->input->post('level3')) $demograp_data['demograp_data1']['f_level3'] = $this->input->post('level3');
            if ($this->input->post('level4')) $demograp_data['demograp_data1']['f_level4'] = $this->input->post('level4');
            if ($this->input->post('level5')) $demograp_data['demograp_data1']['f_level5'] = $this->input->post('level5');
            if ($this->input->post('level6')) $demograp_data['demograp_data1']['f_level6'] = $this->input->post('level6');
            if ($this->input->post('level7')) $demograp_data['demograp_data1']['f_level7'] = $this->input->post('level7');
            if ($this->input->post('f_custom1')) $demograp_data['demograp_data1']['f_custom1'] = $this->input->post('f_custom1');
            if ($this->input->post('f_custom2')) $demograp_data['demograp_data1']['f_custom2'] = $this->input->post('f_custom2');
            if ($this->input->post('f_custom3')) $demograp_data['demograp_data1']['f_custom3'] = $this->input->post('f_custom3');
            if ($this->input->post('f_custom4')) $demograp_data['demograp_data1']['f_custom4'] = $this->input->post('f_custom4');
            if ($this->input->post('f_custom5')) $demograp_data['demograp_data1']['f_custom5'] = $this->input->post('f_custom5');
            if ($this->input->post('f_custom6')) $demograp_data['demograp_data1']['f_custom5'] = $this->input->post('f_custom6');
            if ($this->input->post('f_custom7')) $demograp_data['demograp_data1']['f_custom5'] = $this->input->post('f_custom7');
            if ($this->input->post('f_custom8')) $demograp_data['demograp_data1']['f_custom5'] = $this->input->post('f_custom8');
            if ($this->input->post('f_custom9')) $demograp_data['demograp_data1']['f_custom5'] = $this->input->post('f_custom9');
            if ($this->input->post('f_custom10')) $demograp_data['demograp_data1']['f_custom10'] = $this->input->post('f_custom10');
            if ($this->input->post('tipen')) $demograp_data['demograp_data1']['f_pendidikan'] = $this->input->post('tipen');
            if ($this->input->post('f_nik')) $demograp_data['demograp_data1']['f_nik'] = $this->input->post('f_nik');

            $demograp_data['demograp_data2'] = array(
                'f_nama'     => $this->input->post('f_nama'),
                'leaders_name'        => $this->input->post('leaders_name'),
                'age_name'        => $this->input->post('age_name'),
                'masakerja_name' => $this->input->post('mk_name'),
                'region_name'  => $this->input->post('region_name'),
                'level_of_work_name' => $this->input->post('level_of_work_name'),
                'level1_name'  => $this->input->post('level1_name'),
                'level2_name'  => $this->input->post('level2_name'),
                'level3_name'  => $this->input->post('level3_name'),
                'level4_name'  => $this->input->post('level4_name'),
                'level5_name'  => $this->input->post('level5_name'),
                'level6_name'  => $this->input->post('level6_name'),
                'level7_name'  => $this->input->post('level7_name'),
                'f_custom1_name' => $this->input->post('f_custom1_name'),
                'f_custom2_name' => $this->input->post('f_custom2_name'),
                'f_custom3_name' => $this->input->post('f_custom3_name'),
                'f_custom4_name' => $this->input->post('f_custom4_name'),
                'f_custom5_name' => $this->input->post('f_custom5_name'),
                'f_custom6_name' => $this->input->post('f_custom6_name'),
                'f_custom7_name' => $this->input->post('f_custom7_name'),
                'f_custom8_name' => $this->input->post('f_custom8_name'),
                'f_custom9_name' => $this->input->post('f_custom9_name'),
                'f_custom10_name' => $this->input->post('f_custom10_name'),
                'f_ip_address' => $_SERVER['REMOTE_ADDR'],
                'f_pendidikan' => $this->input->post('tipen'),
                "f_nik" => $this->input->post('f_nik'),
            );

            $this->db->trans_start();
            $record = json_encode($demograp_data['demograp_data1'], JSON_NUMERIC_CHECK);
            $data_input = array(
                'f_code' => $this->input->get('tokensurvey'),
                'f_text' => $record,
                'f_date' => date('Y-m-d H:i:s'),
            );
            $this->db->query($this->db->insert_string('temp_demograp', $data_input) . " ON DUPLICATE KEY UPDATE f_text='" . $record . "',f_date=now()");
            $this->db->trans_complete();
            if ($this->db->trans_status()) {
                $this->session->set_userdata($demograp_data);
                echo json_encode(array('status' => 200, 'pesan' => 'Sukses.'));
            } else {
                echo json_encode(array('status' => 501, 'pesan' => 'Coba Lagi'));
            }
        } else {
            echo json_encode(array('status' => 500, 'pesan' => 'Tidak ditemukan.'));
        }
    }

    function fnValueDataAll($bahasa, $accountId)
    {
        $this->db->where(array('f_account_id' => $accountId, 'f_value_active' => 1));
        $total = $this->db->get('table_value')->num_rows();
        if ($total > 0) {
            $this->db->select('f_value_category,f_value_id,f_value_name_' . $bahasa, false);
            $this->db->where(array('f_account_id' => $accountId, 'f_value_active' => 1));
            $this->db->order_by('f_value_name_' . $bahasa, 'asc');
            $sql = $this->db->get('table_value')->result_array();
            $data = array();
            foreach ($sql as $r) :
                $data[$r['f_value_category']][] = array('f_value_id' => $r['f_value_id'], 'f_value_name' => $r['f_value_name_' . $bahasa]);
            endforeach;
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function fnSaveValue($namaValue, $accountId, $aliasUrl, $eventId, $step)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Length, Content-Type, Accept, Accept-Encoding");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        // INSERT TEMP
        $yourcode = $this->input->get('mycode');
        if (count($_POST['prioritas']) == 10) {
            $this->db->trans_start();
            $data['choose'] = $_POST['prioritas'];
            //$record = json_encode($data);
            $data_input = array(
                'f_event_id' => $eventId,
                'f_account_id' => $accountId,
                'f_code' => $yourcode,
                'f_survey_' . $namaValue => json_encode($data, JSON_NUMERIC_CHECK),
                'f_date' => date('Y-m-d H:i:s'),
            );
            $record = $data_input['f_survey_' . $namaValue];
            if ($step == 1) $data_input['f_survey_demographic'] = json_encode($this->session->userdata('demograp_data1'));
            //$insert_query = $this->db->insert_string('temp_survey', $data_input);
            $insert_query = $this->db->query($this->db->insert_string('temp_survey', $data_input) . " ON DUPLICATE KEY UPDATE f_survey_" . $namaValue . "='" . $record . "',f_date=now()");
            error_log($this->db->last_query());
            //'f_survey_demographic' => json_encode($this->session->userdata('demograp_data1')),
            //$this->db->query("INSERT INTO temp_survey (f_event_id,f_account_id,f_code,f_survey_".$namaValue.",f_date) VALUES ($eventId,$accountId,'".$yourcode."','".$record."',now()) ON DUPLICATE KEY UPDATE f_survey_".$namaValue."='".$record."',f_date=now()");

            $f_step = "f_step_" . $step;
            $data = array(
                'f_event_id' => $eventId,
                'f_account_id' => $accountId,
                'f_step' => $step,
                'f_date' => date('Y-m-d H:i:s'),
            );
            //$this->db->insert('actconsu_log.log_ochi',$data);

            //$update = $this->db->query("update t_event_detail set $f_step=ifnull($f_step,0)+1 where f_event_id=".$eventId);
            $this->db->trans_complete();
            if ($this->db->trans_status())    echo json_encode(array('status' => 200, 'pesan' => 'Valid'));
            else echo json_encode(array('status' => 500, 'pesan' => 'Error !!!'));
        } else {
            echo json_encode(array('status' => 500, 'pesan' => 'Values kurang.'));
        }
    }

    function fnSaveFinish($id, $aliasUrl)
    {

        $response = [];

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Length, Content-Type, Accept, Accept-Encoding");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        //error_reporting(-1);
        //ini_set('display_errors', 1);


        // Cek event ada atau tidak 
        // $masterEvent = $this->db->get_where('t_event', ['f_event_kode' => $aliasUrl])->row_array();

        $event_account = $this->mo_c->checkEventAccount($id, $aliasUrl);

        if (!$event_account) {
            $response = ['status' => false, 'code' => '400', 'msg' => 'Event tidak ditemukan'];
        } else {

            // get category
            $itemPernyataan = $this->db->get('t_item_pernyataan')->result_array();
            $itemKategori = $this->db->get('t_variabel')->result_array();
            $namaPertanyaan = 'pertanyaan';

            $inputData = json_decode(file_get_contents('php://input'), true);

            $finals_answer = [];
            $distribusi_jawaban = [];
            $distribusi_perkategori = [];


            // Mullai hitung jawaban 
            foreach ($itemPernyataan as $key) {
                $value = $inputData[$namaPertanyaan . '_' . $key['f_id']];
                $row = [
                    'id' => $key['f_id'],
                    'name' => 'pernyataan_' . $key['f_id'],
                    'value' => $value,
                    'kategori' => $key['f_variabel_id']
                ];
                $distribusi_jawaban[] = $row;
            }

            // hitung perkategori
            foreach ($itemKategori as $key) {
                $rowKategori = array(
                    'id' => $key['f_id'],
                    'name' => $key['f_variabel_name'],
                    'value' => 0,

                );
                foreach ($distribusi_jawaban as $jawaban) {
                    if ($key['f_id'] == $jawaban['kategori']) {
                        $rowKategori['value'] += $jawaban['value'];
                    }
                }


                if ($rowKategori['value'] >= 10 && $rowKategori['value'] <= 17) {
                    $rowKategori['results'] = "Development Priority";
                    $rowKategori['colors'] = '#C70039';
                    $rowKategori['textcolors'] = '#000000';
                }

                if ($rowKategori['value'] >= 18 && $rowKategori['value'] <= 34) {
                    $rowKategori['results'] = "Need Attention";
                    $rowKategori['colors'] = '#F4CE14';
                    $rowKategori['textcolors'] = '#000000';
                }

                if ($rowKategori['value'] >= 35 && $rowKategori['value'] <= 50) {
                    $rowKategori['results'] = "Strength";
                    $rowKategori['colors'] = '#071952';
                    $rowKategori['textcolors'] = '#FFFFFF';
                }


                $distribusi_perkategori[] = $rowKategori;
            }

            $yourcode = sha1(md5(date('YmdHis')));
            $array = array(
                //'f_survey_demographic' => json_encode($this->session->userdata('demograp_data1')),
                // 'f_survey_demographic'    => json_encode($this->session->userdata('demograp_data2')),
                'f_survey_qopen' => json_encode($yourcode, JSON_NUMERIC_CHECK),
                'f_event_id' => $event_account['f_event_id'],
                'f_account_id' => $event_account['f_account_id'],
                'f_survey_username' => $inputData['username'], //$this->session->userdata('f_survey_username'),
                'f_survey_email' => $inputData['email'], //$this->session->userdata('f_survey_username'),
                'f_survey_password' => $yourcode,
                'f_survey_valid' => 'yes',
                //'f_template'=>$template,
                'f_survey_created_on' => ($this->session->userdata('mulai_survey')) ? $this->session->userdata('mulai_survey') : date('Y-m-d H:i:s'),
                'f_survey_created_by' => $this->session->userdata('username'),
                'f_survey_updated_on' => date('Y-m-d H:i:s'),
                'f_survey_updated_by' => $this->session->userdata('username')
            );
            $data_survey = array("distribusi_jawaban" => $distribusi_jawaban, "jawaban_perkategori" => $distribusi_perkategori);
            $convert_datasurvey = json_encode($data_survey, JSON_NUMERIC_CHECK | JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_HEX_APOS);
            $array['f_survey'] = $convert_datasurvey;


            $this->db->trans_start();
            $this->db->insert('trn_survey_empex', $array);
            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $response = ['status' => true, 'code' => '200', 'msg' => 'Berhasil submit', 'url' => $yourcode];
            } else {
                $response = ['status' => false, 'code' => '400', 'msg' => 'Gagal submit'];
            }
        }
        // var_dump($response);
        // die;

        echo json_encode($response);
    }

    function fnSaveFinish_($accountId, $aliasUrl, $eventId)
    {

        // echo "<pre>";
        // print_r($_POST);


        // die();

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Length, Content-Type, Accept, Accept-Encoding");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        //error_reporting(-1);
        //ini_set('display_errors', 1);

        //opn($_POST);
        $data[0] = $_POST['qopen'];
        $yourcode = $this->input->get('mycode');
        $array = array(
            //'f_survey_demographic' => json_encode($this->session->userdata('demograp_data1')),
            // 'f_survey_demographic'    => json_encode($this->session->userdata('demograp_data2')),
            'f_survey_qopen' => json_encode($data, JSON_NUMERIC_CHECK),
            'f_event_id' => $eventId,
            'f_account_id' => $accountId,
            'f_survey_username' => 'mustopa', //$this->session->userdata('f_survey_username'),
            'f_survey_password' => $yourcode,
            'f_survey_valid' => 'yes',
            //'f_template'=>$template,
            'f_survey_created_on' => ($this->session->userdata('mulai_survey')) ? $this->session->userdata('mulai_survey') : date('Y-m-d H:i:s'),
            'f_survey_created_by' => $this->session->userdata('f_survey_username'),
            'f_survey_updated_on' => date('Y-m-d H:i:s'),
            'f_survey_updated_by' => $this->session->userdata('f_survey_username')
        );


        for ($i = 1; $i <= 5; $i++) {
            if ($this->input->post('level' . $i)) {
                $array['f_level' . $i] = $this->input->post('level' . $i);
            }
        }


        //start
        $paham = $this->db->get('t_item_account')->result();
        $dataSoal = array();
        foreach ($paham as $a) {
            //$soal_array = json_decode($a->f_soal_array,true);
            //$jawab_benar = '';
            //foreach($soal_array as $e => $f)
            //{
            ////if($f['value'] == 1) {
            //$jawab_benar = $f['keterangan'];
            ////}
            //}
            //$namepost     = "no".$a->f_id;
            $namepost = "kondisi" . $a->f_dimensi_id . "_" . $a->f_id;
            $getpost    = ($this->input->post($namepost)) ? $this->input->post($namepost) : '0';
            //$jawab = explode('_',$getpost);
            $jawab = $getpost;
            //$jawab_1 = (str_replace("u0027","'",$jawab) == $jawab_benar) ? $jawab_benar:0;
            $dataSoal['variable'][$a->f_variabel_id][$a->f_dimensi_id][$a->f_id] = $jawab;
            $dataSoal['variable_total'][$a->f_variabel_id] += $jawab;

            $dataSoal['dimensi'][$a->f_dimensi_id][$a->f_id] = $jawab;
            $dataSoal['dimensi_total'][$a->f_dimensi_id] += $jawab;
            // $dataSoal['soal'][$a->f_dimensi_id][$a->f_id] = $jawab;
            // $dataSoal['soal_total'][$a->f_dimensi_id] += $jawab;
            $dataSoal['soal'][$a->f_id] = $jawab;
            $dataSoal['total_skor'] += $jawab;
            //$total_jawab += $jawab_1;
        }

        //opn($dataSoal);
        $array['f_survey'] = json_encode($dataSoal, JSON_NUMERIC_CHECK | JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_HEX_APOS);


        //end
        // opn($array);die();
        $this->db->insert('trn_survey_empex', $array);
        // echo $this->db->last_query().br();
        // die();
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            // $this->db->where('f_event_id', $eventId);
            // $this->db->where('f_account_id', $accountId);
            // $this->db->where('f_code', $yourcode);
            // $this->db->delete('temp_survey');
            // $this->db->where('f_code', $yourcode);
            // $this->db->delete('temp_demograp');
            echo json_encode(array('status' => 200, 'pesan' => 'OK'));
        } else {
            echo json_encode(array('status' => 500, 'pesan' => 'Terjadi kesalahan.'));
        }
        die();
        /*
        $this->db->select('f_survey_demographic,f_survey_personal, f_survey_leaderc, f_survey_leaderd');
        $this->db->where('f_event_id', $eventId);
        $this->db->where('f_account_id', $accountId);
        $this->db->where('f_code', $yourcode);
        $sql_temp = $this->db->get('temp_survey');
        //echo $this->db->last_query().br();
        if($sql_temp->num_rows()>0)
        {
            $sql_temp = $sql_temp->row();
            $demodata = $sql_temp->f_survey_demographic;
            $array['f_survey_demographic'] = ($sql_temp->f_survey_demographic) ? $sql_temp->f_survey_demographic:json_encode($this->session->userdata('demograp_data1'));
            foreach(json_decode($sql_temp->f_survey_demographic, true) as $dk => $dv) {
                $array[$dk] = $dv;
            }
            //$array['f_survey_personal'] = ($sql_temp->f_survey_personal) ? $sql_temp->f_survey_personal:NULL;
            $array['f_survey_leaderc'] = ($sql_temp->f_survey_leaderc) ? $sql_temp->f_survey_leaderc:NULL;
            $array['f_survey_leaderd'] = ($sql_temp->f_survey_leaderd) ? $sql_temp->f_survey_leaderd:NULL;
            
            //$vpersonal    = json_decode($array['f_survey_personal'],true);
            $vleaderc    = json_decode($array['f_survey_leaderc'],true);
            $vleaderd    = json_decode($array['f_survey_leaderd'],true);
            
            //$vleaderd = $data;
            //hitung total values = 30
            //if((count($vpersonal['choose'])+count($vleaderc['choose'])+count($vleaderd['choose'])) != 30 )    $array['f_survey_valid'] = 'no';
            if((count($vleaderc['choose'])+count($vleaderd['choose'])) != 20 )    $array['f_survey_valid'] = 'no';
            
            //opn($array);
            //opn($vleaderc['choose']);
            //opn($vleaderd['choose']);
            
            //die();
            $f_step = "f_step_".$step;
            $data = array(
                'f_event_id' => $eventId,
                'f_account_id' => $accountId,
                'f_step' => $step,
                'f_date' => date('Y-m-d H:i:s'),
            );
            $this->db->trans_start();
            //$this->db->insert('actconsu_log.log_ochi',$data);
            //$this->db->query("update t_event_detail set $f_step=ifnull($f_step,0)+1 where f_event_id=".$eventId);
            unset($array['f_nik']);
            unset($array['f_nama']);
            //opn($array);die();
            $this->db->insert('trn_survey',$array);
            //echo $this->db->last_query().br();
            $this->db->trans_complete();
            if($this->db->trans_status())
            {
                $this->db->where('f_event_id', $eventId);
                $this->db->where('f_account_id', $accountId);
                $this->db->where('f_code', $yourcode);
                $this->db->delete('temp_survey');
                $this->db->where('f_code', $yourcode);
                $this->db->delete('temp_demograp');
                echo json_encode(array('status'=> 200,'pesan'=>'OK'));
            }
            else
            {
                echo json_encode(array('status'=> 500,'pesan'=>'Terjadi kesalahan.'));
            }
        }
        else
        {
            echo json_encode(array('status'=> 500,'pesan'=>'Data tidak ditemukan. Harap isi dari awal.'));
        }
        */
    }

    function fnCloseSurvey($bahasa, $alias)
    {
        $search_account = $this->mo_c->alias_url($alias);
        $idAccount = $search_account['f_account_id'];
        //echo $idAccount;
        $setting = json_decode($search_account['f_setting'], true);

        $vars = array(
            'idAccount' => $idAccount,
            'sAccountId' => $idAccount,
            'nameAccount' => $search_account['f_account_name'],
            'app_title' => 'Survey',
            'page_title' => $setting['f_page_thanks'][$bahasa]['title'],
            'page_content' => $setting['f_page_thanks'][$bahasa]['content'],
            'alias_url' => $search_account['url'],
            'logo_account' => $search_account['f_account_logo'],
            'active_account' => $idAccount,
        );

        //opn($vars);
        // halaman thanks
        //$this->load->view('srv_header',$vars);
        //$this->load->view('srv_menu');
        //$account_plus = array(1736,40480);
        //if(in_array($idAccount, $account_plus))
        //{
        //$this->load->view($idAccount.'/page_thanks',$vars);
        //} else {
        $this->load->view('page_thanks', $vars);
        //}

        // menghapus session
        $currentSession = array('f_id' => '', 'f_account_id' => '', 'f_survey_username' => '', 'f_survey_password' => '');
        $this->session->unset_userdata($currentSession);
        $this->session->unset_userdata('demograp_data1');
        $this->session->unset_userdata('demograp_data2');
        $this->session->unset_userdata('saveDemograpPersonal');
        $this->session->set_userdata('ochi_survey', 'sudah');
    }

    function fnBackDemo($id = false)
    {
        $currentSession = array('f_id' => '', 'f_account_id' => '', 'f_survey_username' => '', 'f_survey_password' => '');
        $this->session->unset_userdata($currentSession);
        $this->session->unset_userdata('demograp_data1');
        $this->session->unset_userdata('demograp_data2');
        $this->session->unset_userdata('saveDemograpPersonal');
    }


    function fnSaveFinishCustomer($accountId, $aliasUrl, $eventId)
    {

        // echo "<pre>";
        // print_r($_POST);


        // opn($this->input->post());

        // var_dump($accountId, $aliasUrl, $eventId);


        $answer = array();
        $event = $this->db->get_where('t_event', ['f_event_id' => $eventId])->row();


        $this->db->select('pernyataan.f_id as f_id, pernyataan.f_variabel_id as f_variabel_id, variabel.f_variabel_name');
        $this->db->from('t_item_pernyataan pernyataan');
        $this->db->join('t_variabel variabel', 'variabel.f_id=pernyataan.f_variabel_id');
        $paham = $this->db->get()->result();

        // $variabel = $this->db->get('t_variabel')->result();
        $dataSoal = array();
        foreach ($paham as $a) {
            $namepost = "pertanyaan_" . $a->f_id;
            $getpost    = ($this->input->post($namepost)) ? $this->input->post($namepost) : '0';
            $jawab = $getpost;
            $dataSoal['variable'][$a->f_variabel_id][$a->f_id] = $jawab;
            $dataSoal['variable_total'][$a->f_variabel_id] += $jawab;
            $dataSoal['soal'][$a->f_id] = $jawab;
            $dataSoal['total_skor'] += $jawab;

            $dataSoal['variabel_name'][$a->f_variabel_name] += $jawab;
        }

        $data_chart = array();
        foreach ($dataSoal['variabel_name'] as $key => $value) {
            $row = [];
            $row['name'] = $key;
            $row['y'] = $value;
            $data_chart[] = $row;
        }

        $dataSoal['chart'] = $data_chart;


        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Length, Content-Type, Accept, Accept-Encoding");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        $data[0] = $_POST['qopen'];
        $yourcode = $this->input->get('mycode');
        $array = array(
            //'f_survey_demographic' => json_encode($this->session->userdata('demograp_data1')),
            // 'f_survey_demographic'    => json_encode($this->session->userdata('demograp_data2')),
            'f_survey_qopen' => json_encode($data, JSON_NUMERIC_CHECK),
            'f_event_id' => $eventId,
            'f_account_id' => $accountId,
            'f_survey_username' => $this->input->post('f_survey_name'), //$this->session->userdata('f_survey_username'),
            'f_survey_email' => $this->input->post('f_survey_email'),
            'f_survey_telp' => $this->input->post('f_survey_telp'),
            'f_survey_password' => $yourcode,
            'f_survey_valid' => 'yes',
            //'f_template'=>$template,
            'f_survey_created_on' => ($this->session->userdata('mulai_survey')) ? $this->session->userdata('mulai_survey') : date('Y-m-d H:i:s'),
            'f_survey_created_by' => $this->session->userdata('f_survey_username'),
            'f_survey_updated_on' => date('Y-m-d H:i:s'),
            'f_survey_updated_by' => $this->session->userdata('f_survey_username')
        );


        for ($i = 1; $i <= 5; $i++) {
            if ($this->input->post('level' . $i)) {
                $array['f_level' . $i] = $this->input->post('level' . $i);
            }
        }


        $array['f_survey'] = json_encode($dataSoal, JSON_NUMERIC_CHECK | JSON_PARTIAL_OUTPUT_ON_ERROR | JSON_HEX_APOS);

        $this->db->insert('trn_survey_empex', $array);
        $this->db->trans_complete();
        if ($this->db->trans_status()) {
            echo json_encode(array('status' => 200, 'pesan' => 'OK', 'data' => $data_chart));
        } else {
            echo json_encode(array('status' => 500, 'pesan' => 'Terjadi kesalahan.'));
        }
        die();
    }


    public function finish($survey_password)
    {
        $data = [];
        $transaksi = $this->db->get_where('trn_survey_empex', ['f_survey_password' => $survey_password])->row_array();
        $data['transaksi'] = $transaksi;
        $data['survey'] = json_decode($transaksi['f_survey'], true);
        $this->load->view('vw_finish', $data);
    }
}
