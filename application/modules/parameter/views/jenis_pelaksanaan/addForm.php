<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Add Prodi</span>
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
							<input type="text" class="col-sm-2 form-control kode uppercase" placeholder="Kode" maxlength="10" readonly>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Nama</label>
						</td>
						<td class="col-sm-10">
							<input type="text" class="col-sm-8 form-control nama uppercase" placeholder="Nama" data-required="1" maxlength="50">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Ruang / Kelas</label>
						</td>
						<td class="col-sm-10">
							<input type="checkbox" class="ruang_kelas cursor-p">
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Zoom</label>
						</td>
						<td class="col-sm-10">
							<input type="checkbox" class="zoom cursor-p">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="jp.save()">
				<i class="fa fa-save"></i>
				Save
			</button>
		</div>
	</div>
</div>