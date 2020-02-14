<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Administrasi_Controller {

    private $pdd = 'buku_induk_penduduk';

    public function index() {
        $information_age = $this->get_information_age();
        $information_village = $this->get_information_village();
        $information_education = $this->get_information_education();
        $information_occupation = $this->get_information_occupation();
        $information_marital = $this->get_information_marital();
        $information_religion = $this->get_information_religion();

        $view = array(
            'isi'   => ADMINISTRASI_URL.'/home/main',
            'information_age' => $information_age,
            'information_village' => $information_village,
            'information_education' => $information_education,
            'information_occupation' => $information_occupation,
            'information_marital' => $information_marital,
            'information_religion' => $information_religion,
        );

        $this->_view(ADMINISTRASI_URL, $view);
    }

    public function get_statistik() {
        $chart = array();

        $chart['dusun'] = array();
        $dusun = $this->crud->gao('md_dusun', 'id ASC');
        foreach ($dusun as $row) {
            if (!$row->id) continue;
            array_push($chart['dusun'], array(
                'label'     => $row->nama,
                'male'      => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_dusun' => $row->id]) * -1,
                'female'    => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_dusun' => $row->id])
            ));
        }

        $chart['pendidikan_terakhir'] = array();
        $pendidikan_terakhir = $this->crud->gao('md_pendidikan_terakhir', 'id DESC');
        foreach ($pendidikan_terakhir as $row) {
            if (!$row->id) continue;
            array_push($chart['pendidikan_terakhir'], array(
                'label'     => $row->nama,
                'male'      => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_pendidikan_terakhir' => $row->id]) * -1,
                'female'    => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_pendidikan_terakhir' => $row->id])
            ));
        }

        $chart['pekerjaan'] = array();
        $pekerjaan = $this->crud->gao('md_pekerjaan', 'id DESC');
        foreach ($pekerjaan as $row) {
            if (!$row->id) continue;
            $male = $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_pekerjaan' => $row->id]) * -1;
            $female = $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_pekerjaan' => $row->id]);

            if ($male OR $female) {
                array_push($chart['pekerjaan'], array(
                    'label'     => $row->nama,
                    'male'      => $male,
                    'female'    => $female
                ));
            }
        }

        $chart['status_perkawinan'] = array();
        $status_perkawinan = $this->crud->gao('md_status_perkawinan', 'id DESC');
        foreach ($status_perkawinan as $row) {
            if (!$row->id) continue;
            array_push($chart['status_perkawinan'], array(
                'label'     => $row->nama,
                'male'      => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_status_perkawinan' => $row->id]) * -1,
                'female'    => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_status_perkawinan' => $row->id])
            ));
        }

        $chart['agama'] = array();
        $agama = $this->crud->gao('md_agama', 'id DESC');
        foreach ($agama as $row) {
            if (!$row->id) continue;
            array_push($chart['agama'], array(
                'label'     => $row->nama,
                'male'      => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_agama' => $row->id]) * -1,
                'female'    => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_agama' => $row->id])
            ));
        }

        $chart['umur'] = array();
        $i = 85;
        array_push($chart['umur'], array(
            'label'     => $i.'+',
            'male'      => $this->db->select('*')->where('id_jenis_kelamin', '1')->where("DATE_FORMAT(tanggal_lahir,'%Y') <=", (date('Y')-$i))->get($this->pdd)->num_rows() * -1,
            'female'    => $this->db->select('*')->where('id_jenis_kelamin', '2')->where("DATE_FORMAT(tanggal_lahir,'%Y') <=", (date('Y')-$i))->get($this->pdd)->num_rows()
        ));
        for ($i -= 5; $i >= 0; $i--) {
            array_push($chart['umur'], array(
                'label'     => $i.'-'.($i+4),
                'male'      => $this->db->select('*')->where('id_jenis_kelamin', '1')->where("DATE_FORMAT(tanggal_lahir,'%Y') <=", (date('Y')-$i))->where("DATE_FORMAT(tanggal_lahir,'%Y') >=", (date('Y')-$i-4))->get($this->pdd)->num_rows() * -1,
                'female'    => $this->db->select('*')->where('id_jenis_kelamin', '2')->where("DATE_FORMAT(tanggal_lahir,'%Y') <=", (date('Y')-$i))->where("DATE_FORMAT(tanggal_lahir,'%Y') >=", (date('Y')-$i-4))->get($this->pdd)->num_rows()
            ));
            $i -= 4;
        }

        $this->_response(['success' => TRUE, 'data' => $chart]);
    }

    public function get_information_age() {
        $checkQuery = $this->db->select('*')->get($this->pdd)->num_rows();

        $chart['umur'] = array();
        $i = 85;
        array_push($chart['umur'], array(
            'label'     => $i.'+',
            'male'      => $this->db->select('*')->where('id_jenis_kelamin', '1')->where("DATE_FORMAT(tanggal_lahir,'%Y') <=", (date('Y')-$i))->get($this->pdd)->num_rows(),
            'female'    => $this->db->select('*')->where('id_jenis_kelamin', '2')->where("DATE_FORMAT(tanggal_lahir,'%Y') <=", (date('Y')-$i))->get($this->pdd)->num_rows()
        ));
        for ($i -= 5; $i >= 0; $i--) {
            array_push($chart['umur'], array(
                'label'     => $i.'-'.($i+4),
                'male'      => $this->db->select('*')->where('id_jenis_kelamin', '1')->where("DATE_FORMAT(tanggal_lahir,'%Y') <=", (date('Y')-$i))->where("DATE_FORMAT(tanggal_lahir,'%Y') >=", (date('Y')-$i-4))->get($this->pdd)->num_rows(),
                'female'    => $this->db->select('*')->where('id_jenis_kelamin', '2')->where("DATE_FORMAT(tanggal_lahir,'%Y') <=", (date('Y')-$i))->where("DATE_FORMAT(tanggal_lahir,'%Y') >=", (date('Y')-$i-4))->get($this->pdd)->num_rows()
            ));
            $i -= 4;
        }
        //ambil jumlah data jenis kelamin laki-laki dan perempuan
        $count_male = $this->db->where(['id_jenis_kelamin'=>1])->from($this->pdd)->count_all_results();
        $count_female = $this->db->where(['id_jenis_kelamin'=>2])->from($this->pdd)->count_all_results();

        //ambil jumlah tertinggi jenis kelamin laki-laki
        $max_male = 0;
        $max_male_label = [];
        $count_max_male_percent = 0;
        foreach ($chart['umur'] as $umur) {
            if ($umur['male'] > $max_male) {
                $max_male = $umur['male'];
                $max_male_label = $umur['label'];
                $count_max_male_percent = $max_male / $count_male * 100;
            }
        }

        //ambil semua keterangan atau kategori pada jenis kelamin laki-laki yang memilki jumlah tertinggi
        $max_amale =  max(array_column($chart['umur'],'male'));
        $keys_max_amale = array_keys(array_column($chart['umur'],'male'), $max_amale);
        $max_amale_arrays = [];
        foreach($keys_max_amale as $key_max_amale){
            $max_amale_arrays[] = array(
                'label' => $chart['umur'][$key_max_amale]['label'],
                'male' => $chart['umur'][$key_max_amale]['male']
            );
        }
        foreach ($max_amale_arrays as $max_amale_array) {
            $max_amale_labels[] = $max_amale_array['label'];
        }

        //ambil jumlah terendah jenis kelamin laki-laki
        $min_male = PHP_INT_MAX;
        foreach ($chart['umur'] as $umur) {
            if ($umur['male'] < $min_male) {
                $min_male = $umur['male'];
                $min_male_label = $umur['label'];
                if ($min_male != 0){
                    $count_min_male_percent = $min_male / $count_female * 100;
                }
                else {
                    $count_min_male_percent = 0;
                }
            }
        }

        //ambil semua keterangan atau kategori pada jenis kelamin laki-laki yang memilki jumlah terendah
        $min_amale =  min(array_column($chart['umur'],'male'));
        $keys_min_amale = array_keys(array_column($chart['umur'],'male'), $min_amale);
        $min_amale_arrays = [];
        foreach($keys_min_amale as $key_min_amale){
            $min_amale_arrays[] = array(
                'label' => $chart['umur'][$key_min_amale]['label'],
                'male' => $chart['umur'][$key_min_amale]['male']
            );
        }
        foreach ($min_amale_arrays as $min_amale_array) {
            $min_amale_labels[] = $min_amale_array['label'];
        }

        //ambil jumlah tertinggi jenis kelamin perempuan
        $max_female = 0;
        $max_female_label = [];
        $count_max_female_percent = 0;
        foreach ($chart['umur'] as $umur) {
            if ($umur['female'] > $max_female) {
                $max_female = $umur['female'];
                $max_female_label = $umur['label'];
                $count_max_female_percent = $max_female / $count_female * 100;
            }
        }

        //ambil semua keterangan atau kategori pada jenis kelamin perempuan yang memilki jumlah tertinggi
        $max_afemale =  max(array_column($chart['umur'],'female'));
        $keys_max_afemale = array_keys(array_column($chart['umur'],'female'), $max_afemale);
        $max_afemale_arrays = [];
        foreach($keys_max_afemale as $key_max_afemale){
            $max_afemale_arrays[] = array(
                'label' => $chart['umur'][$key_max_afemale]['label'],
                'female' => $chart['umur'][$key_max_afemale]['female']
            );
        }
        foreach ($max_afemale_arrays as $max_afemale_array) {
            $max_afemale_labels[] = $max_afemale_array['label'];
        }

        //ambil jumlah terendah jenis kelamin perempuan
        $min_female = PHP_INT_MAX;
        foreach ($chart['umur'] as $umur) {
            if ($umur['male'] < $min_female) {
                $min_female = $umur['male'];
                $min_female_label = $umur['label'];
                if ($min_female != 0){
                    $count_min_female_percent = $min_female / $count_female * 100;
                }
                else {
                    $count_min_female_percent = 0;
                }
            }
        }

        //ambil semua keterangan atau kategori pada jenis kelamin perempuan yang memilki jumlah terendah
        $min_afemale =  min(array_column($chart['umur'],'female'));
        $keys_min_afemale = array_keys(array_column($chart['umur'],'female'), $min_afemale);
        $min_afemale_arrays = [];
        foreach($keys_min_afemale as $key_min_afemale){
            $min_afemale_arrays[] = array(
                'label' => $chart['umur'][$key_min_afemale]['label'],
                'female' => $chart['umur'][$key_min_afemale]['female']
            );
        }
        foreach ($min_afemale_arrays as $min_afemale_array) {
            $min_afemale_labels[] = $min_afemale_array['label'];
        }

        $information_age = array(
            'checkQuery' => $checkQuery,
            'max_male' => $max_male,
            'max_male_label' => $max_male_label,
            'count_max_male_percent' => $count_max_male_percent,
            'max_female' => $max_female,
            'max_female_label' => $max_female_label,
            'count_max_female_percent' => $count_max_female_percent,
            'min_male' => $min_male,
            'min_male_label' => $min_male_label,
            'count_min_male_percent' => $count_min_male_percent,
            'min_female' => $min_female,
            'min_female_label' => $min_female_label,
            'count_min_female_percent' => $count_min_female_percent,
            'min_afemale_labels' => $min_afemale_labels,
            'min_amale_labels' => $min_amale_labels,
            'max_afemale_labels' => $max_afemale_labels,
            'max_amale_labels' => $max_amale_labels,
        );

        return $information_age;
    }

    public function get_information_village(){
        $chart['dusun'] = array();
        $dusun = $this->crud->gao('md_dusun', 'id ASC');
        foreach ($dusun as $row) {
            if (!$row->id) continue;
            array_push($chart['dusun'], array(
                'label'     => $row->nama,
                'male'      => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_dusun' => $row->id]),
                'female'    => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_dusun' => $row->id])
            ));
        }

        $count_male = $this->db->where(['id_jenis_kelamin'=>1])->from($this->pdd)->count_all_results();
        $count_female = $this->db->where(['id_jenis_kelamin'=>2])->from($this->pdd)->count_all_results();

        $vmax_male = 0;
        $vmax_male_label = [];
        $vcount_vmax_male_percent = 0;
        foreach ($chart['dusun'] as $dusun) {
            if ($dusun['male'] > $vmax_male) {
                $vmax_male = $dusun['male'];
                $vmax_male_label = $dusun['label'];
                $vcount_vmax_male_percent = $vmax_male / $count_male * 100;
            }
        }

        $max_vmale =  max(array_column($chart['dusun'],'male'));
        $keys_max_vmale = array_keys(array_column($chart['dusun'],'male'), $max_vmale);
        $max_vmale_arrays = [];
        foreach($keys_max_vmale as $key_max_vmale){
            $max_vmale_arrays[] = array(
                'label' => $chart['dusun'][$key_max_vmale]['label'],
                'male' => $chart['dusun'][$key_max_vmale]['male']
            );
        }
        foreach ($max_vmale_arrays as $max_vmale_array) {
            $max_vmale_labels[] = $max_vmale_array['label'];
        }

        $vmin_male = PHP_INT_MAX;
        foreach ($chart['dusun'] as $dusun) {
            if ($dusun['male'] < $vmin_male) {
                $vmin_male = $dusun['male'];
                $vmin_male_label = $dusun['label'];
                if ($vmin_male != 0){
                    $vcount_vmin_male_percent = $vmin_male / $count_female * 100;
                }
                else {
                    $vcount_vmin_male_percent = 0;
                }
            }
        }

        $min_vmale =  min(array_column($chart['dusun'],'male'));
        $keys_min_vmale = array_keys(array_column($chart['dusun'],'male'), $min_vmale);
        $min_vmale_arrays = [];
        foreach($keys_min_vmale as $key_min_vmale){
            $min_vmale_arrays[] = array(
                'label' => $chart['dusun'][$key_min_vmale]['label'],
                'male' => $chart['dusun'][$key_min_vmale]['male']
            );
        }
        foreach ($min_vmale_arrays as $min_vmale_array) {
            $min_vmale_labels[] = $min_vmale_array['label'];
        }

        $vmax_female = 0;
        $vmax_female_label = [];
        $vcount_vmax_female_percent = 0;
        foreach ($chart['dusun'] as $dusun) {
            if ($dusun['female'] > $vmax_female) {
                $vmax_female = $dusun['female'];
                $vmax_female_label = $dusun['label'];
                $vcount_vmax_female_percent = $vmax_female / $count_female * 100;
            }
        }

        $max_vfemale =  max(array_column($chart['dusun'],'female'));
        $keys_max_vfemale = array_keys(array_column($chart['dusun'],'female'), $max_vfemale);
        $max_vfemale_arrays = [];
        foreach($keys_max_vfemale as $key_max_vfemale){
            $max_vfemale_arrays[] = array(
                'label' => $chart['dusun'][$key_max_vfemale]['label'],
                'female' => $chart['dusun'][$key_max_vfemale]['female']
            );
        }
        foreach ($max_vfemale_arrays as $max_vfemale_array) {
            $max_vfemale_labels[] = $max_vfemale_array['label'];
        }

        $vmin_female = PHP_INT_MAX;
        foreach ($chart['dusun'] as $dusun) {
            if ($dusun['male'] < $vmin_female) {
                $vmin_female = $dusun['female'];
                $vmin_female_label = $dusun['label'];
                if ($vmin_female != 0){
                    $vcount_vmin_female_percent = $vmin_female / $count_female * 100;
                }
                else {
                    $vcount_vmin_female_percent = 0;
                }
            }
        }

        $min_vfemale =  min(array_column($chart['dusun'],'female'));
        $keys_min_vfemale = array_keys(array_column($chart['dusun'],'female'), $min_vfemale);
        $min_vfemale_arrays = [];
        foreach($keys_min_vfemale as $key_min_vfemale){
            $min_vfemale_arrays[] = array(
                'label' => $chart['dusun'][$key_min_vfemale]['label'],
                'female' => $chart['dusun'][$key_min_vfemale]['female']
            );
        }
        foreach ($min_vfemale_arrays as $min_vfemale_array) {
            $min_vfemale_labels[] = $min_vfemale_array['label'];
        }

        $information_village = array(
            'vmax_male' => $vmax_male,
            'vmax_male_label' => $vmax_male_label,
            'vcount_vmax_male_percent' => $vcount_vmax_male_percent,
            'vmax_female' => $vmax_female,
            'vmax_female_label' => $vmax_female_label,
            'vcount_vmax_female_percent' => $vcount_vmax_female_percent,
            'vmin_male' => $vmin_male,
            'vmin_male_label' => $vmin_male_label,
            'vcount_vmin_male_percent' => $vcount_vmin_male_percent,
            'vmin_female' => $vmin_female,
            'vmin_female_label' => $vmin_female_label,
            'vcount_vmin_female_percent' => $vcount_vmin_female_percent,
            'min_vfemale_labels' => $min_vfemale_labels,
            'min_vmale_labels' => $min_vmale_labels,
            'max_vfemale_labels' => $max_vfemale_labels,
            'max_vmale_labels' => $max_vmale_labels,
        );

        return $information_village;
    }

    public function get_information_education(){
        $chart['pendidikan_terakhir'] = array();
        $pendidikan_terakhir = $this->crud->gao('md_pendidikan_terakhir', 'id DESC');
        foreach ($pendidikan_terakhir as $row) {
            if (!$row->id) continue;
            array_push($chart['pendidikan_terakhir'], array(
                'label'     => $row->nama,
                'male'      => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_pendidikan_terakhir' => $row->id]),
                'female'    => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_pendidikan_terakhir' => $row->id])
            ));
        }

        $count_male = $this->db->where(['id_jenis_kelamin'=>1])->from($this->pdd)->count_all_results();
        $count_female = $this->db->where(['id_jenis_kelamin'=>2])->from($this->pdd)->count_all_results();

        $emax_male = 0;
        $emax_male_label = [];
        $ecount_emax_male_percent = 0;
        foreach ($chart['pendidikan_terakhir'] as $pendidikan_terakhir) {
            if ($pendidikan_terakhir['male'] > $emax_male) {
                $emax_male = $pendidikan_terakhir['male'];
                $emax_male_label = $pendidikan_terakhir['label'];
                $ecount_emax_male_percent = $emax_male / $count_male * 100;
            }
        }

        $max_emale =  max(array_column($chart['pendidikan_terakhir'],'male'));
        $keys_max_emale = array_keys(array_column($chart['pendidikan_terakhir'],'male'), $max_emale);
        $max_emale_arrays = [];
        foreach($keys_max_emale as $key_max_emale){
            $max_emale_arrays[] = array(
                'label' => $chart['pendidikan_terakhir'][$key_max_emale]['label'],
                'male' => $chart['pendidikan_terakhir'][$key_max_emale]['male']
            );
        }
        foreach ($max_emale_arrays as $max_emale_array) {
            $max_emale_labels[] = $max_emale_array['label'];
        }

        $emin_male = PHP_INT_MAX;
        foreach ($chart['pendidikan_terakhir'] as $pendidikan_terakhir) {
            if ($pendidikan_terakhir['male'] < $emin_male) {
                $emin_male = $pendidikan_terakhir['male'];
                $emin_male_label = $pendidikan_terakhir['label'];
                if ($emin_male != 0){
                    $ecount_emin_male_percent = $emin_male / $count_female * 100;
                }
                else {
                    $ecount_emin_male_percent = 0;
                }
            }
        }

        $min_emale =  min(array_column($chart['pendidikan_terakhir'],'male'));
        $keys_min_emale = array_keys(array_column($chart['pendidikan_terakhir'],'male'), $min_emale);
        $min_emale_arrays = [];
        foreach($keys_min_emale as $key_min_emale){
            $min_emale_arrays[] = array(
                'label' => $chart['pendidikan_terakhir'][$key_min_emale]['label'],
                'male' => $chart['pendidikan_terakhir'][$key_min_emale]['male']
            );
        }
        foreach ($min_emale_arrays as $min_emale_array) {
            $min_emale_labels[] = $min_emale_array['label'];
        }

        $emax_female = 0;
        $emax_female_label = [];
        $ecount_emax_female_percent = 0;
        foreach ($chart['pendidikan_terakhir'] as $pendidikan_terakhir) {
            if ($pendidikan_terakhir['female'] > $emax_female) {
                $emax_female = $pendidikan_terakhir['female'];
                $emax_female_label = $pendidikan_terakhir['label'];
                $ecount_emax_female_percent = $emax_female / $count_female * 100;
            }
        }

        $max_efemale =  max(array_column($chart['pendidikan_terakhir'],'female'));
        $keys_max_efemale = array_keys(array_column($chart['pendidikan_terakhir'],'female'), $max_efemale);
        $max_efemale_arrays = [];
        foreach($keys_max_efemale as $key_max_efemale){
            $max_efemale_arrays[] = array(
                'label' => $chart['pendidikan_terakhir'][$key_max_efemale]['label'],
                'female' => $chart['pendidikan_terakhir'][$key_max_efemale]['female']
            );
        }
        foreach ($max_efemale_arrays as $max_efemale_array) {
            $max_efemale_labels[] = $max_efemale_array['label'];
        }

        $emin_female = PHP_INT_MAX;
        foreach ($chart['pendidikan_terakhir'] as $pendidikan_terakhir) {
            if ($pendidikan_terakhir['female'] < $emin_female) {
                $emin_female = $pendidikan_terakhir['female'];
                $emin_female_label = $pendidikan_terakhir['label'];
                if ($emin_female != 0){
                    $ecount_emin_female_percent = $emin_female / $count_female * 100;
                }
                else {
                    $ecount_emin_female_percent = 0;
                }
            }
        }

        $min_efemale =  min(array_column($chart['pendidikan_terakhir'],'female'));
        $keys_min_efemale = array_keys(array_column($chart['pendidikan_terakhir'],'female'), $min_efemale);
        $min_efemale_arrays = [];
        foreach($keys_min_efemale as $key_min_efemale){
            $min_efemale_arrays[] = array(
                'label' => $chart['pendidikan_terakhir'][$key_min_efemale]['label'],
                'female' => $chart['pendidikan_terakhir'][$key_min_efemale]['female']
            );
        }
        foreach ($min_efemale_arrays as $min_efemale_array) {
            $min_efemale_labels[] = $min_efemale_array['label'];
        }

        $information_education = array(
            'emax_male' => $emax_male,
            'emax_male_label' => $emax_male_label,
            'ecount_emax_male_percent' => $ecount_emax_male_percent,
            'emax_female' => $emax_female,
            'emax_female_label' => $emax_female_label,
            'ecount_emax_female_percent' => $ecount_emax_female_percent,
            'emin_male' => $emin_male,
            'emin_male_label' => $emin_male_label,
            'ecount_emin_male_percent' => $ecount_emin_male_percent,
            'emin_female' => $emin_female,
            'emin_female_label' => $emin_female_label,
            'ecount_emin_female_percent' => $ecount_emin_female_percent,
            'min_efemale_labels' => $min_efemale_labels,
            'min_emale_labels' => $min_emale_labels,
            'max_efemale_labels' => $max_efemale_labels,
            'max_emale_labels' => $max_emale_labels,
        );

        return $information_education;
    }

    public function get_information_occupation(){
        $chart['pekerjaan'] = array();
        $pekerjaan = $this->crud->gao('md_pekerjaan', 'id DESC');
        foreach ($pekerjaan as $row) {
            if (!$row->id) continue;
            $male = $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_pekerjaan' => $row->id]);
            $female = $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_pekerjaan' => $row->id]);

            if ($male OR $female) {
                array_push($chart['pekerjaan'], array(
                    'label'     => $row->nama,
                    'male'      => $male,
                    'female'    => $female
                ));
            }
        }

        $count_male = $this->db->where(['id_jenis_kelamin'=>1])->from($this->pdd)->count_all_results();
        $count_female = $this->db->where(['id_jenis_kelamin'=>2])->from($this->pdd)->count_all_results();

        $omax_male = 0;
        $omax_male_label = [];
        $ocount_omax_male_percent = 0;
        foreach ($chart['pekerjaan'] as $pekerjaan) {
            if ($pekerjaan['male'] > $omax_male) {
                $omax_male = $pekerjaan['male'];
                $omax_male_label = $pekerjaan['label'];
                $ocount_omax_male_percent = $omax_male / $count_male * 100;
            }
        }

        $max_omale = [];
        if (!empty($chart['pekerjaan'])){
            $max_omale =  max(array_column($chart['pekerjaan'],'male'));
        }
        $keys_max_omale = array_keys(array_column($chart['pekerjaan'],'male'), $max_omale);
        $max_omale_arrays = [];
        foreach($keys_max_omale as $key_max_omale){
            $max_omale_arrays[] = array(
                'label' => $chart['pekerjaan'][$key_max_omale]['label'],
                'male' => $chart['pekerjaan'][$key_max_omale]['male']
            );
        }
        $max_omale_labels =[];
        foreach ($max_omale_arrays as $max_omale_array) {
            $max_omale_labels[] = $max_omale_array['label'];
        }

        $omin_male = PHP_INT_MAX;
        $omin_male_label = [];
        $ocount_omin_male_percent = 0;
        foreach ($chart['pekerjaan'] as $pekerjaan) {
            if ($pekerjaan['male'] < $omin_male) {
                $omin_male = $pekerjaan['male'];
                $omin_male_label = $pekerjaan['label'];
                if ($omin_male != 0){
                    $ocount_omin_male_percent = $omin_male / $count_female * 100;
                }
                else {
                    $ocount_omin_male_percent = 0;
                }
            }
        }

        $min_omale = [];
        if (!empty($chart['pekerjaan'])){
            $min_omale =  min(array_column($chart['pekerjaan'],'male'));
        }
        $keys_min_omale = array_keys(array_column($chart['pekerjaan'],'male'), $min_omale);
        $min_omale_arrays = [];
        foreach($keys_min_omale as $key_min_omale){
            $min_omale_arrays[] = array(
                'label' => $chart['pekerjaan'][$key_min_omale]['label'],
                'male' => $chart['pekerjaan'][$key_min_omale]['male']
            );
        }
        $min_omale_labels = [];
        foreach ($min_omale_arrays as $min_omale_array) {
            $min_omale_labels[] = $min_omale_array['label'];
        }

        $omax_female = 0;
        $omax_female_label = [];
        $ocount_omax_female_percent = 0;
        foreach ($chart['pekerjaan'] as $pekerjaan) {
            if ($pekerjaan['female'] > $omax_female) {
                $omax_female = $pekerjaan['female'];
                $omax_female_label = $pekerjaan['label'];
                $ocount_omax_female_percent = $omax_female / $count_female * 100;
            }
        }

        $max_ofemale =[];
        if (!empty($chart['pekerjaan'])){
            $max_ofemale =  max(array_column($chart['pekerjaan'],'female'));
        }
        $keys_max_ofemale = array_keys(array_column($chart['pekerjaan'],'female'), $max_ofemale);
        $max_ofemale_arrays = [];
        foreach($keys_max_ofemale as $key_max_ofemale){
            $max_ofemale_arrays[] = array(
                'label' => $chart['pekerjaan'][$key_max_ofemale]['label'],
                'female' => $chart['pekerjaan'][$key_max_ofemale]['female']
            );
        }
        $max_ofemale_labels = [];
        foreach ($max_ofemale_arrays as $max_ofemale_array) {
            $max_ofemale_labels[] = $max_ofemale_array['label'];
        }

        $omin_female = PHP_INT_MAX;
        $omin_female_label = [];
        $ocount_omin_female_percent = 0;
        foreach ($chart['pekerjaan'] as $pekerjaan) {
            if ($pekerjaan['female'] < $omin_female) {
                $omin_female = $pekerjaan['female'];
                $omin_female_label = $pekerjaan['label'];
                if ($omin_female != 0){
                    $ocount_omin_female_percent = $omin_female / $count_female * 100;
                }
                else {
                    $ocount_omin_female_percent = 0;
                }
            }
        }

        $min_ofemale = [];
        if (!empty($chart['pekerjaan'])){
            $min_ofemale =  min(array_column($chart['pekerjaan'],'female'));
        }
        $keys_min_ofemale = array_keys(array_column($chart['pekerjaan'],'female'), $min_ofemale);
        $min_ofemale_arrays = [];
        foreach($keys_min_ofemale as $key_min_ofemale){
            $min_ofemale_arrays[] = array(
                'label' => $chart['pekerjaan'][$key_min_ofemale]['label'],
                'female' => $chart['pekerjaan'][$key_min_ofemale]['female']
            );
        }
        $min_ofemale_labels = [];
        foreach ($min_ofemale_arrays as $min_ofemale_array) {
            $min_ofemale_labels[] = $min_ofemale_array['label'];
        }

        $information_occupation = array(
            'omax_male' => $omax_male,
            'omax_male_label' => $omax_male_label,
            'ocount_omax_male_percent' => $ocount_omax_male_percent,
            'omax_female' => $omax_female,
            'omax_female_label' => $omax_female_label,
            'ocount_omax_female_percent' => $ocount_omax_female_percent,
            'omin_male' => $omin_male,
            'omin_male_label' => $omin_male_label,
            'ocount_omin_male_percent' => $ocount_omin_male_percent,
            'omin_female' => $omin_female,
            'omin_female_label' => $omin_female_label,
            'ocount_omin_female_percent' => $ocount_omin_female_percent,
            'min_ofemale_labels' => $min_ofemale_labels,
            'min_omale_labels' => $min_omale_labels,
            'max_ofemale_labels' => $max_ofemale_labels,
            'max_omale_labels' => $max_omale_labels,
        );

        return $information_occupation;
    }

    public function get_information_marital(){
        $chart['status_perkawinan'] = array();
        $status_perkawinan = $this->crud->gao('md_status_perkawinan', 'id DESC');
        foreach ($status_perkawinan as $row) {
            if (!$row->id) continue;
            array_push($chart['status_perkawinan'], array(
                'label'     => $row->nama,
                'male'      => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_status_perkawinan' => $row->id]),
                'female'    => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_status_perkawinan' => $row->id])
            ));
        }

        $count_male = $this->db->where(['id_jenis_kelamin'=>1])->from($this->pdd)->count_all_results();
        $count_female = $this->db->where(['id_jenis_kelamin'=>2])->from($this->pdd)->count_all_results();

        $lmax_male = 0;
        $lmax_male_label = [];
        $lcount_lmax_male_percent = 0;
        foreach ($chart['status_perkawinan'] as $status_perkawinan) {
            if ($status_perkawinan['male'] > $lmax_male) {
                $lmax_male = $status_perkawinan['male'];
                $lmax_male_label = $status_perkawinan['label'];
                $lcount_lmax_male_percent = $lmax_male / $count_male * 100;
            }
        }

        $max_lmale =  max(array_column($chart['status_perkawinan'],'male'));
        $keys_max_lmale = array_keys(array_column($chart['status_perkawinan'],'male'), $max_lmale);
        $max_lmale_arrays = [];
        foreach($keys_max_lmale as $key_max_lmale){
            $max_lmale_arrays[] = array(
                'label' => $chart['status_perkawinan'][$key_max_lmale]['label'],
                'male' => $chart['status_perkawinan'][$key_max_lmale]['male']
            );
        }
        foreach ($max_lmale_arrays as $max_lmale_array) {
            $max_lmale_labels[] = $max_lmale_array['label'];
        }

        $lmin_male = PHP_INT_MAX;
        foreach ($chart['status_perkawinan'] as $status_perkawinan) {
            if ($status_perkawinan['male'] < $lmin_male) {
                $lmin_male = $status_perkawinan['male'];
                $lmin_male_label = $status_perkawinan['label'];
                if ($lmin_male != 0){
                    $lcount_lmin_male_percent = $lmin_male / $count_female * 100;
                }
                else {
                    $lcount_lmin_male_percent = 0;
                }
            }
        }

        $min_lmale =  min(array_column($chart['status_perkawinan'],'male'));
        $keys_min_lmale = array_keys(array_column($chart['status_perkawinan'],'male'), $min_lmale);
        $min_lmale_arrays = [];
        foreach($keys_min_lmale as $key_min_lmale){
            $min_lmale_arrays[] = array(
                'label' => $chart['status_perkawinan'][$key_min_lmale]['label'],
                'male' => $chart['status_perkawinan'][$key_min_lmale]['male']
            );
        }
        foreach ($min_lmale_arrays as $min_lmale_array) {
            $min_lmale_labels[] = $min_lmale_array['label'];
        }

        $lmax_female = 0;
        $lmax_female_label = [];
        $lcount_lmax_female_percent = 0;
        foreach ($chart['status_perkawinan'] as $status_perkawinan) {
            if ($status_perkawinan['female'] > $lmax_female) {
                $lmax_female = $status_perkawinan['female'];
                $lmax_female_label = $status_perkawinan['label'];
                $lcount_lmax_female_percent = $lmax_female / $count_female * 100;
            }
        }

        $max_lfemale =  max(array_column($chart['status_perkawinan'],'female'));
        $keys_max_lfemale = array_keys(array_column($chart['status_perkawinan'],'female'), $max_lfemale);
        $max_lfemale_arrays = [];
        foreach($keys_max_lfemale as $key_max_lfemale){
            $max_lfemale_arrays[] = array(
                'label' => $chart['status_perkawinan'][$key_max_lfemale]['label'],
                'female' => $chart['status_perkawinan'][$key_max_lfemale]['female']
            );
        }
        foreach ($max_lfemale_arrays as $max_lfemale_array) {
            $max_lfemale_labels[] = $max_lfemale_array['label'];
        }

        $lmin_female = PHP_INT_MAX;
        foreach ($chart['status_perkawinan'] as $status_perkawinan) {
            if ($status_perkawinan['female'] < $lmin_female) {
                $lmin_female = $status_perkawinan['female'];
                $lmin_female_label = $status_perkawinan['label'];
                if ($lmin_female != 0){
                    $lcount_lmin_female_percent = $lmin_female / $count_female * 100;
                }
                else {
                    $lcount_lmin_female_percent = 0;
                }
            }
        }

        $min_lfemale =  min(array_column($chart['status_perkawinan'],'female'));
        $keys_min_lfemale = array_keys(array_column($chart['status_perkawinan'],'female'), $min_lfemale);
        $min_lfemale_arrays = [];
        foreach($keys_min_lfemale as $key_min_lfemale){
            $min_lfemale_arrays[] = array(
                'label' => $chart['status_perkawinan'][$key_min_lfemale]['label'],
                'female' => $chart['status_perkawinan'][$key_min_lfemale]['female']
            );
        }
        foreach ($min_lfemale_arrays as $min_lfemale_array) {
            $min_lfemale_labels[] = $min_lfemale_array['label'];
        }

        $information_marital = array(
            'lmax_male' => $lmax_male,
            'lmax_male_label' => $lmax_male_label,
            'lcount_lmax_male_percent' => $lcount_lmax_male_percent,
            'lmax_female' => $lmax_female,
            'lmax_female_label' => $lmax_female_label,
            'lcount_lmax_female_percent' => $lcount_lmax_female_percent,
            'lmin_male' => $lmin_male,
            'lmin_male_label' => $lmin_male_label,
            'lcount_lmin_male_percent' => $lcount_lmin_male_percent,
            'lmin_female' => $lmin_female,
            'lmin_female_label' => $lmin_female_label,
            'lcount_lmin_female_percent' => $lcount_lmin_female_percent,
            'min_lfemale_labels' => $min_lfemale_labels,
            'min_lmale_labels' => $min_lmale_labels,
            'max_lfemale_labels' => $max_lfemale_labels,
            'max_lmale_labels' => $max_lmale_labels,
        );

        return $information_marital;
    }

    public function get_information_religion(){
        $chart['agama'] = array();
        $agama = $this->crud->gao('md_agama', 'id DESC');
        foreach ($agama as $row) {
            if (!$row->id) continue;
            array_push($chart['agama'], array(
                'label'     => $row->nama,
                'male'      => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '1', 'id_agama' => $row->id]),
                'female'    => $this->crud->cw($this->pdd, ['id_jenis_kelamin' => '2', 'id_agama' => $row->id])
            ));
        }

        $count_male = $this->db->where(['id_jenis_kelamin'=>1])->from($this->pdd)->count_all_results();
        $count_female = $this->db->where(['id_jenis_kelamin'=>2])->from($this->pdd)->count_all_results();

        $rmax_male = 0;
        $rmax_male_label = [];
        $rcount_rmax_male_percent = 0;
        foreach ($chart['agama'] as $agama) {
            if ($agama['male'] > $rmax_male) {
                $rmax_male = $agama['male'];
                $rmax_male_label = $agama['label'];
                $rcount_rmax_male_percent = $rmax_male / $count_male * 100;
            }
        }

        $max_rmale =  max(array_column($chart['agama'],'male'));
        $keys_max_rmale = array_keys(array_column($chart['agama'],'male'), $max_rmale);
        $max_rmale_arrays = [];
        foreach($keys_max_rmale as $key_max_rmale){
            $max_rmale_arrays[] = array(
                'label' => $chart['agama'][$key_max_rmale]['label'],
                'male' => $chart['agama'][$key_max_rmale]['male']
            );
        }
        foreach ($max_rmale_arrays as $max_rmale_array) {
            $max_rmale_labels[] = $max_rmale_array['label'];
        }

        $rmin_male = PHP_INT_MAX;
        foreach ($chart['agama'] as $agama) {
            if ($agama['male'] < $rmin_male) {
                $rmin_male = $agama['male'];
                $rmin_male_label = $agama['label'];
                if ($rmin_male != 0){
                    $rcount_rmin_male_percent = $rmin_male / $count_female * 100;
                }
                else {
                    $rcount_rmin_male_percent = 0;
                }
            }
        }

        $min_rmale =  min(array_column($chart['agama'],'male'));
        $keys_min_rmale = array_keys(array_column($chart['agama'],'male'), $min_rmale);
        $min_rmale_arrays = [];
        foreach($keys_min_rmale as $key_min_rmale){
            $min_rmale_arrays[] = array(
                'label' => $chart['agama'][$key_min_rmale]['label'],
                'male' => $chart['agama'][$key_min_rmale]['male']
            );
        }
        foreach ($min_rmale_arrays as $min_rmale_array) {
            $min_rmale_labels[] = $min_rmale_array['label'];
        }

        $rmax_female = 0;
        $rmax_female_label = [];
        $rcount_rmax_female_percent = 0;
        foreach ($chart['agama'] as $agama) {
            if ($agama['female'] > $rmax_female) {
                $rmax_female = $agama['female'];
                $rmax_female_label = $agama['label'];
                $rcount_rmax_female_percent = $rmax_female / $count_female * 100;
            }
        }

        $max_rfemale =  max(array_column($chart['agama'],'female'));
        $keys_max_rfemale = array_keys(array_column($chart['agama'],'female'), $max_rfemale);
        $max_rfemale_arrays = [];
        foreach($keys_max_rfemale as $key_max_rfemale){
            $max_rfemale_arrays[] = array(
                'label' => $chart['agama'][$key_max_rfemale]['label'],
                'female' => $chart['agama'][$key_max_rfemale]['female']
            );
        }
        foreach ($max_rfemale_arrays as $max_rfemale_array) {
            $max_rfemale_labels[] = $max_rfemale_array['label'];
        }

        $rmin_female = PHP_INT_MAX;
        foreach ($chart['agama'] as $agama) {
            if ($agama['female'] < $rmin_female) {
                $rmin_female = $agama['female'];
                $rmin_female_label = $agama['label'];
                if ($rmin_female != 0){
                    $rcount_rmin_female_percent = $rmin_female / $count_female * 100;
                }
                else {
                    $rcount_rmin_female_percent = 0;
                }
            }
        }

        $min_rfemale =  min(array_column($chart['agama'],'female'));
        $keys_min_rfemale = array_keys(array_column($chart['agama'],'female'), $min_rfemale);
        $min_rfemale_arrays = [];
        foreach($keys_min_rfemale as $key_min_rfemale){
            $min_rfemale_arrays[] = array(
                'label' => $chart['agama'][$key_min_rfemale]['label'],
                'female' => $chart['agama'][$key_min_rfemale]['female']
            );
        }
        foreach ($min_rfemale_arrays as $min_rfemale_array) {
            $min_rfemale_labels[] = $min_rfemale_array['label'];
        }

        $information_religion = array(
            'rmax_male' => $rmax_male,
            'rmax_male_label' => $rmax_male_label,
            'rcount_rmax_male_percent' => $rcount_rmax_male_percent,
            'rmax_female' => $rmax_female,
            'rmax_female_label' => $rmax_female_label,
            'rcount_rmax_female_percent' => $rcount_rmax_female_percent,
            'rmin_male' => $rmin_male,
            'rmin_male_label' => $rmin_male_label,
            'rcount_rmin_male_percent' => $rcount_rmin_male_percent,
            'rmin_female' => $rmin_female,
            'rmin_female_label' => $rmin_female_label,
            'rcount_rmin_female_percent' => $rcount_rmin_female_percent,
            'min_rfemale_labels' => $min_rfemale_labels,
            'min_rmale_labels' => $min_rmale_labels,
            'max_rfemale_labels' => $max_rfemale_labels,
            'max_rmale_labels' => $max_rmale_labels,
        );

        return $information_religion;
    }

}
