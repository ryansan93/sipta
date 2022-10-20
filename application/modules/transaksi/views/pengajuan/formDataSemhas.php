<?php if ( !empty($data) ): ?>
	<?php if ( isset($data['list_pembimbing']) && !empty($data['list_pembimbing']) ): ?>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Judul Penelitian</label>
			</div>
			<?php
				$judul_penelitian = null;
				if ( isset($data['judul_penelitian']) && !empty($data['judul_penelitian']) ) {
					$judul_penelitian = $data['judul_penelitian'];
				}
			?>
			<!-- <div class="col-xs-12 no-padding judul_penelitian" data-val="<?php echo $judul_penelitian; ?>" style="padding-left: 15px;">
				<span><?php echo strtoupper($judul_penelitian); ?></span>
			</div> -->
			<input type="text" class="form-control judul_penelitian" data-required="1" placeholder="Judul Penelitian" value="<?php echo $judul_penelitian; ?>">
		</div>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Prodi</label>
			</div>
			<?php
				$prodi_kode = null;
				$prodi_nama = null;
				if ( isset($data['prodi']) && !empty($data['prodi']) ) {
					$prodi_kode = $data['prodi_kode'];
					$prodi_nama = $data['prodi']['nama'];
				}
			?>
			<div class="col-xs-12 no-padding prodi" data-val="<?php echo $prodi_kode; ?>" style="padding-left: 15px;">
				<span><?php echo strtoupper($prodi_nama); ?></span>
			</div>
		</div>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Mahasiswa</label>
			</div>
			<?php
				$mahasiswa = null;
				if ( isset($data['mahasiswa']) && !empty($data['mahasiswa']) ) {
					$mahasiswa = $data['mahasiswa']['nama'];
				}
			?>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo strtoupper($mahasiswa); ?></span>
			</div>
		</div>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">NIM</label>
			</div>
			<div class="col-xs-12 no-padding nim" data-val="<?php echo $data['nim']; ?>" style="padding-left: 15px;">
				<span><?php echo strtoupper($data['nim']); ?></span>
			</div>
		</div>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">No. HP</label>
			</div>
			<div class="col-xs-12 no-padding no_telp" data-val="<?php echo $data['no_telp']; ?>" style="padding-left: 15px;">
				<span><?php echo strtoupper($data['no_telp']); ?></span>
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
				<label class="control-label">Tahun Akademik</label>
			</div>
			<?php
				$tahun_akademik = null;
				if ( isset($data['tahun_akademik']) && !empty($data['tahun_akademik']) ) {
					$tahun_akademik = $data['tahun_akademik'];
				}
			?>
			<!-- <div class="col-xs-12 no-padding tahun_akademik" data-val="<?php echo $data['tahun_akademik']; ?>" style="padding-left: 15px;">
				<span><?php echo strtoupper($data['tahun_akademik']); ?></span>
			</div> -->
			<input type="text" class="form-control text-center tahun_akademik" data-required="1" placeholder="Tahun Akademik" value="<?php echo $tahun_akademik; ?>">
		</div>

		<?php $idx = 1; ?>
		<?php foreach ($data['list_pembimbing'] as $k_pd => $v_pd): ?>
			<div class="col-xs-12 no-padding pembimbing" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<div class="col-xs-12 no-padding">
						<label class="control-label">Pembimbing <?php echo $idx; ?></label>
					</div>
					<div class="col-xs-12 no-padding nama" data-nip="<?php echo $v_pd['nip']; ?>" style="padding-left: 15px;">
						<?php echo $v_pd['nama'] ?>
					</div>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-12 no-padding">
						<label class="control-label">No. HP</label>
					</div>
					<div class="col-xs-12 no-padding no_telp" style="padding-left: 15px;">
						<?php echo !empty($v_pd['no_telp']) ? $v_pd['no_telp'] : '-'; ?>
					</div>
				</div>
			</div>
			<?php $idx++; ?>
		<?php endforeach ?>

		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Jadwal (Jadwal yang disepakati bersama dengan Pembimbing)</label>
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
				<div class="input-group date datetimepicker" name="jam_pelaksanaan" id="JamPelaksanaan">
			        <input type="text" class="form-control text-center" placeholder="Jam Pelaksanaan" data-required="1" />
			        <span class="input-group-addon">
			            <span class="glyphicon glyphicon-calendar"></span>
			        </span>
			    </div>
			    <!-- <select class="form-control jam_seminar_ujian" data-required="1">
					<option value="">-- Pilih Jam --</option>
					<?php if ( !empty($jam_seminar_ujian) ): ?>
						<?php foreach ($jam_seminar_ujian as $k_jsu => $v_jsu): ?>
							<option value="<?php echo $v_jsu['id']; ?>" data-awal="<?php echo substr($v_jsu['awal'], 0, 5); ?>" data-akhir="<?php echo substr($v_jsu['akhir'], 0, 5); ?>"><?php echo substr($v_jsu['awal'], 0, 5); ?></option>
						<?php endforeach ?>
					<?php endif ?>
				</select> -->
			</div>
		</div>

		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Tipe Ruangan / Kelas</label>
			</div>
	        <div class="col-lg-12">
	            <div class="radio" style="margin-top: 0px;">
					<label><input type="radio" name="optradio" value="1" checked>On Site</label>
				</div>
				<div class="radio" style="margin-bottom: 0px;">
					<label><input type="radio" name="optradio" value="0">Out Site</label>
				</div>
	        </div>
		</div>

		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Alamat</label>
			</div>
	        <div class="col-lg-12 no-padding">
	            <textarea class="form-control alamat" placeholder="Alamat"></textarea>
	        </div>
		</div>

		<?php for ($i=0; $i < 4; $i++) { ?>
			<?php 
				$data_required = 0;
				// if ( $i == 3 ) {
				// 	$data_required = 0;
				// }
			?>
			<div class="col-xs-12 no-padding penguji" data-no="<?php echo $i+1; ?>" style="margin-bottom: 5px;" data-required="0">
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

		<div class="col-xs-12 no-padding list_kelengkapan_pengajuan">
			<?php if ( !empty($data_kelengkapan) ): ?>
				<?php foreach ($data_kelengkapan as $key => $value): ?>
					<div class="col-xs-12 no-padding kelengkapan_pengajuan" data-kode="<?php echo $value['kode']; ?>" style="margin-bottom: 5px;">
						<div class="col-xs-12 no-padding">
							<label class="control-label" style="text-align: left;"><?php echo $value['nama']; ?></label>
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
			<button type="button" class="btn btn-primary pull-right" onclick="pengajuan.save_semhas()"><i class="fa fa-save"></i> Simpan</button>
		</div>
	<?php else: ?>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">SK Pembimbing anda belum di terbitkan.</label>
			</div>
		</div>
	<?php endif ?>
<?php else: ?>
	<?php if ( stristr($jenis_pengajuan, 'seminar hasil') !== false ): ?>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Anda belum mengajukan seminar proposal.</label>
			</div>
		</div>
	<?php else: ?>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">SK Pembimbing anda belum di terbitkan.</label>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>