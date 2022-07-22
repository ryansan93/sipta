<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Jenis Pengajuan</label>
	</div>
	<div class="col-xs-12 no-padding">
		<select class="form-control jenis_pengajuan" data-required="1" onchange="pengajuan.kelengkapanPengajuan(this)">
			<option value="">-- Pilih Jenis Pengajuan --</option>
			<?php if ( !empty($jenis_pengajuan) ): ?>
				<?php foreach ($jenis_pengajuan as $k_jenis_pengajuan => $v_jenis_pengajuan): ?>
					<option value="<?php echo $v_jenis_pengajuan['kode']; ?>"><?php echo strtoupper($v_jenis_pengajuan['nama']); ?></option>
				<?php endforeach ?>
			<?php endif ?>
		</select>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<hr style="margin-top: 10px; margin-bottom: 10px;">
</div>

<div class="col-xs-12 no-padding formPengajuan">
</div>