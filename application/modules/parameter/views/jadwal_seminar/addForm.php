<?php if ( !empty($jadwal) ): ?>
	<div class="col-xs-12 no-padding">
		<div class="col-xs-12 no-padding">
			<label class="control-label">Tgl Berlaku</label>
		</div>
		<div class="col-xs-12 no-padding">
			<div class="input-group date datetimepicker" name="tglBerlaku" id="TglBerlaku">
		        <input type="text" class="form-control text-center" placeholder="Tanggal" data-required="1" />
		        <span class="input-group-addon">
		            <span class="glyphicon glyphicon-calendar"></span>
		        </span>
		    </div>
		</div>
	</div>
	<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
	<div class="col-xs-12 no-padding">
		<small>
			<table class="table table-bordered" style="margin-bottom: 0px;">
				<thead>
					<tr>
						<th class="col-xs-5">Asal</th>
						<th class="col-xs-5">Tujuan</th>
						<th class="col-xs-2">Lama Hari</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($jadwal as $k_jadwal => $v_jadwal): ?>
						<tr>
							<td class="asal" data-val="<?php echo $v_jadwal['kode_asal']; ?>"><?php echo $v_jadwal['asal']; ?></td>
							<td class="tujuan" data-val="<?php echo $v_jadwal['kode_tujuan']; ?>"><?php echo $v_jadwal['tujuan']; ?></td>
							<td>
								<input type="text" class="form-control text-right lama_hari" data-tipe="integer" maxlength="3" data-required="1" placeholder="hari">
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</small>
	</div>
	<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
	<div class="col-xs-12 no-padding">
		<button type="button" class="btn btn-primary pull-right" onclick="js.save()"><i class="fa fa-save"></i> Simpan</button>
	</div>
<?php else: ?>
	<span>Tidak ada data yang akan anda submit.</span>
<?php endif ?>