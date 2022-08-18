<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-3 no-padding">
		<label class="control-label">JENIS PENGAJUAN</label>
	</div>
	<div class="col-xs-9 no-padding">
		<label class="control-label">: <?php echo $data['pengajuan']['jenis_pengajuan']['nama']; ?></label>
	</div>
</div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-3 no-padding">
		<label class="control-label">JUDUL PENELITIAN</label>
	</div>
	<div class="col-xs-9 no-padding">
		<label class="control-label">: <?php echo $data['pengajuan']['judul_penelitian']; ?></label>
	</div>
</div>
<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">BLANGKO PELAKSANAAN</label>
	</div>
	<div class="col-xs-12 no-padding">
		<div class="col-xs-12 no-padding attachment" style="margin-top: 0px;">
			<a name="dokumen" class="text-right btn btn-default" target="_blank" style="padding-right: 10px;" href="uploads/<?php echo $data['lampiran']; ?>"><i class="fa fa-download"></i> File</a>
		</div>
	</div>
</div>
<div class="col-xs-12 no-padding" id="list_kelengkapan">
	<?php if ( !empty($data['blangko_kelengkapan']) ): ?>
		<?php foreach ($data['blangko_kelengkapan'] as $k_bk => $v_bk): ?>
			<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label"><?php echo $v_bk['kelengkapan_blangko']['nama']; ?></label>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-12 no-padding attachment" style="margin-top: 0px;">
						<a name="dokumen" class="text-right btn btn-default" target="_blank" style="padding-right: 10px;" href="uploads/<?php echo $v_bk['lampiran']; ?>"><i class="fa fa-download"></i> File</a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	<?php endif ?>
</div>
<div class="col-xs-12 no-padding">
	<hr style="margin-top: 10px; margin-bottom: 10px;">
</div>
<div class="col-xs-12 no-padding">
	<button type="button" class="btn btn-danger pull-right" onclick="pt.delete(this)" data-kode="<?php echo $data['kode']; ?>"><i class="fa fa-trash"></i> Hapus</button>
</div>