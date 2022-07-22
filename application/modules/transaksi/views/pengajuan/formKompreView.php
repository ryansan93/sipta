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
<?php $no = 1; ?>
<?php foreach ($data['pengajuan_dosen'] as $k_pd => $v_pd): ?>
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

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<?php if ( $data['g_status'] == 1 ): ?>
		<?php if ( $akses['a_approve'] == 0 ) { ?>
			<?php if ( $akses['a_delete'] == 1 ) { ?>
				<button type="button" class="btn btn-danger pull-right" onclick="pengajuan.delete(this)" data-kode="<?php echo $data['kode']; ?>" style="margin-right: 5px;"><i class="fa fa-trash"></i> Hapus</button>
			<?php } ?>
		<?php } else { ?>
			<?php if ( $akses['a_approve'] == 1 ) { ?>
				<button type="button" class="btn btn-primary pull-right" onclick="pengajuan.approve(this)" data-kode="<?php echo $data['kode']; ?>" style="margin-left: 5px;"><i class="fa fa-check"></i> Approve</button>
			<?php } ?>
			<?php if ( $akses['a_reject'] == 1 ) { ?>
				<button type="button" class="btn btn-danger pull-right" onclick="pengajuan.reject(this)" data-kode="<?php echo $data['kode']; ?>" style="margin-right: 5px;"><i class="fa fa-times"></i> Reject</button>
			<?php } ?>
		<?php } ?>
	<?php endif ?>
</div>