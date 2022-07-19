<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Add Dosen</span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body body">
	<div class="row">
		<div class="col-sm-12 no-padding">
			<table class="table no-border" style="margin-bottom: 0px;">
				<tbody>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">NIP</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-2 form-control nip uppercase" placeholder="NIP" maxlength="20" data-required="1" value="<?php echo $data['nip']; ?>" readonly>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Nama</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-8 form-control nama uppercase" placeholder="Nama Dosen" data-required="1" maxlength="100" value="<?php echo $data['nama']; ?>">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">No. Telp</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-3 form-control no_telp uppercase" placeholder="No. Telp" maxlength="15" data-tipe="angka" value="<?php echo $data['no_telp']; ?>">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">E-Mail</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-4 form-control email" placeholder="E-Mail" maxlength="100" value="<?php echo $data['email']; ?>">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="dosen.edit(this)" data-nip="<?php echo $data['nip']; ?>">
				<i class="fa fa-save"></i>
				Save
			</button>
		</div>
	</div>
</div>