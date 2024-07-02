<?php
class Integrasi_API extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->getGKPD();
        $this->getSipaman();
    }

    public function getGKPD()
    {

        //   	$arrContextOptions=array(
        //     "ssl"=>array(
        //         "verify_peer"=>false,
        //         "verify_peer_name"=>false,
        //     ),
        // ); 
        //       $url = "https://gkpd.pom.go.id/api-gkpd/get-data?tahun=".date('Y');
        //       $get_url = file_get_contents($url, false, stream_context_create($arrContextOptions));
        //       $data = json_decode($get_url, true);

        $url = "https://gkpd.pom.go.id/api-gkpd/get-data?tahun=" . date('Y');
        //$url = "https://gkpd.pom.go.id/api-gkpd/get-data?tahun=2022";
        // $get_url = file_get_contents($url);

        $get_url = $this->file_get_contents_curl($url);
        $data = json_decode($get_url, true);

        foreach ($data['data'] as $key) {
            $row = [];
            $kader = $key['kader'];
            $komunitas = $key['komunitas'];
            $row['id_provinsi'] = $key['id_prov'];
            $row['id_kota'] = $key['id_kab'];
            $row['nama_sekolah'] = $key['nama_desa'];
            $row['tahun'] = $key['tahun'];
            $row['program'] = 'Desa Pangan';

            $row['kader_karang_taruna'] = $kader['kader_karang_taruna'];
            $row['kader_guru'] = $kader['kader_guru'];
            $row['kader_pkk'] = $kader['kader_pkk'];
            $row['kader_pramuka'] = $kader['kader_pramuka'];
            $row['kader_irt'] = $kader['kader_irt'];
            $row['kader_posyandu'] = $kader['kader_posyandu'];
            $row['kader_remaja_putri'] = $kader['null'];
            $row['kader_remaja_putra'] = $kader['kader_pembina_uks'];
            $row['kader_pembangunan_manusia'] = $kader['kader_pembangunan_manusia'];


            $row['komunitas_remaja'] = $komunitas['komunitas_remaja'];
            $row['komunitas_sekolah'] = $komunitas['komunitas_sekolah'];
            $row['komunitas_irt'] = $komunitas['komunitas_irt'];
            $row['komunitas_pelaku_usaha_ritel'] = $komunitas['komunitas_pelaku_usaha_ritel'];
            $row['komunitas_pelaku_usaha_pangan'] = $komunitas['komunitas_pelaku_usaha_pangan'];
            $row['komunitas_pelaku_usaha_siap_saji'] = $komunitas['komunitas_pelaku_usaha_siap_saji'];
            $gkpd[] = $row;
        }
        $i = 0;

        foreach ($gkpd as $key) {
            $this->db->where('tahun', $key['tahun']);
            $this->db->where('id_provinsi', $key['id_provinsi']);
            $this->db->where('id_kota', $key['id_kota']);
            $this->db->where('nama_sekolah', $key['nama_sekolah']);
            $check_data[] = $this->db->get('pmpu_rekap')->row_array();

            if ($check_data[$i]) {

                $update = [
                    'kader_karang_taruna' => intval($key['kader_karang_taruna']),
                    'kader_guru' => intval($key['kader_guru']),
                    'kader_pkk' => intval($key['kader_pkk']),
                    'kader_pramuka' => intval($key['kader_pramuka']),
                    'kader_irt' => intval($key['kader_irt']),
                    'kader_posyandu' => intval($key['kader_posyandu']),
                    'kader_remaja_putri' => intval($key['kader_remaja_putri']),
                    'kader_remaja_putra' => intval($key['kader_remaja_putra']),
                    'kader_pembangunan_manusia' => intval($key['kader_pembangunan_manusia']),


                    'komunitas_remaja' => intval($key['komunitas_remaja']),
                    'komunitas_sekolah' => intval($key['komunitas_sekolah']),
                    'komunitas_irt' => intval($key['komunitas_irt']),

                    'komunitas_pelaku_usaha_ritel' => intval($key['komunitas_pelaku_usaha_ritel']),
                    'komunitas_pelaku_usaha_pangan' => intval($key['komunitas_pelaku_usaha_pangan']),
                    'komunitas_pelaku_usaha_siap_saji' => intval($key['komunitas_pelaku_usaha_siap_saji']),

                ];

                $this->db->where('id_sekolah_intervensi', $check_data[$i]['id_sekolah_intervensi']);
                $this->db->update('pmpu_rekap', $update);
            } else {
                $this->db->insert('pmpu_rekap', $key);
            }
            $i++;
        }
    }


    public function getSipaman()
    {
        $url = "https://sipaman.pom.go.id/api/rekap-data?key=35e3a094e117dcfd66bd2d388b34c07877a464a1&tahun=" . date('Y');
        //$url = "https://gkpd.pom.go.id/api-gkpd/get-data?tahun=2022";
        $get_url = $this->file_get_contents_curl($url);

        // $get_url = file_get_contents($url);
        $data = json_decode($get_url, true);


        if ($data['status'] == 'success') {
            $provinsi = array();
            foreach ($data['data'] as $elemen) {
                $kunci = $elemen['id_provinsi'];
                if (!isset($provinsi[$kunci])) {
                    $provinsi[$kunci] = array();
                }
                $provinsi[$kunci][] = $elemen;
            }

            $final = array();
            foreach ($provinsi as $key) {
                foreach ($key as $keyy) {
                    $row = [];
                    $row['id_provinsi'] = $keyy['id_provinsi'];
                    $row['id_kota'] = $keyy['id_kota'];
                    $row['tahun'] = $keyy['tahun_intervensi'];

                    foreach ($keyy['rekap'] as $rekap) {
                        $row['nama_sekolah'] = $rekap['nama_pasar'];
                        $row['jml_fasilitator_pasar'] = $rekap['jumlah_fasilitator'];
                        $row['jml_kader_pasar'] = $rekap['jumlah_kader'];
                        $row['jml_penyuluhan_pasar'] = $rekap['jumlah_penyuluhan'];
                        $row['program'] = 'PABB';
                        $final[] = $row;
                    }
                }
            }

            $i = 0;
            foreach ($final as $key) {
                $this->db->where('tahun', $key['tahun']);
                $this->db->where('id_provinsi', $key['id_provinsi']);
                $this->db->where('id_kota', $key['id_kota']);
                $this->db->where('nama_sekolah', $key['nama_sekolah']);
                $check_data[] = $this->db->get('pmpu_rekap')->row_array();

                if ($check_data[$i]) {

                    $update = [
                        'jml_fasilitator_pasar' => intval($key['jml_fasilitator_pasar']),
                        'jml_kader_pasar' => intval($key['jml_kader_pasar']),
                        'jml_penyuluhan_pasar' => intval($key['jml_penyuluhan_pasar']),

                    ];

                    $this->db->where('id_sekolah_intervensi', $check_data[$i]['id_sekolah_intervensi']);
                    $this->db->update('pmpu_rekap', $update);
                } else {
                    $this->db->insert('pmpu_rekap', $key);
                }
                $i++;
            }
        }
    }


    function file_get_contents_curl($url)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}
