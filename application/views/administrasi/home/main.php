                    <div class="m-content">
                        <!-- <div class="col-xl-12 col-lg-12">
                            <center>
                                <h1>Digital Desa</h1>
                                <br/>
                                <h4><?=strtoupper('Digital Desa '.$this->settings->desa)?></h4>
                                <br/>
                            </center>
                        </div> -->
                        <div class="m-portlet m-portlet--success m-portlet--head-solid-bg m-portlet--rounded">
                            <div class="m-portlet__body">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--primary" role="tablist">
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#tab-umur" role="tab" onclick="setTimeout(remove_label, 1000)">
                                                UMUR
                                            </a>
                                        </li>
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab-dusun" role="tab" onclick="setTimeout(remove_label, 1000)">
                                                DUSUN
                                            </a>
                                        </li>
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab-pendidikan_terakhir" role="tab" onclick="setTimeout(remove_label, 1000)">
                                                PENDIDIKAN
                                            </a>
                                        </li>
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab-pekerjaan" role="tab" onclick="setTimeout(remove_label, 1000)">
                                                PEKERJAAN
                                            </a>
                                        </li>
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab-status_perkawinan" role="tab" onclick="setTimeout(remove_label, 1000)">
                                                PERKAWINAN
                                            </a>
                                        </li>
                                        <li class="nav-item m-tabs__item">
                                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#tab-agama" role="tab" onclick="setTimeout(remove_label, 1000)">
                                                AGAMA
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab-umur" role="tabpanel">
                                            <br/>
                                            <div class="m-loader m-loader--danger m-loader--lg" style="width: 50px;"></div>
                                            <div class="row col-12">
                                                <div class="col-8">
                                                    <div class="chart" id="chart_umur"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="alert alert-primary">
                                                        Untuk jenis kelamin laki-laki, kelompok umur <b><?php foreach($information_age['max_amale_labels'] as $max_amale_label) { echo $max_amale_label . " tahun, "; }?></b> adalah kelompok umur tertinggi dengan jumlah <b><?=$information_age['max_male']?></b> orang atau <b><?=round($information_age['count_max_male_percent'])?>%</b> . Sedangkan kelompok umur <b><?php foreach($information_age['min_amale_labels'] as $min_amale_label) { echo $min_amale_label . " tahun, "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_age['min_male']?></b> orang atau <b><?=round($information_age['count_min_male_percent'])?>%</b>.
                                                    </div>
                                                    <div class="alert alert-danger">
                                                        Untuk jenis kelamin perempuan, kelompok umur <b><?php foreach($information_age['max_afemale_labels'] as $max_afemale_label) { echo $max_afemale_label . " tahun, "; }?></b> adalah kelompok umur tertinggi dengan jumlah <b><?=$information_age['max_female']?></b> orang atau <b><?=round($information_age['count_max_female_percent'])?>%</b> . Sedangkan kelompok umur <b><?php foreach($information_age['min_afemale_labels'] as $min_afemale_label) { echo $min_afemale_label . " tahun, "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_age['min_female']?></b> orang atau <b><?=round($information_age['count_min_female_percent'])?>%</b>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-dusun" role="tabpanel">
                                            <br/>
                                            <div class="m-loader m-loader--danger m-loader--lg" style="width: 50px;"></div>
                                            <div class="row col-12">
                                                <div class="col-8">
                                                    <div class="chart" id="chart_dusun"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="alert alert-primary">
                                                        Untuk jenis kelamin laki-laki, dusun <b><?php foreach($information_village['max_vmale_labels'] as $max_vmale_label) { echo $max_vmale_label . ", "; }?></b> adalah dusun dengan penduduk tertinggi dengan jumlah <b><?=$information_village['vmax_male']?></b> orang atau <b><?=round($information_village['vcount_vmax_male_percent'])?>%</b> . Sedangkan dusun <b><?php foreach($information_village['min_vmale_labels'] as $min_vmale_label) { echo $min_vmale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_village['vmin_male']?></b> orang atau <b><?=round($information_village['vcount_vmin_male_percent'])?>%</b>.
                                                    </div>
                                                    <div class="alert alert-danger">
                                                        Untuk jenis kelamin perempuan, dusun <b><?php foreach($information_village['max_vfemale_labels'] as $max_vfemale_label) { echo $max_vfemale_label . ", "; }?></b> adalah dusun dengan penduduk tertinggi dengan jumlah <b><?=$information_village['vmax_female']?></b> orang atau <b><?=round($information_village['vcount_vmax_female_percent'])?>%</b> . Sedangkan dusun <b><?php foreach($information_village['min_vfemale_labels'] as $min_vfemale_label) { echo $min_vfemale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_village['vmin_female']?></b> orang atau <b><?=round($information_village['vcount_vmin_female_percent'])?>%</b>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-pendidikan_terakhir" role="tabpanel">
                                            <br/>
                                            <div class="m-loader m-loader--danger m-loader--lg" style="width: 50px;"></div>
                                            <div class="row col-12">
                                                <div class="col-8">
                                                    <div class="chart" id="chart_pendidikan_terakhir"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="alert alert-primary">
                                                        Untuk jenis kelamin laki-laki, kelompok pendidikan <b><?php foreach($information_education['max_emale_labels'] as $max_emale_label) { echo $max_emale_label . ", "; }?></b> adalah kelompok pendidikan tertinggi dengan jumlah <b><?=$information_education['emax_male']?></b> orang atau <b><?=round($information_education['ecount_emax_male_percent'])?>%</b> . Sedangkan kelompok pendidikan <b><?php foreach($information_education['min_emale_labels'] as $min_emale_label) { echo $min_emale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_education['emin_male']?></b> orang atau <b><?=round($information_education['ecount_emin_male_percent'])?>%</b>.
                                                    </div>
                                                    <div class="alert alert-danger">
                                                        Untuk jenis kelamin perempuan, kelompok pendidikan <b><?php foreach($information_education['max_efemale_labels'] as $max_efemale_label) { echo $max_efemale_label . ", "; }?></b> adalah kelompok pendidikan tertinggi dengan jumlah <b><?=$information_education['emax_female']?></b> orang atau <b><?=round($information_education['ecount_emax_female_percent'])?>%</b> . Sedangkan kelompok pendidikan <b><?php foreach($information_education['min_efemale_labels'] as $min_efemale_label) { echo $min_efemale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_education['emin_female']?></b> orang atau <b><?=round($information_education['ecount_emin_female_percent'])?>%</b>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-pekerjaan" role="tabpanel">
                                            <br/>
                                            <div class="m-loader m-loader--danger m-loader--lg" style="width: 50px;"></div>
                                            <div class="row col-12">
                                                <div class="col-8">
                                                    <div class="chart" id="chart_pekerjaan"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="alert alert-primary">
                                                        Untuk jenis kelamin laki-laki, kelompok pekerjaan <b><?php foreach($information_occupation['max_omale_labels'] as $max_omale_label) { echo $max_omale_label . ", "; }?></b> adalah kelompok pekerjaan tertinggi dengan jumlah <b><?=$information_occupation['omax_male']?></b> orang atau <b><?=round($information_occupation['ocount_omax_male_percent'])?>%</b> . Sedangkan kelompok pekerjaan <b><?php foreach($information_occupation['min_omale_labels'] as $min_omale_label) { echo $min_omale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_occupation['omin_male']?></b> orang atau <b><?=round($information_occupation['ocount_omin_male_percent'])?>%</b>.
                                                    </div>
                                                    <div class="alert alert-danger">
                                                        Untuk jenis kelamin perempuan, kelompok pekerjaan <b><?php foreach($information_occupation['max_omale_labels'] as $max_omale_label) { echo $max_omale_label . ", "; }?></b> adalah kelompok pekerjaan tertinggi dengan jumlah <b><?=$information_occupation['omax_female']?></b> orang atau <b><?=round($information_occupation['ocount_omax_female_percent'])?>%</b> . Sedangkan kelompok pekerjaan <b><?php foreach($information_occupation['min_ofemale_labels'] as $min_ofemale_label) { echo $min_ofemale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_occupation['omin_female']?></b> orang atau <b><?=round($information_occupation['ocount_omin_female_percent'])?>%</b>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-status_perkawinan" role="tabpanel">
                                            <br/>
                                            <div class="m-loader m-loader--danger m-loader--lg" style="width: 50px;"></div>
                                            <div class="row col-12">
                                                <div class="col-8">
                                                    <div class="chart" id="chart_status_perkawinan"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="alert alert-primary">
                                                        Untuk jenis kelamin laki-laki, kelompok dengan status perkawinan <b><?php foreach($information_marital['max_lmale_labels'] as $max_lmale_label) { echo $max_lmale_label . ", "; }?></b> adalah kelompok status perkawinan tertinggi dengan jumlah <b><?=$information_marital['lmax_male']?></b> orang atau <b><?=round($information_marital['lcount_lmax_male_percent'])?>%</b> . Sedangkan kelompok dengan status perkawinan <b><?php foreach($information_marital['min_lmale_labels'] as $min_lmale_label) { echo $min_lmale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_marital['lmin_male']?></b> orang atau <b><?=round($information_marital['lcount_lmin_male_percent'])?>%</b>.
                                                    </div>
                                                    <div class="alert alert-danger">
                                                        Untuk jenis kelamin perempuan, kelompok dengan status perkawinan <b><?php foreach($information_marital['max_lmale_labels'] as $max_lmale_label) { echo $max_lmale_label . ", "; }?></b> adalah kelompok status perkawinan tertinggi dengan jumlah <b><?=$information_marital['lmax_female']?></b> orang atau <b><?=round($information_marital['lcount_lmax_female_percent'])?>%</b> . Sedangkan kelompok dengan status perkawinan <b><?php foreach($information_marital['min_lfemale_labels'] as $min_lfemale_label) { echo $min_lfemale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_marital['lmin_female']?></b> orang atau <b><?=round($information_marital['lcount_lmin_female_percent'])?>%</b>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab-agama" role="tabpanel">
                                            <br/>
                                            <div class="m-loader m-loader--danger m-loader--lg" style="width: 50px;"></div>
                                            <div class="row col-12">
                                                <div class="col-8">
                                                    <div class="chart" id="chart_agama"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="alert alert-primary">
                                                        Untuk jenis kelamin laki-laki, kelompok agama <b><?php foreach($information_religion['max_rmale_labels'] as $max_rmale_label) { echo $max_rmale_label . ", "; }?></b> adalah kelompok agama tertinggi dengan jumlah <b><?=$information_religion['rmax_male']?></b> orang atau <b><?=round($information_religion['rcount_rmax_male_percent'])?>%</b> . Sedangkan kelompok agama <b><?php foreach($information_religion['min_rmale_labels'] as $min_rmale_labels) { echo $min_rmale_labels . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_religion['rmin_male']?></b> orang atau <b><?=round($information_religion['rcount_rmin_male_percent'])?>%</b>.
                                                    </div>
                                                    <div class="alert alert-danger">
                                                        Untuk jenis kelamin perempuan, kelompok agama <b><?php foreach($information_religion['max_rmale_labels'] as $max_rmale_label) { echo $max_rmale_label . ", "; }?></b> adalah kelompok agama tertinggi dengan jumlah <b><?=$information_religion['rmax_female']?></b> orang atau <b><?=round($information_religion['rcount_rmax_female_percent'])?>%</b> . Sedangkan kelompok agama <b><?php foreach($information_religion['min_rfemale_labels'] as $min_rfemale_label) { echo $min_rfemale_label . ", "; }?></b> adalah yang terendah dengan jumlah <b><?=$information_religion['rmin_female']?></b> orang atau <b><?=round($information_religion['rcount_rmin_female_percent'])?>%</b>.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .chart {
                    /*width: 700px;*/
                    height: 500px;
                }
            </style>
            <script src="<?=admin_assets()?>assets/vendors/custom/amcharts/amcharts.js"></script>
            <script src="<?=admin_assets()?>assets/vendors/custom/amcharts/serial.js"></script>
            <script>
                AmCharts.addInitHandler(function(chart) {
                    // set base values
                    var categoryWidth = 40;
                    // calculate bottom margin based on number of data points
                    var chartHeight = categoryWidth * chart.dataProvider.length;
                    // set the value
                    chart.div.style.height = chartHeight + 'px';
                }, ['serial']);

                var chartConfig = {
                    'type': 'serial',
                    'rotate': true,
                    'marginBottom': 50,
                    'startDuration': 1,
                    'graphs': [{
                        'fillAlphas': 0.8,
                        'lineAlpha': 0.2,
                        'type': 'column',
                        'valueField': 'male',
                        'title': 'Male',
                        'lineColor': '#4f81bc',
                        'clustered': false,
                        'labelText': '[[value]]',
                        'labelFunction': function(item) {
                            return Math.abs(item.values.value);
                        },
                        'balloonFunction': function(item) {
                            return item.category + ': <b>' + Math.abs(item.values.value) + '</b> Laki-Laki';
                        }
                    }, {
                        'fillAlphas': 0.8,
                        'lineAlpha': 0.2,
                        'type': 'column',
                        'valueField': 'female',
                        'title': 'Female',
                        'lineColor': '#c0504e',
                        'clustered': false,
                        'labelText': '[[value]]',
                        'labelFunction': function(item) {
                            return Math.abs(item.values.value);
                        },
                        'balloonFunction': function(item) {
                            return item.category + ': <b>' + Math.abs(item.values.value) + '</b> Perempuan';
                        }
                    }],
                    'categoryField': 'label',
                    'categoryAxis': {
                        'gridPosition': 'start',
                        'gridAlpha': 0.2,
                        'axisAlpha': 0
                    },
                    'valueAxes': [{
                        'gridAlpha': 0,
                        'ignoreAxisWidth': true,
                        'labelFunction': function(value) {
                            return Math.abs(value);
                        },
                        'guides': [{
                            'value': 0,
                            'lineAlpha': 0.2
                        }]
                    }],
                    'allLabels': [{
                        'text': 'Laki-Laki',
                        'x': '40%',
                        // 'y': '100',
                        'bold': true,
                        'align': 'middle'
                    }, {
                        'text': 'Perempuan',
                        'x': '70%',
                        // 'y': '100',
                        'bold': true,
                        'align': 'middle'
                    }]
                };

                function clone(obj) {
                    var copy;

                    // Handle the 3 simple types, and null or undefined
                    if (null == obj || "object" != typeof obj) return obj;

                    // Handle Date
                    if (obj instanceof Date) {
                        copy = new Date();
                        copy.setTime(obj.getTime());
                        return copy;
                    }

                      // Handle Array
                    if (obj instanceof Array) {
                        copy = [];
                        for (var i = 0, len = obj.length; i < len; i++) {
                            copy[i] = clone(obj[i]);
                        }
                        return copy;
                    }

                    // Handle Object
                    if (obj instanceof Object) {
                        copy = {};
                        for (var attr in obj) {
                            if (obj.hasOwnProperty(attr)) copy[attr] = clone(obj[attr]);
                        }
                        return copy;
                    }

                    throw new Error("Unable to copy obj! Its type isn't supported.");
                }

                var chartConfigArray = {};

                $.post('<?=administrasi_url('home/get-statistik')?>', {},
                function(result, status) {
                    if (status == 'success') {
                        if (result.success) {
                            $('.m-loader').hide();

                            chartConfigArray.dusun = clone(chartConfig);
                            chartConfigArray.dusun.dataProvider = result.data.dusun;
                            AmCharts.makeChart('chart_dusun', chartConfigArray.dusun);

                            chartConfigArray.pendidikan_terakhir = clone(chartConfig);
                            chartConfigArray.pendidikan_terakhir.dataProvider = result.data.pendidikan_terakhir;
                            AmCharts.makeChart('chart_pendidikan_terakhir', chartConfigArray.pendidikan_terakhir);

                            chartConfigArray.pekerjaan = clone(chartConfig);
                            chartConfigArray.pekerjaan.dataProvider = result.data.pekerjaan;
                            AmCharts.makeChart('chart_pekerjaan', chartConfigArray.pekerjaan);

                            chartConfigArray.status_perkawinan = clone(chartConfig);
                            chartConfigArray.status_perkawinan.dataProvider = result.data.status_perkawinan;
                            AmCharts.makeChart('chart_status_perkawinan', chartConfigArray.status_perkawinan);

                            chartConfigArray.agama = clone(chartConfig);
                            chartConfigArray.agama.dataProvider = result.data.agama;
                            AmCharts.makeChart('chart_agama', chartConfigArray.agama);

                            chartConfigArray.umur = clone(chartConfig);
                            chartConfigArray.umur.dataProvider = result.data.umur;
                            AmCharts.makeChart('chart_umur', chartConfigArray.umur);
                        }
                    }
                });

                function remove_label() {
                    $('.amcharts-chart-div').find('a').remove();
                }

                $(document).ready(function(){
                    setTimeout(remove_label, 1000);
                    $('footer').hide();
                });
            </script>
