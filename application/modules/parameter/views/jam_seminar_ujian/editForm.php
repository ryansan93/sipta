<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Edit Jam Seminar / Ujian</span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body body">
	<div class="row">
		<div class="col-sm-12 no-padding">
			<table class="table no-border" style="margin-bottom: 0px;">
				<tbody>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Jenis Pengajuan</label>
						</td>
						<td class="col-sm-10">
							<select class="form-control jenis_pengajuan" data-required="1">
								<option value="">-- Pilih Jenis Pengajuan --</option>
								<?php if ( !empty($jenis_pengajuan) ): ?>
									<?php foreach ($jenis_pengajuan as $k_jenis_pengajuan => $v_jenis_pengajuan): ?>
										<?php
											$selected = null;
											if ( $v_jenis_pengajuan['kode'] == $data['jenis_pengajuan_kode'] ) {
												$selected = 'selected';
											}
										?>
										<option value="<?php echo $v_jenis_pengajuan['kode']; ?>" <?php echo $selected; ?> ><?php echo strtoupper($v_jenis_pengajuan['nama']); ?></option>
									<?php endforeach ?>
								<?php endif ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Awal</label>
						</td>
						<td class="col-sm-10">
							<div class="input-group date datetimepicker" name="awal" id="Awal">
						        <input type="text" class="form-control text-center" placeholder="Jam" data-required="1" data-val="<?php echo $data['awal']; ?>" />
						        <span class="input-group-addon">
						            <span class="glyphicon glyphicon-calendar"></span>
						        </span>
						    </div>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">				
							<label class="control-label">Akhir</label>
						</td>
						<td class="col-sm-10">
							<div class="input-group date datetimepicker" name="akhir" id="Akhir">
						        <input type="text" class="form-control text-center" placeholder="Jam" data-required="1" data-val="<?php echo $data['akhir']; ?>" />
						        <span class="input-group-addon">
						            <span class="glyphicon glyphicon-calendar"></span>
						        </span>
						    </div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="jsu.edit(this)" data-kode="<?php echo $data['id']; ?>">
				<i class="fa fa-edit"></i>
				Edit
			</button>
		</div>
	</div>
</div>