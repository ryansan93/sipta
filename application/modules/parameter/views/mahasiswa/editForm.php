<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Edit Mahasiswa</span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body body">
	<div class="row">
		<div class="col-sm-12 no-padding">
			<table class="table no-border" style="margin-bottom: 0px;">
				<tbody>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">NIM</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-3 form-control nim uppercase" placeholder="NIM" maxlength="50" data-required="1" value="<?php echo $data['nim']; ?>" readonly>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Nama</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-8 form-control nama uppercase" placeholder="Nama" data-required="1" maxlength="100" value="<?php echo $data['nama']; ?>">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">No. Telp</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-3 form-control no_telp uppercase" placeholder="No. Telp" data-required="1" maxlength="15" data-tipe="angka" value="<?php echo $data['no_telp']; ?>">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">E-Mail</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-4 form-control email" placeholder="E-Mail" data-required="1" maxlength="100" value="<?php echo $data['email']; ?>">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Prodi</label>
						</td>
						<td class="col-sm-10">
							<select class="col-sm-4 form-control prodi" data-required="1">
								<option value="">-- Pilih Prodi --</option>
								<?php if ( !empty($prodi) ): ?>
									<?php foreach ($prodi as $key => $value): ?>
										<?php
											$selected = null;
											if ( $value['kode'] == $data['prodi_kode'] ) {
												$selected = 'selected';
											}
										?>
										<option value="<?php echo $value['kode']; ?>" <?php echo $selected; ?> ><?php echo $value['nama']; ?></option>
									<?php endforeach ?>
								<?php endif ?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="mahasiswa.edit(this)" data-nim="<?php echo $data['nim']; ?>">
				<i class="fa fa-edit"></i>
				Simpan Perubahan
			</button>
		</div>
	</div>
</div>