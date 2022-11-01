<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Prodi</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo $data['prodi']['nama']; ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Mahasiswa</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo $data['mahasiswa']['nama']; ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">NIM</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo $data['nim']; ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">No. HP</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo $data['no_telp']; ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Jenis Pelaksanaan</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo $data['jenis_pelaksanaan']['nama']; ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Judul Penelitian</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo $data['judul_penelitian']; ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Tahun Akademik</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo $data['tahun_akademik']; ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<?php $no = 1; ?>
<?php foreach ($data['pengajuan_dosen_penguji'] as $k_pd => $v_pd): ?>
	<div class="col-xs-12 no-padding penguji" style="margin-bottom: 5px;">
		<div class="col-xs-4 no-padding" style="padding-right: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Jenis Penguji</label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo strtoupper('dosen '.$v_pd['jenis_dosen']); ?></span>
			</div>
		</div>
		<div class="col-xs-8 no-padding dosen_penguji" style="padding-left: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Penguji <?php echo $no; ?></label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo strtoupper($v_pd['nama']); ?></span>
			</div>
		</div>
	</div>
	<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
	<?php $no++; ?>
<?php endforeach ?>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Jadwal</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo strtoupper(tglIndonesia($data['jadwal'], '-', ' ', true)); ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Jam Pelaksanaan</label>
	</div>
	<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo strtoupper(substr($data['jam_pelaksanaan'], 0, 5)); ?></span>
	</div>
</div>
<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
<div class="col-xs-12 no-padding list_kelengkapan_pengajuan">
	<?php foreach ($data['pengajuan_kelengkapan'] as $k_pk => $v_pk): ?>
		<div class="col-xs-12 no-padding kelengkapan_pengajuan" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label"><?php echo $v_pk['kelengkapan_pengajuan']['nama']; ?></label>
			</div>
			<div class="col-xs-12 no-padding">
				<?php if ( !empty($v_pk['lampiran']) ): ?>
					<a name="dokumen" class="text-right btn btn-default" target="_blank" style="padding-right: 10px;" href="uploads/<?php echo $v_pk['lampiran']; ?>"><i class="fa fa-download"></i> File</a>
				<?php endif ?>
			</div>
		</div>
	<?php endforeach ?>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<hr style="margin-top: 10px; margin-bottom: 10px;">
</div>

<?php if ( $data['g_status'] == getStatus('submit') ): ?>
	<?php if ( $akses['a_approve'] == 1 ): ?>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Jam Selesai</label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo strtoupper(substr($data['jam_selesai'], 0, 5)); ?></span>
			</div>
		</div>
		<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
		<?php 
			$data_required_ruang_kelas = 0;
			$hide_ruang_kelas = 'hide';
			if ( $data['jenis_pelaksanaan']['ruang_kelas'] == 1 ) {
				$hide_ruang_kelas = '';
				$data_required_ruang_kelas = 0;
			}
		?>
		<div class="col-xs-12 no-padding ruang_kelas <?php echo $hide_ruang_kelas; ?>">
			<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label">Ruangan / Kelas</label>
				</div>
				<div class="col-xs-12 no-padding" data-required="<?php echo $data_required_ruang_kelas; ?>" >
					<select class="form-control ruang_kelas" onchange="pengajuan.cekRuangan(this)" data-kode="<?php echo $data['kode']; ?>">
						<option value="">-- Pilih Kelas --</option>
						<?php if ( !empty($ruang_kelas) ): ?>
							<?php foreach ($ruang_kelas as $k_rk => $v_rk): ?>
								<option value="<?php echo $v_rk['kode']; ?>"><?php echo $v_rk['nama']; ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
				</div>
			</div>
			<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
		</div>

		<?php
			$data_required_zoom = 0;
			$hide_zoom = 'hide';
			if ( $data['jenis_pelaksanaan']['zoom'] == 1 ) {
				$hide_zoom = '';
				$data_required_zoom = 1;
			}
		?>
		<div class="xol-xs-12 no-padding zoom <?php echo $hide_zoom; ?>">
			<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label">Akun Zoom</label>
				</div>
				<div class="col-xs-12 no-padding">
					<input type="text" class="form-control text-center akun_zoom" placeholder="Akun Zoom" data-required="<?php echo $data_required_zoom; ?>" />
				</div>
			</div>
			<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>

			<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label">ID Meeting</label>
				</div>
				<div class="col-xs-12 no-padding">
					<input type="text" class="form-control text-center id_meeting" placeholder="ID Meeting" data-required="<?php echo $data_required_zoom; ?>" />
				</div>
			</div>
			<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>

			<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label">Password Meeting</label>
				</div>
				<div class="col-xs-12 no-padding">
					<input type="text" class="form-control text-center password_meeting" placeholder="Password Meeting" data-required="<?php echo $data_required_zoom; ?>" />
				</div>
			</div>
		</div>
	<?php endif ?>
<?php else: ?>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">Jam Selesai</label>
		</div>
		<div class="col-xs-12 no-padding" style="padding-left: 15px;">
		<span><?php echo strtoupper(substr($data['jam_selesai'], 0, 5)); ?></span>
	</div>
	</div>
	<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
	<?php 
		$hide_ruang_kelas = 'hide';
		if ( $data['jenis_pelaksanaan']['ruang_kelas'] == 1 ) {
			$hide_ruang_kelas = '';
		}
	?>
	<div class="col-xs-12 no-padding ruang_kelas <?php echo $hide_ruang_kelas; ?>">
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Ruangan / Kelas</label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo strtoupper($data['ruang_kelas']['nama']); ?></span>
			</div>
		</div>
	</div>
	<div class="col-xs-12 no-padding tipe_ruangan">
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Tipe Ruangan / Kelas</label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span>
					<?php if ( $data['tipe_ruangan'] == 1 ): ?>
						<?php echo 'In Campus'; ?>
					<?php else: ?>
						<?php echo 'Out Campus'; ?>
					<?php endif ?>
				</span>
			</div>
		</div>
	</div>
	<div class="col-xs-12 no-padding alamat">
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Alamat</label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo strtoupper($data['alamat']); ?></span>
			</div>
		</div>
		<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
	</div>

	<?php
		$hide_zoom = 'hide';
		if ( $data['jenis_pelaksanaan']['zoom'] == 1 ) {
			$hide_zoom = '';
		}
	?>
	<div class="xol-xs-12 no-padding zoom <?php echo $hide_zoom; ?>">
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Akun Zoom</label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo $data['akun_zoom']; ?></span>
			</div>
		</div>
		<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>

		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">ID Meeting</label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo $data['id_meeting']; ?></span>
			</div>
		</div>
		<div class="col-xs-9 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>

		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Password Meeting</label>
			</div>
			<div class="col-xs-12 no-padding" style="padding-left: 15px;">
				<span><?php echo $data['password_meeting']; ?></span>
			</div>
		</div>
	</div>
<?php endif ?>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<hr style="margin-top: 10px; margin-bottom: 10px;">
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<?php if ( $data['g_status'] == 1 ): ?>
		<?php if ( $akses['a_approve'] == 0 ) { ?>
			<?php if ( $akses['a_delete'] == 1 ) { ?>
				<button type="button" class="btn btn-danger pull-right" onclick="pengajuan.delete(this)" data-kode="<?php echo $data['kode']; ?>" style="margin-right: 5px;"><i class="fa fa-trash"></i> Hapus</button>
			<?php } ?>
		<?php } else { ?>
			<?php if ( $akses['a_approve'] == 1 ) { ?>
				<button type="button" class="btn btn-primary pull-right" onclick="pengajuan.approve_reject(this)" data-kode="<?php echo $data['kode']; ?>" data-jenis="approve" style="margin-left: 5px;"><i class="fa fa-check"></i> Approve</button>
			<?php } ?>
			<?php if ( $akses['a_reject'] == 1 ) { ?>
				<button type="button" class="btn btn-danger pull-right" onclick="pengajuan.approve_reject(this)" data-kode="<?php echo $data['kode']; ?>" data-jenis="reject" style="margin-right: 5px;"><i class="fa fa-times"></i> Reject</button>
			<?php } ?>
		<?php } ?>
	<?php endif ?>
</div>