<?php if ( $akses['a_submit'] == 1 ): ?>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">PENGAJUAN</label>
		</div>
		<div class="col-xs-12 no-padding">
			<select class="form-control pengajuan" data-required="1" onchange="pt.kelengkapanBlangko(this)">
				<option value="">-- Pilih Pengajuan --</option>
				<?php if ( !empty($pengajuan) ): ?>
					<?php foreach ($pengajuan as $k_pengajuan => $v_pengajuan): ?>
						<option value="<?php echo $v_pengajuan['kode']; ?>" data-jpkode="<?php echo $v_pengajuan['jenis_pengajuan_kode']; ?>"><?php echo strtoupper($v_pengajuan['judul'].' ('.$v_pengajuan['jenis_pengajuan'].')'); ?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select>
		</div>
	</div>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">BLANGKO PELAKSANAAN</label>
		</div>
		<div class="col-xs-12 no-padding">
			<div class="col-xs-12 no-padding attachment" style="margin-top: 0px;">
	            <label class="" style="margin-bottom: 0px;">
	                <input style="display: none;" placeholder="Dokumen" class="file_lampiran blangko no-check" type="file" onchange="pt.showNameFile(this)" data-name="name" data-allowtypes="pdf|PDF|jpg|JPG|jpeg|JPEG|png|PNG" data-required="1">
	                <div class="btn btn-default"><i class="fa fa-upload"></i> Upload</div>
	            </label>
				<a name="dokumen" class="text-right hide" target="_blank" style="padding-right: 10px;"><i class="fa fa-file"></i></a>
			</div>
		</div>
	</div>
	<div class="col-xs-12 no-padding" id="list_kelengkapan"></div>
	<div class="col-xs-12 no-padding">
		<hr style="margin-top: 10px; margin-bottom: 10px;">
	</div>
	<div class="col-xs-12 no-padding">
		<button type="button" class="btn btn-primary pull-right" onclick="pt.save()"><i class="fa fa-save"></i> Simpan</button>
	</div>
<?php endif ?>