<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Judul Penelitian</label>
	</div>
	<div class="col-xs-12 no-padding">
		<select class="form-control kode_pengajuan" data-required="1" onchange="pengajuan.setJudulPenelitian(this)">
			<option value="">-- Pilih Judul Penlitian --</option>
			<?php if ( !empty($data_semhas) ): ?>
				<?php foreach ($data_semhas as $k_ds => $v_ds): ?>
					<option value="<?php echo $v_ds['kode_pengajuan']; ?>" data-jp="<?php echo $v_ds['judul_penelitian']; ?>"><?php echo strtoupper($v_ds['jenis_pengajuan'].' | '.$v_ds['judul_penelitian']); ?></option>
				<?php endforeach ?>
			<?php endif ?>
		</select>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Prodi</label>
	</div>
	<div class="col-xs-12 no-padding">
		<select class="form-control prodi" data-required="1" onchange="pengajuan.mahasiswa(this)">
			<option value="">-- Pilih Prodi --</option>
			<?php if ( !empty($prodi) ): ?>
				<?php foreach ($prodi as $k_prodi => $v_prodi): ?>
					<option value="<?php echo $v_prodi['kode']; ?>"><?php echo strtoupper($v_prodi['kode'].' | '.$v_prodi['nama']); ?></option>
				<?php endforeach ?>
			<?php endif ?>
		</select>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Mahasiswa</label>
	</div>
	<div class="col-xs-12 no-padding">
		<select class="form-control mahasiswa" data-required="1" onchange="pengajuan.setDataMahasiswa()" disabled>
			<option value="">-- Pilih Mahasiswa --</option>
			<?php if ( !empty($mahasiswa) ): ?>
				<?php foreach ($mahasiswa as $k_mahasiswa => $v_mahasiswa): ?>
					<option value="<?php echo $v_mahasiswa['nim']; ?>" data-notelp="<?php echo $v_mahasiswa['no_telp']; ?>" data-nim="<?php echo $v_mahasiswa['nim']; ?>" data-prodi="<?php echo $v_mahasiswa['prodi_kode']; ?>"><?php echo strtoupper($v_mahasiswa['nim'].' | '.$v_mahasiswa['nama']); ?></option>
				<?php endforeach ?>
			<?php endif ?>
		</select>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">NIM</label>
	</div>
	<div class="col-xs-12 no-padding">
		<input type="text" class="form-control uppercase nim" placeholder="NIM" disabled>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">No. HP</label>
	</div>
	<div class="col-xs-12 no-padding">
		<input type="text" class="form-control uppercase no_telp" placeholder="No. HP">
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Jenis Pelaksanaan</label>
	</div>
	<div class="col-xs-12 no-padding">
		<select class="form-control jenis_pelaksanaan" data-required="1">
			<option value="">-- Pilih Jenis Pelaksanaan --</option>
			<?php if ( !empty($jenis_pelaksanaan) ): ?>
				<?php foreach ($jenis_pelaksanaan as $k_jenis_pelaksanaan => $v_jenis_pelaksanaan): ?>
					<option value="<?php echo $v_jenis_pelaksanaan['kode']; ?>"><?php echo strtoupper($v_jenis_pelaksanaan['nama']); ?></option>
				<?php endforeach ?>
			<?php endif ?>
		</select>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Judul Penelitian</label>
	</div>
	<div class="col-xs-12 no-padding">
		<input type="text" class="form-control uppercase judul_penelitian" placeholder="Judul Penelitian" data-required="1" readonly>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Tahun Akademik</label>
	</div>
	<div class="col-xs-12 no-padding">
		<input type="text" class="form-control uppercase tahun_akademik" placeholder="Tahun Akademik" data-required="1" maxlength="10">
	</div>
</div>

<?php for ($i=0; $i < 4; $i++) { ?>
	<?php 
		$data_required = 1;
		if ( $i == 3 ) {
			$data_required = 0;
		}
	?>
	<div class="col-xs-12 no-padding penguji" data-no="<?php echo $i+1; ?>" style="margin-bottom: 5px;">
		<div class="col-xs-4 no-padding" style="padding-right: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Jenis Penguji</label>
			</div>
			<div class="col-xs-12 no-padding">
			<select class="form-control jenis_penguji" data-required="<?php echo $data_required; ?>" onclick="pengajuan.pilihJenisPenguji(this)">
					<option value="">-- Pilih --</option>
					<option value="luar">DOSEN LUAR</option>
					<option value="dalam">DOSEN DALAM</option>
				</select>
			</div>
		</div>
		<div class="col-xs-8 no-padding dosen_penguji" style="padding-left: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Penguji <?php echo $i+1; ?></label>
			</div>
			<div class="col-xs-12 no-padding jenis_dosen dalam">
				<select class="form-control dosen" data-required="<?php echo $data_required; ?>">
					<option value="">-- Pilih Dosen --</option>
					<?php if ( !empty($dosen) ): ?>
						<?php foreach ($dosen as $k_dosen => $v_dosen): ?>
							<option value="<?php echo $v_dosen['nip']; ?>" data-nama="<?php echo $v_dosen['nama']; ?>"><?php echo strtoupper($v_dosen['nip'].' | '.$v_dosen['nama']); ?></option>
						<?php endforeach ?>
					<?php endif ?>
				</select>
			</div>
			<div class="col-xs-12 no-padding jenis_dosen luar hide">
				<input type="text" class="form-control uppercase dosen" placeholder="Nama Penguji">
			</div>
		</div>
	</div>
<?php } ?>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Jadwal</label>
	</div>
	<div class="col-xs-12 no-padding">
		<div class="input-group date datetimepicker" name="jadwal" id="Jadwal">
	        <input type="text" class="form-control text-center" placeholder="Tanggal" data-required="1" />
	        <span class="input-group-addon">
	            <span class="glyphicon glyphicon-calendar"></span>
	        </span>
	    </div>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Jam Pelaksanaan</label>
	</div>
	<div class="col-xs-12 no-padding">
		<div class="input-group date datetimepicker" name="jamPelaksanaan" id="JamPelaksanaan">
	        <input type="text" class="form-control text-center" placeholder="Jam" data-required="1" />
	        <span class="input-group-addon">
	            <span class="glyphicon glyphicon-calendar"></span>
	        </span>
	    </div>
	</div>
</div>

<div class="col-xs-12 no-padding list_kelengkapan_pengajuan">
	<?php if ( !empty($data_kelengkapan) ): ?>
		<?php foreach ($data_kelengkapan as $key => $value): ?>
			<div class="col-xs-12 no-padding kelengkapan_pengajuan" data-kode="<?php echo $value['kode']; ?>" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label"><?php echo $value['nama']; ?></label>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-12 no-padding attachment" style="margin-top: 0px;">
			            <label class="" style="margin-bottom: 0px;">
			                <input style="display: none;" placeholder="Dokumen" class="file_lampiran no-check" type="file" onchange="pengajuan.showNameFile(this)" data-name="name" data-allowtypes="pdf|PDF|jpg|JPG|jpeg|JPEG|png|PNG" data-required="<?php echo $value['wajib']; ?>">
			                <div class="btn btn-default"><i class="fa fa-upload"></i> Upload</div>
			            </label>
						<a name="dokumen" class="text-right hide" target="_blank" style="padding-right: 10px;"><i class="fa fa-file"></i></a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<hr style="margin-top: 10px; margin-bottom: 10px;">
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<button type="button" class="btn btn-primary pull-right" onclick="pengajuan.save_kompre()"><i class="fa fa-save"></i> Simpan</button>
</div>