<div class="modal-header header" style="padding-left: 0px; padding-right: 0px;">
	<span class="modal-title"><label class="control-label">Add SK Pembimbing</label></span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body body" style="padding-bottom: 0px;">
	<div class="row">
		<div class="col-sm-12 no-padding">
			<label class="control-label">Mahasiswa</label>
		</div>
		<div class="col-sm-12 no-padding">
			<select class="col-sm-12 form-control mahasiswa" data-required="1">
				<option value="">-- Pilih Mahasiswa --</option>
				<?php if ( !empty($mahasiswa) ): ?>
					<?php foreach ($mahasiswa as $key => $value): ?>
						<option value="<?php echo $value['nim']; ?>"><?php echo strtoupper($value['nim'].' | '.$value['nama']); ?></option>
					<?php endforeach ?>
				<?php endif ?>
			</select>
		</div>
		<div class="col-sm-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
		<div class="col-sm-12 no-padding">
			<div class="panel-body no-padding">
				<fieldset>
					<legend>
						<div class="col-sm-8 no-padding">
							Pembimbing
						</div>
					</legend>
					<small>
						<table class="table table-bordered tbl_pembimbing" style="margin-bottom: 0px;">
							<thead>
								<tr>
									<th class="col-sm-8">Dosen</th>
									<th class="col-sm-4">Action</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<select class="col-sm-12 form-control dosen" data-required="1">
											<option value="">-- Pilih Dosen --</option>
											<?php if ( !empty($dosen) ): ?>
												<?php foreach ($dosen as $key => $value): ?>
													<option value="<?php echo $value['nip']; ?>"><?php echo strtoupper($value['nip'].' | '.$value['nama']); ?></option>
												<?php endforeach ?>
											<?php endif ?>
										</select>
									</td>
									<td>
										<div class="col-sm-6 no-padding" style="padding-right: 5px;">
											<button type="button" class="col-sm-12 btn btn-primary" onclick="skp.addRow(this);"><i class="fa fa-plus"></i></button>
										</div>
										<div class="col-sm-6 no-padding" style="padding-left: 5px;">
											<button type="button" class="col-sm-12 btn btn-danger" onclick="skp.removeRow(this);"><i class="fa fa-times"></i></button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</small>
				</fieldset>
			</div>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 0px; padding-right: 0px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="skp.save()">
				<i class="fa fa-save"></i>
				Save
			</button>
		</div>
	</div>
</div>