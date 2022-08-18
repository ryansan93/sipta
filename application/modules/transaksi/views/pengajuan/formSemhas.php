<?php if ( (isset($jml_sempro) && $jml_sempro >= 10) || (!isset($jml_sempro)) ): ?>	
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">Judul Penelitian</label>
		</div>
		<div class="col-xs-12 no-padding">
			<select class="form-control kode_pengajuan" data-required="1" onchange="pengajuan.formDataPengajuan(this)">
				<option value="">-- Pilih Judul Penlitian --</option>
				<?php if ( isset($data_rancangan_proposal) && !empty($data_rancangan_proposal) ): ?>
					<?php foreach ($data_rancangan_proposal as $k_rp => $v_rp): ?>
						<option value="<?php echo $v_rp['kode_pengajuan']; ?>" data-jp="<?php echo $v_rp['judul_penelitian']; ?>"><?php echo strtoupper($v_rp['jenis_pengajuan'].' | '.$v_rp['judul_penelitian']); ?></option>
					<?php endforeach ?>
				<?php endif ?>
				<?php if ( isset($data_sempro) && !empty($data_sempro) ): ?>
					<?php foreach ($data_sempro as $k_sempro => $v_sempro): ?>
						<option value="<?php echo $v_sempro['kode_pengajuan']; ?>" data-jp="<?php echo $v_sempro['judul_penelitian']; ?>"><?php echo strtoupper($v_sempro['jenis_pengajuan'].' | '.$v_sempro['judul_penelitian']); ?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select>
		</div>
	</div>

	<div class="col-xs-12 no-padding formData" style="margin-bottom: 5px;">
	</div>
<?php else: ?>
	<span>Anda tidak bisa mengajukan <b>Seminar Hasil</b> di karenakan anda belum memenuhi syarat mengikuti <b>Seminar Proposal sebanyak 10x</b>, harap cek kembali laporan kartu seminar anda.</span>
<?php endif ?>