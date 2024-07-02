<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('array_sort')) {
    function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
}

if (!function_exists('replacer')) {
    function replacer(&$item, $key)
    {
        if ($item === null) {
            $item = 0;
        }
    }
}

if (!function_exists('persenan')) {
    function persenan(&$item, $key, $divider)
    {
        $item = round($item * 100 / $divider, 0);
    }
}

if (!function_exists('makeInt')) {
    function makeInt($angka)
    {
        if ($angka < -0.0000001) {
            return ceil($angka - 0.0000001);
        } else {
            return floor($angka + 0.0000001);
        }
    }
}

if (!function_exists('enambulan')) {
    function enambulan($in)
    {
        $n = 180;
        $tgl = substr($in, 8, 2);
        $bln = substr($in, 5, 2);
        $thn = substr($in, 0, 4);

        $nextN = mktime(0, 0, 0, $bln, makeInt($tgl) + $n, $thn);
        $hasil = date("Y-m-d", $nextN);
        return $hasil;
    }
}

if (!function_exists('resultPlot')) {
    function resultPlot($val, $status = 1)
    {
        if ($status == 1) {
            $sort = array_sort($val, 'value_priot', SORT_DESC);
        } else {
            $sort = array_sort($val, 'value_count', SORT_DESC);
        }
        // mengambil 10 value prioritas terbanyak
        $output = array_slice($sort, 0, 10);
        return $output;
    }
}

if (!function_exists('resultDistribution')) {
    function resultDistribution($val = array(), $status = 1, $responden = null)
    {
        //echo "<pre>";echo count($val)."</pre><br/>";
        //echo "<pre>";echo print_r($val)."</pre><br/>";
        /*
         * status = 1 , maka perhitungan bobot
         * status = 2 , maka perhitungan vote
        */
        $ci = &get_instance();
        $ci->load->database();
        $color = $ci->db->get('table_color')->result_array();
        $i = 0;
        foreach (array_sort($color, 'f_color_id', SORT_DESC) as $r) {
            $nameColor[$i] = $r['f_color_name'];
            $codeColor[$i] = $r['f_color_code'];
            $idColor[$i] = $r['f_color_id'];
            $i++;
        }

        $po = array('name' => 'Positif', 'color' => '#0E35FF');
        $li = array('name' => 'Limit', 'color' => '#525252');
        $ba['name'] = 'batas';
        $po_bb = array();
        $po_vt = array();
        $li_bb = array();
        $li_vt = array();
        $ttl = 0;
        foreach ($codeColor as $a => $b) {
            foreach ($val as $key => $row) {
                //if($row['value_status'] == 'limit')
                //{
                ////$ttl += $row['value_count'];
                //}

                if ($row['color_code'] == $b && $row['value_status'] == 'positif') {
                    $po['data'][$a]['color']    = $b;
                    $po['data'][$a]['y']         += 1;
                    $po_bb[$a]                    += $row['value_bobot'];
                    $po_vt[$a]                    += $row['value_count'];
                }
                //else
                //{
                //$po['data'][$a]['color']     = '#000';
                //$po['data'][$a]['y']         +=0;
                //$po_bb[$a]                    += 0;
                //$po_vt[$a]                    += 0;
                //}

                if ($row['color_code'] == $b && $row['value_status'] == 'limit') {
                    $ttl += $row['value_count'];
                    $li['data'][$a]['color']     = '#000';
                    $li['data'][$a]['y']         += 1;
                    $li_bb[$a]                    += $row['value_bobot'];
                    $li_vt[$a]                    += $row['value_count'];
                } else {
                    $li['data'][$a]['color']     = '#000';
                    $li['data'][$a]['y']         += 0;
                    $li_bb[$a]                    += 0;
                    $li_vt[$a]                    += 0;
                }
            } // end foreach $arr;
        } // end foreach $codeColor;

        //echo "<pre>PO ";echo print_r($po)."</pre><br/>";
        //echo "<pre>";echo print_r($li_vt)."</pre><br/>";

        //for($i=0;$i<6;$i++)    {
        //foreach($val as $key => $row):
        //if( $row['color_code'] == $color[$i]['f_color_code'] && $row['value_status'] == 'positif' ) {
        //$po['data'][$i]['name']        = $row['color_name'];
        //$po['data'][$i]['color']    = $row['color_code'];
        //$po_bb[$i]                    += $row['value_bobot'];
        //$po_vt[$i]                    += $row['value_count'];
        //}
        //elseif( $row['color_code'] == $color[$i]['f_color_code'] && $row['value_status'] == 'limit')    {
        //$li['data'][$i]['name']        = $row['color_name'];
        //$li['data'][$i]['color']    = '#000000';    //$row['color_code'];
        //$li_bb[$i]                    += $row['value_bobot'];
        //$li_vt[$i]                    += $row['value_count'];

        //}
        //else { }
        //endforeach;
        //}

        foreach ($codeColor as $a => $b) {
            $po['data'][$a]['color']     = $b;
            $li['data'][$a]['color']     = '#000';
            if ($status == 1) {
                //$po['data'][$a]['y']        = round(($po_bb[$a] * 100) / $val[0]['total_bobot'],2);
                //$li['data'][$a]['y']        = round(($li_bb[$a] * 100) / $val[0]['total_bobot'],2);
                $po['data'][$a]['y']        = round(($po_bb[$a] / $val[0]['total_bobot']) * 100, 1);
                $li['data'][$a]['y']        = round(($li_bb[$a] / $val[0]['total_bobot']) * 100, 1);
            } elseif ($status == 2) {
                //echo $li_vt[$a].' - '.$val[0]['total_vote']."<br/>";
                //$po['data'][$a]['y']        = round(($po_vt[$a] * 100) / $val[0]['total_vote'],2);
                //$li['data'][$a]['y']        = round(($li_vt[$a] * 100) / $val[0]['total_vote'],2);
                $po['data'][$a]['y']        = round(($po_vt[$a] / $val[0]['total_vote']) * 100, 1);
                $li['data'][$a]['y']        = round(($li_vt[$a] / $val[0]['total_vote']) * 100, 1);
            } else {
            }
        }

        $sort = array_slice(array_sort($po['data'], 'y', SORT_DESC), 0, 1);
        $y = $sort[0]['y'];
        if ($y >= 0 && $y <= 35) {
            $batas = 35;
        } elseif ($y >= 36 && $y <= 70) {
            $batas = 70;
        } else {
            $batas = 100;
        }
        /*
        foreach($po['data'] as $k => $r):
            $ba['data'][$k]['name']            = 'white';
            $ba['data'][$k]['color']        = 'transparent';
            $ba['data'][$k]['y']             = ($batas-$r['y']);
        endforeach;
*/
        for ($k = 0; $k < 6; $k++) {
            $selisih = ($po['data'][$k]['y']) ? $po['data'][$k]['y'] : 0;
            $ba['data'][$k]['name']            = $color[$k]['f_color_name'];
            $ba['data'][$k]['color']        = 'transparent';
            $ba['data'][$k]['y']             = ($batas - $selisih);
        }

        $rslt = array();
        //array_push($rslt,$ba);
        array_push($rslt, $li);
        array_push($rslt, $po);

        //foreach($rslt as $k => $r):
        //$source[] = array(
        //'name' => $r['name'],
        //'data' => array($r['data'][0],$r['data'][1],$r['data'][2],$r['data'][3],$r['data'][4],$r['data'][5])
        //);
        //endforeach;

        //// return array
        //return $source;
        return array('kategori' => $nameColor, 'series' => $rslt, 'total' => $ttl);
    }
}

if (!function_exists('resultValueJump')) {
    function resultValueJump($val, $status = 1)
    {
        /*
         * status = 1 , maka perhitungan bobot
         * status = 2 , maka perhitungan vote
        */
        if ($status == 1) {
            $sort = array_sort($val, 'value_bobot', SORT_DESC);
        } else {
            $sort = array_sort($val, 'value_count', SORT_DESC);
        }
        // mengambil 10 value prioritas terbanyak
        $output = array_slice($sort, 0, 100);
        return $output;
    }
}

if (!function_exists('resultValueJumpMerge')) {
    function resultValueJumpMerge($val_cca, $val_dca, $status = 1)
    {
        // pembacaan values di dca
        $_values_jump = array();
        if ($status == 1) {
            foreach ($val_dca as $d) :
                foreach ($val_cca as $c) :
                    // membentuk array lompatan_nilai
                    if ($c['value_id'] == $d['value_id'] and $c['value_bobot'] < $d['value_bobot']) {
                        $_values_jump[] = array(
                            'value_id' => $d['value_id'],
                            'value_name' => $d['value_name'],
                            'value_count_cc' => $c['value_bobot'],
                            'value_count_dc' => $d['value_bobot'],
                            'value_jump'    => intval($d['value_bobot'] - $c['value_bobot'])
                        );
                    }
                endforeach;
            endforeach;
        } else {
            foreach ($val_dca as $d) :
                foreach ($val_cca as $c) :
                    // membentuk array lompatan_nilai
                    if ($c['value_id'] == $d['value_id'] and $c['value_count'] < $d['value_count']) {
                        $bobot_cc = round($c['value_bobot'] / $c['value_count'], 1);
                        $bobot_dc = round($d['value_bobot'] / $d['value_count'], 1);
                        $_values_jump[] = array(
                            'value_id' => $c['value_id'],
                            'value_name' => $c['value_name'],
                            'value_count_cc' => $c['value_count'],
                            'value_bobot_cc' => $bobot_cc,
                            'value_count_dc' => $d['value_count'],
                            'value_bobot_dc' => $bobot_dc,
                            'value_jump'    => intval($d['value_count'] - $c['value_count']),
                            'value_jump_bobot'    => $bobot_dc - $bobot_cc
                        );
                    }
                endforeach;
            endforeach;
        }

        // Sortir dari yang terbanyak
        foreach ($_values_jump as $key => $row) :
            $jump[$key]  = $row['value_jump'];
        endforeach;

        array_multisort($jump, SORT_DESC, $_values_jump);

        $_values_jump = array_sort($_values_jump, 'value_jump', SORT_DESC);
        // mengambil 10 value terbanyak
        $output_jump = array_slice($_values_jump, 0, 10);
        return     $output_jump;
    }
}

if (!function_exists('button_espoused')) {
    function button_espoused($id, $value)
    {
        if ($value == 'yes') {
            $btn = '<a href="' . site_url('ochi/md_eva/fnUnsetEva/' . $id) . '" class="btn btn-sm btn-warning"><i class="fa fa-minus-square"></i> Unset</a>';
        } else {
            $btn = '<a href="' . site_url('ochi/md_eva/fnSetEva/' . $id) . '" class="btn btn-sm btn-primary"><i class="fa fa-check-square"></i> Set</a>';
        }

        return $btn;
    }
}

if (!function_exists('array_column')) {
    /**
     * This file is part of the array_column library
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     *
     * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
     * @license http://opensource.org/licenses/MIT MIT
     *
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }
        if (
            !is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (
            isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}

if (!function_exists('data_list')) {
    function data_list($table, $id, $list, $wh = array())
    {
        $ci = &get_instance();
        $ci->load->database();
        //        $ci->db->select("$id,$list",false);
        if (!is_array($wh)) $ci->db->where($wh);
        $sql = $ci->db->get($table)->result();
        foreach ($sql as $row) :
            $list[$row->$id] = $row->$list;
        endforeach;
        return $list;
    }
}

function getColor($num)
{
    $hash = md5('color' . $num);
    return array(hexdec(substr($hash, 0, 2)), hexdec(substr($hash, 2, 2)), hexdec(substr($hash, 4, 2)));
}

function survey_pemahaman()
{
    $ci = &get_instance();
    $ci->load->database();

    $soal = $ci->db->get('t_soal_area_pemahaman')->result_array();

    $html = "";
    $bagi = 5;
    $count_soal = count($soal);
    $real_hasil_bagi = ($count_soal / $bagi);
    $hasil_bagi = ceil($count_soal / $bagi);
    $hasil_bagi_lagi = ceil($hasil_bagi / 2) + 1;

    //echo $hasil_bagi_lagi;
    $html .= "<div class=\"step\">
            <div class=\"row\" style=\"font-size: 15pt;\">
                <div class=\"col-md-12\">
                ";

    $a = 0;
    $i = 1;
    $k = 1; //shuffle($soal);
    foreach ($soal as $s) {
        $html .= "
                <div class=\"form-group row\">
                    <p class=\"col-md-1 col-xs-1\">$i.</p>
                    <p class=\"col-md-11 col-xs-10\">" . $s['f_soal_name'] . " </p>
                    <div class=\"offset-md-1 col-md-11\">
                    ";

        $jwb = json_decode($s['f_soal_array'], true);
        //echo "<pre>";echo print_r($jwb)."</pre><br/>";
        if ($s['f_soal_type'] == 'text') {
            $html .= "<input type=\"text\" name=\"no" . $s['f_soal_id'] . "\" id=\"no" . $s['f_soal_id'] . "\" class=\"form-control\" placeholder=\"Jawab ... \" required>";
        } else if ($s['f_soal_type'] == 'textarea') {
            $html .= "<textarea name=\"no" . $s['f_soal_id'] . "\" id=\"no" . $s['f_soal_id'] . "\"></textarea>";
        } else if ($s['f_soal_type'] == 'checkbox') {
            $j = 1;
            foreach ($jwb as $c) {
                $html .= "<input type=\"checkbox\" name=\"no" . $s['f_soal_id'] . "\" id=\"no" . $s['f_soal_id'] . "\" value=\"" . $j . "_" . $c['keterangan'] . "\" required>  " . $c['keterangan'] . "<br/>";
                $j++;
            }
        } else if ($s['f_soal_type'] == 'radio') {
            $j = 1;
            //$html .= "<ul class=\"list-unstyled\">";
            foreach ($jwb as $c) {
                $html .= "<input type=\"radio\" name=\"no" . $s['f_soal_id'] . "\" id=\"no" . $s['f_soal_id'] . "\" class=\"icheck required\" value=\"" . $j . "_" . $c['keterangan'] . "\" required>  " . $c['keterangan'] . "<br/>";
                $j++;
            }
            //$html .= "</ul>";
        }
        $html .= "
                    </div>
                </div>
                <div class=\"pesan_no" . $s['f_soal_id'] . "\"></div>
            ";

        $a++;
        $i++;
        $k++;
    }

    $html .= "
                </div>
            </div>
        </div>
        "; // end .step

    return $html;
}

function survey_penerimaan($account_id)
{
    $ci = &get_instance();
    $kategori = $ci->db->get('t_variabel')->result();
    $soal = $ci->db->get('t_dimensi')->result();
    //$soal = $ci->db->where('f_account_id',$ci->session->userdata('namecom'))->get('trn_soal')->result_array();
    $ci->db->where('f_account_id', $account_id);
    $ci->db->where('f_active', 1);
    $sub_soal = $ci->db->get('t_item_account')->result_array();

    $combine_kat = array();
    foreach ($kategori as $b) {
        $combine_kat[$a->f_id] = $a->f_variabel_name;
    }
    $combine_soal = array();
    foreach ($soal as $b) {
        $combine_soal[$b->f_variabel_id][$b->f_id] = $b->f_dimensi_name;
    }
    foreach ($sub_soal as $a => $b) {
        $combine[$b['f_dimensi_id']][] = $b;
    }

    //echo "<pre>";echo print_r($kategori)."</pre><br/>";
    //echo "<pre>";echo print_r($combine_soal)."</pre><br/>";
    //echo "<pre>";echo print_r($combine)."</pre><br/>";
    //die();
    $html = "";

    $detail = array(
        '1' => 'Sangat tidak setuju',
        '2' => 'Tidak setuju',
        '3' => 'Kurang setuju',
        '4' => 'Cukup setuju',
        '5' => 'Setuju',
        '6' => 'Sangat setuju',
    );

    // echo "<pre>";
    // print_r($kategori);
    // print_r($combine_soal);
    // print_r($combine);
    // die();

    foreach ($kategori as $a) {
        $html .= "<div class=\"step kat_" . $a->f_id . "\">";
        $ol = 1;
        $i = 1;
        foreach ($combine_soal[$a->f_id] as $b => $c) {
            //$html .= "<ol start='$ol'>";
            //$html .= "<li>";
            //$html .= "<p class=\"lead\">$i. $c</p>";
            foreach ($combine[$b] as $r) {


                $html .= "<div class=\"form-group row\">";
                $html .= "<p class=\"col-md-12\">" . $r['f_item_name'] . " </p>";
                $html .= "<div class=\"col-md-offset-1 col-md-9\">";

                $nameid = "kondisi" . $r['f_dimensi_id'] . "_" . $r['f_id'];
                //echo $nameid.br();
                for ($b = 1; $b <= 6; $b++) {
                    $html .= "
                    <div class=\"col-md-12 col-xs-2\" align=\"left\" style=\"margin: 10px 0px 10px 0px\">
                        <input id=\"" . $nameid . "\" name=\"" . $nameid . "\" type=\"radio\" value=\"" . $b . "\" class=\"icheck required\" />&nbsp;&nbsp;&nbsp;" . $detail[$b] . "
                    </div> <!-- end col skala -->";
                }
                $html .= "<div class=\"col-md-12 pesan_no" . $nameid . "\"></div><div class=\"clearfix\">&nbsp;</div><br/>";

                $html .= "</div>";
                $html .= "</div> <!-- form-group row -->";
            }
            //$html .= "</li>";
            //$html .= "</ol>";
            $ol++;
            $i++;
        }
        $html .= "</div> <!-- end step " . $a->f_id . " -->";
    }

    /*
    foreach($soal as $a)
    {
        //$a->f_question
        $html .= "<div class=\"step\">
                <p class=\"lead\">".$a->f_question."</p><br/>
                <div class=\"row\" style=\"font-size: 15pt;\">
                    <div class=\"col-md-12\">
        ";
        $i=1;
        $ol=1;
        $html .= "<ol start='$ol'>";
        foreach($combine[$a->f_id] as $b)
        {
            $html .= "<li ><div class=\"row\">";
            $html .= "<div class='col-md-12' style=\"margin-top: -20px;\">";
            $html .= $b['f_sub_soal']."</div>";
            //if($i > 10)    $html .= "</div><div class=\"col-md-6\">";
                
            //$html .= "
                    //<div class=\"form-group\">
                        //<p class=\"col-md-12\">$i. ".$b['f_soal_name']." </p>
                        //<div class=\"col-md-offset-1 col-md-9\">
            //";
            ////$jwb = unserialize($b['f_soal_array']);
            $jwb = json_decode($b['f_soal_array'],true);
            //echo "<pre>";echo print_r($jwb)."</pre><br/>";
            if($b['f_soal_type'] == 'text')
            {
                $html .= "<input type=\"text\" name=\"no".$b['f_id']."\" id=\"no".$b['f_id']."\" class=\"form-control\" placeholder=\"Jawab ... \" required>";
            }
            else if($b['f_soal_type'] == 'textarea')
            {
                $html .= "<textarea name=\"no".$b['f_id']."\" id=\"no".$b['f_id']."\"></textarea>";
            }
            else if($b['f_soal_type'] == 'checkbox')
            {
                $j=1;
                foreach($jwb as $c)
                {
                    $html .= "<input type=\"checkbox\" name=\"no".$b['f_id']."\" id=\"no".$b['f_id']."\" value=\"".$j."_".$c['keterangan']."\" required>  ".$c['keterangan']."<br/>";
                    $j++;
                }
            }
            else if($b['f_soal_type'] == 'radio')
            {
                $j=1;$tjawab = count($jwb);
                $col = 12;
                if($tjawab < 3) $col = 3;
                foreach($jwb as $c)
                {
                    $html .= "<div class='col-md-$col'><input type=\"radio\" name=\"no".$b['f_id']."\" id=\"no".$j."_".$b['f_id']."\" class=\"icheck required\" value=\"".$c['keterangan']."\" >  ".$c['keterangan']."</div>";
                    $j++;
                }
            }
            $nameid = "kondisi".$b['f_soal_id']."_".$b['f_id'];
            for($b=1;$b<=5;$b++) {
                $html .="
                <div class=\"col-md-12 col-xs-2\" align=\"left\" style=\"margin: 10px 0px 10px 0px\">
                    <input id=\"".$nameid."\" name=\"".$nameid."\" type=\"radio\" value=\"".$b."\" class=\"icheck required\" />&nbsp;&nbsp;&nbsp;".$detail[$b]."
                </div> <!-- end col skala -->";
            }
            
                $html .= "
                        <br/><div class=\"col-md-12 pesan_no".$nameid."\"></div><div class=\"clearfix\">&nbsp;</div><br/>
                    ";

            $html .= "</div></li>";

            $i++;
            $ol++;
        }
        $html .= "</ol>";
        $html .= "
                    </div>
                </div>
            ";
        $html .= "</div>"; // end .step
    }*/

    return $html;
}


function customer_experience($kode_event)
{

    $ci = &get_instance();
    // Get event
    $ci->db->where('f_event_kode', $kode_event);
    $event_survey = $ci->db->get('t_event')->row_array();


    // get dimensi
    $ci->db->where('f_variabel_id', $event_survey['f_variabel_id']);
    $ci->db->order_by('f_id', 'DESC');
    $dimensi = $ci->db->get('t_dimensi')->result_array();
    // get pernyataan
    $ci->db->select('a.f_item_name, a.f_dimensi_id, a.f_id, a.f_item_array, b.f_dimensi_name, b.f_item_dimensi, b.f_id as f_id_dimensi');
    $ci->db->from('t_item_pernyataan a');
    $ci->db->join('t_dimensi b', 'b.f_id=a.f_dimensi_id');
    $ci->db->where('a.f_variabel_id', $event_survey['f_variabel_id']);
    $pernyataan =   $ci->db->get()->result_array();

    // var_dump($pernyataan);
    // die;

    $groupedData = array();
    foreach ($pernyataan as $key) {
        $category = $key['f_id_dimensi'];
        if (!isset($groupedData[$category])) {
            $groupedData[$category] = [];
        }
        $groupedData[$category]['f_id_dimensi'] = $category;
        $groupedData[$category]['f_item_dimensi'] = $key['f_item_dimensi'];
        $groupedData[$category]['f_dimensi_name'] = $key['f_dimensi_name'];
        $groupedData[$category]['item'][] = $key;
    }

    // print("<pre>" . print_r($groupedData, true) . "</pre>");
    // die;

    // Array grup baru
    // $groupedData = [];

    // // Mengelompokkan array berdasarkan kategori
    // foreach ($pernyataan as $item) {
    //     $category = $item['f_dimensi_id'];

    //     if (!isset($groupedData[$category])) {
    //         $groupedData[$category] = [];
    //     }

    //     $groupedData[$category][] = $item;
    // }


    // var_dump($groupedData);
    // print("<pre>" . print_r($groupedData, true) . "</pre>");

    $html = '';
    $count = 1;
    foreach ($groupedData as $key) {

        // print("<pre>" . print_r($key, true) . "</pre>");

        if ($key['f_id_dimensi'] == 12 || $key['f_id_dimensi'] == 18) {
            $html .= "<div class=\"step kat_" . $count . "\">";
            $html .= "<div class=\"table-responsive\">";
            $html .= "<table class=\"table\" style=\"width:100%\">";
            $html .= "<tr><td colspan=\"8\">" . $key['f_item_dimensi'] . "</td></tr>";
            foreach ($key['item'] as $keyy) {
                // print("<pre>" . print_r($keyy, true) . "</pre>");

                $html .=  "<div class=\"row align-items-center\">";
                $html .= "<tr>";
                foreach (json_decode($keyy['f_item_array'], true) as $selected) {
                    $random = rand(10, 10000);
                    // print("<pre>" . print_r($selected['value'], true) . "</pre>");

                    $html .=  "<td style=\"text-align:center !important; vertical-align:middle !important; border:1px solid #E1E1E1; height:90px !important;\">";
                    $html .= "<div class=\"form-check controls\" style=\"margin:0 !important; padding:0 !important\">";

                    if ($selected['value'] == 1 || $selected['value'] == 6) {
                        $html .= "<label class=\"radio\"><input class=\"radio-button icheck required\" type=\"radio\" name=\"pertanyaan_" . $keyy['f_id'] . "\" id=\"pertanyaan_" . $keyy['f_id'] . "\" value=\"" . $selected['keterangan'] . "\" >" . $selected['keterangan'] . "</label>";
                    } else {
                        $html .= "<label class=\"radio\"><input class=\"radio-button icheck required\" type=\"radio\" name=\"pertanyaan_" . $keyy['f_id'] . "\" id=\"pertanyaan_" . $keyy['f_id'] . "\" value=\"" . $selected['keterangan'] . "\" ></label>";
                    }
                    $html .= "</div>";
                    $html .= "</td>";
                }
                $html .= "</tr>";
                $html .= "</div>";
            }
            $html .= "</table>";
            $html .= "</div>";
            $html .= "</div> <!-- end step " . $count . " -->";
        } else {
            $html .= "<div class=\"step kat_" . $count . "\">";
            $html .= "<div class=\"table-responsive\">";
            $html .= "<table class=\"table\" style=\"width:100%\">";
            $html .= "<tr><td colspan=\"8\" style=\"border:none !important;\">" . $key['f_item_dimensi'] . "</td></tr>";
            $html .= "<tr><td colspan=\"8\" style=\"border:none !important;\"></td></tr>";
            $html .= "<tr style=\"text-align:center;vertical-align:middle;\">
                                <th style=\"border:none !important; border:none !important\">&nbsp</th>
                                <th style=\"width:30%; border:none !important; border:none !important\">&nbsp</th>
                                <td style=\"background-color:#e5eaf4 !important; border:1px solid #E1E1E1\">Sangat tidak setuju</td>
                                <td style=\"background-color:#e5eaf4 !important; border:1px solid #E1E1E1\">Tidak setuju</td>
                                <td style=\"background-color:#e5eaf4 !important; border:1px solid #E1E1E1\">Agak tidak setuju</td>
                                <td style=\"background-color:#e5eaf4 !important; border:1px solid #E1E1E1\">Agak setuju</td>
                                <td style=\"background-color:#e5eaf4 !important; border:1px solid #E1E1E1\">Setuju</td>
                                <td style=\"background-color:#e5eaf4 !important; border:1px solid #E1E1E1\">Sangat setuju</td>
                            </tr>";
            $num = 1;
            foreach ($key['item'] as $keyy) {
                // print("<pre>" . print_r($keyy, true) . "</pre>");

                $html .=  "<div class=\"row align-items-center\">";
                $html .= "<tr>";
                $html .= "<td style=\"text-align:center;vertical-align:middle; background-color:#e5eaf4; border:1px solid #E1E1E1 !important\">" . $num . "</td>";
                $html .= "<td style=\"background-color:#e5eaf4; border:1px solid #E1E1E1 !important\">" . $keyy['f_item_name'] . "</td>";
                foreach (json_decode($keyy['f_item_array'], true) as $selected) {
                    $random = rand(10, 10000);
                    $html .=  "<td style=\"text-align:center !important; vertical-align:middle !important; border:1px solid #E1E1E1\">";
                    $html .= "<div class=\"form-check\" style=\"margin:0 !important; padding:0 !important\">
                        <input class=\"radio-button icheck required\" type=\"radio\" name=\"pertanyaan_" . $keyy['f_id'] . "\" id=\"pertanyaan_" . $keyy['f_id'] . "\" value=\"" . $selected['keterangan'] . "\" >";

                    $html .= "</div>";
                    $html .= "</td>";
                }
                $num++;
                $html .= "</tr>";
                $html .= "</div>";
            }
            $html .= "</table>";
            $html .= "</div>";
            $html .= "</div> <!-- end step " . $count . " -->";
            $count++;
        }
    }

    return $html;

    // return "<div class=\"step kat_0\"></div>";
}

function motive($kode_event)
{

    $ci = &get_instance();
    // Get event
    $ci->db->where('f_event_kode', $kode_event);
    $event_survey = $ci->db->get('t_event')->row_array();

    // get pernyataan
    $ci->db->select('a.f_item, a.f_id');
    $ci->db->from('t_item_pernyataan a');
    $pernyataan =   $ci->db->get()->result_array();

    $html = '';
    $count = 1;

    $html .= "<div data-aos=\"fade-left\" class=\"step kat_" . $count . "\">";
    $html .= "<table class=\"table\">";
    foreach ($pernyataan as $key) {
        $html .= "<tr style=\"height:80px\">
                <td class=\"fw-medium\">" . $key['f_item'] . "</td>
                <td><input id=\"chck" . $key['f_id'] . "\" type=\"checkbox\" name=\"pertanyaan_" . $key['f_id'] . "\" value=\"1\">
                <label for=\"chck" . $key['f_id'] . "\" class=\"check-trail\">
                <span class=\"check-handler\"></span>
                </label></td>
            </tr>";
    }
    $html .= "</table>";
    $html .= "</div> <!-- end step " . $count . " -->";
    return $html;

    // return "<div class=\"step kat_0\"></div>";
}
