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

<div class="col-xs-12 no-padding formData" style="margin-bottom: 5px;">
</div>