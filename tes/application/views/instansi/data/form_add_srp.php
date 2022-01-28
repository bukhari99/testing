<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title mb-0">
            FORM TAMBAH Data Pegawai
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form id="form-tambah">
            <div class="row">

            <div class="col-sm-12">
                    <div class="form-group">
                        <label for="judul_skripsi">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" required>
                        <small class="text-danger nama_instansi"></small>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="judul_skripsi">Usia (Tahun)</label>
                        <input type="number" name="usia" id="usia" class="form-control" autocomplete="off" required>
                        <small class="text-danger nama_instansi"></small>
                    </div>
                </div>

            <div class="col-sm-12">
                    <div class="form-group">
                        <label for="pegawai">Jenis Kelamin</label>
                        <select name="jk" id="pegawai" class="form-control select2" style="width: 100%;">
                            <?php //foreach ($result_pegawai as $pegawai) : ?>
                                <option value="L">L</option>
                                <option value="P">P</option>
                            <?php //endforeach; ?>
                        </select>
                        <small class="text-danger pegawai"></small>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="pegawai">Pangkat/Gol</label>
                        <select name="pg" id="pegawai" class="form-control select2" style="width: 100%;">
                            <?php //foreach ($result_pegawai as $pegawai) : ?>
                                <option value="I-a-Juru Muda">Golongan Ia Juru Muda</option>
                                <option value="I-b-Juru Muda Tingkat I">Golongan Ib Juru Muda Tingkat I</option>
                                <option value="I-c-Juru">Golongan Ic : Juru</option>
                                <option value="I-d-Juru Tingkat I">Golongan Id Juru Tingkat I</option>
                                <option value="II-a-Pengatur muda">Golongan IIa Pengatur muda</option>
                                <option value="II-b-Pengatur Muda Tingkat I">Golongan II b  Pengatur Muda Tingkat I</option>
                                <option value="II-c-Pengatur">IIc Pengatur</option>
                                <option value="II-d-Pengatur tingkat I">IId Pengatur tingkat I</option>
                                <option value="III-a-Penata Muda">IIIa Penata Muda</option>
                                <option value="III-b-Penata Muda Tingkat 1">IIIb Penata Muda Tingkat 1</option>
                                <option value="III-c-Penata">IIIc Penata</option>
                                <option value="III-d-Penata Tingkat I">IIId Penata Tingkat I</option>
                                <option value="IV-a-Pembina">IVa Pembina</option>
                                <option value="IV-b-Pembina Tingkat I">IVb Pembina Tingkat I</option>
                                <option value="IV-c-Pembina Muda">IVc Pembina Muda</option>
                                <option value="IV-d-Pembina Madya">IVd Pembina Madya</option>
                                <option value="IV-e-Pembina Utama">IVe Pembina Utama</option>
                            <?php //endforeach; ?>
                        </select>
                        <small class="text-danger pegawai"></small>
                    </div>
                </div>
            
               
                
                
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn-tambah2" class="btn btn-sm btn-primary">
            <i class="fa fa-save"></i> SIMPAN
        </button>
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
            <i class="fa fa-times"></i> BATAL
        </button>
    </div>
</div>
