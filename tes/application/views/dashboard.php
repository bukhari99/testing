<?php $this->load->view("_partial/header");
$role_name = $this->session->userdata('role_name'); //echo $role_name;
$role_surat = $this->session->userdata('role_surat');?>
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-4">
        <div class="d-flex align-items-left flex-column flex-sm-row">
            <h3 class="text-white pb-3 fw-bold">DATA PEGAWAI</h3>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    <div class="card full-height">
        <div class="card-body">
            <div class="row">

                <!--
                <div class="col-lg-4 col-md-6">
                    <div class="card card-profile">
                        <div class="card-header" style="background-image: url(<?= base_url('images/blogpost.jpg'); ?>)">
                            <div class="profile-picture">
                                <div class="avatar avatar-xl">
                                    <img src="<?= cek_file("uploads/users/" . $pegawai['foto']); ?>" alt="users" class="avatar-img rounded-circle">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="user-profile text-center">
                                <div class="name"><?= $pegawai['username']; ?></div>
                                <div class="job"><?= $pegawai['nama_pegawai']; ?></div>
                                <div class="desc"><?= $pegawai['role_name']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>-->

              

                <div class="col-lg-4 col-md-6">
                    <div class="card card-profile">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-stats card-primary card-round">
                                    <a href="<?= site_url('srp'); ?>" style="text-decoration: none;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="icon-big text-center">
                                                            <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category" style="font-size:1.5em;">Golongan I (Juru)</p>
                                                        <h4 class="card-title"><?=$jumlah_gol_I?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               

               
                <div class="col-lg-4 col-md-6">
                    <div class="card card-profile">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-stats card-warning card-round">
                                    <a href="<?php echo site_url('srp'); ?>" style="text-decoration: none;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="icon-big text-center">
                                                            <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category" style="font-size:1.25em;">Golongan II (Pengatur)</p>
                                                        <h4 class="card-title"><?=$jumlah_gol_II?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                <div class="col-lg-4 col-md-6">
                    <div class="card card-profile">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-stats card-success card-round">
                                    <a href="<?= site_url('srp'); ?>" style="text-decoration: none;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="icon-big text-center">
                                                            <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category" style="font-size:1.25em;">Golongan III (Penata)</p>
                                                        <h4 class="card-title"><?=$jumlah_gol_III?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            

               
                <div class="col-lg-4 col-md-6">
                    <div class="card card-profile">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-stats card-danger card-round">
                                    <a href="<?= site_url('srp'); ?>" style="text-decoration: none;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="icon-big text-center">
                                                            <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category" style="font-size:1.1em;">Golongan IV (Pembina)</p>
                                                        <h4 class="card-title"><?=$jumlah_gol_IV?></h4>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-lg-4 col-md-6">
                    <div class="card card-profile">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-stats card-warning card-round">
                                    <a href="<?= site_url('srp'); ?>" style="text-decoration: none;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="icon-big text-center">
                                                            <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category" style="font-size:1.1em;">PRIA (<?=$jumlah_pria?>) - WANITA (<?=$jumlah_wanita?>)</p>
                                                        <h4 class="card-title"></h4>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="card card-profile">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-stats card-success card-round">
                                    <a href="<?= site_url('srp'); ?>" style="text-decoration: none;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="icon-big text-center">
                                                            <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                                <div class="col-8 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category" style="font-size:0.85em;">Rentang Usia <br /><30 (<?=$jumlah_usia_kurang_30?>) -  31-40 (<?=$jumlah_usia_31_40?>)<br /> 41-50 (<?=$jumlah_usia_41_50?>) - >50 (<?=$jumlah_usia_lebih_50?>)</p>
                                                        <h4 class="card-title"></h4>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
                


            </div>
        </div>
    </div>
</div>
<?php $this->load->view('_partial/footer'); ?>
<?php $this->load->view('_partial/tag_close'); ?>