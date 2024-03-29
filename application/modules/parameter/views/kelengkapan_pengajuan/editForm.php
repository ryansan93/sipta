<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Add Kelengkapan Pengajuan</span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body body">
	<div class="row">
		<div class="col-sm-12 no-padding">
			<table class="table no-border" style="margin-bottom: 0px;">
				<tbody>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Kode</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-2 form-control kode uppercase" placeholder="Kode" maxlength="10" value="<?php echo $data['kode']; ?>" readonly>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Jenis Pengajuan</label>
						</td>
						<td class="col-sm-10">
							<select class="form-control jenis_pengajuan col-sm-6" data-required="1">
								<option value="">-- Pilih Jenis Pengajuan</option>
								<?php if ( !empty($jenis_pengajuan) ): ?>
									<?php foreach ($jenis_pengajuan as $k_jp => $v_jp): ?>
										<?php
											$selected = null;
											if ( $v_jp['kode'] == $data['jenis_pengajuan_kode'] ) {
												$selected = 'selected';
											}
										?>
										<option value="<?php echo $v_jp['kode']; ?>" <?php echo $selected; ?> ><?php echo $v_jp['nama']; ?></option>
									<?php endforeach ?>
								<?php endif ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Nama</label>
						</td>
						<td class="col-sm-10">
							<textarea class="form-control nama uppercase" placeholder="Nama" data-required="1"><?php echo $data['nama']; ?></textarea>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">WAJIB</label>
						</td>
						<td class="col-sm-10">
							<select class="form-control wajib col-sm-6" data-required="1">
								<option value="">-- Pilih --</option>
								<option value="1" <?php echo ($data['wajib'] == 1) ? 'selected' : ''; ?> >WAJIB</option>
								<option value="0" <?php echo ($data['wajib'] == 0) ? 'selected' : ''; ?> >TIDAK WAJIB</option>
							</select>
						</td>
					</tr>
					<tr class="hide">
						<td class="col-sm-2">				
							<label class="control-label">Jumlah File</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="form-control text-right jml_file" placeholder="Jumlah" data-tipe="integer" maxlength="2" value="<?php echo angkaRibuan($data['jml_file']); ?>"></input>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="kp.edit(this)" data-id="<?php echo $data['kode']; ?>">
				<i class="fa fa-edit"></i>
				Simpan Perubahan
			</button>
		</div>
	</div>
</div>