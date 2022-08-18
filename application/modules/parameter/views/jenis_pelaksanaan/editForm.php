<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Edit Jenis Pelaksanaan</span>
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
							<label class="control-label">Nama</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-8 form-control nama uppercase" placeholder="Nama" data-required="1" maxlength="50" value="<?php echo $data['nama']; ?>">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Ruang / Kelas</label>
						</td>p
						<td class="col-sm-10">
							<input type="checkbox" class="ruang_kelas cursor-p" <?php echo ($data['ruang_kelas'] == 1) ? 'checked' : ''; ?>>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Zoom</label>
						</td>
						<td class="col-sm-10">
							<input type="checkbox" class="zoom cursor-p" <?php echo ($data['zoom'] == 1) ? 'checked' : ''; ?>>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="jp.edit(this)" data-kode="<?php echo $data['kode']; ?>">
				<i class="fa fa-edit"></i>
				Simpan Perubahan
			</button>
		</div>
	</div>
</div>