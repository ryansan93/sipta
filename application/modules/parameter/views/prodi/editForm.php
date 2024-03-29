<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Edit Prodi</span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body body">
	<div class="row">
		<div class="col-sm-12 no-padding">
			<table class="table no-border" style="margin-bottom: 0px;">
				<tbody>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Kode Prodi</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-2 form-control kode uppercase" placeholder="Kode Prodi" maxlength="10" data-required="1" value="<?php echo $data['kode']; ?>" readonly>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Nama Prodi</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-8 form-control nama uppercase" placeholder="Nama Prodi" data-required="1" maxlength="50" value="<?php echo $data['nama']; ?>">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Nama Jurusan</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-8 form-control jurusan uppercase" placeholder="Nama Jurusan" data-required="1" maxlength="50" value="<?php echo $data['jurusan']; ?>">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="prodi.edit(this)" data-kode="<?php echo $data['kode']; ?>">
				<i class="fa fa-edit"></i>
				Simpan Perubahan
			</button>
		</div>
	</div>
</div>