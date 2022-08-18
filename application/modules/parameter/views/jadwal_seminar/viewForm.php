<div class="col-xs-12 no-padding">
	<div class="col-xs-3 no-padding">
		<label class="control-label">Tgl Berlaku</label>
	</div>
	<div class="col-xs-9 no-padding"><label class="control-label">: <?php echo strtoupper(tglIndonesia($data['tgl_berlaku'], '-', ' ')); ?></label></div>
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
				<?php foreach ($data['detail'] as $k_det => $v_det): ?>
					<tr>
						<td><?php echo $v_det['jenis_pengajuan_asal']['nama']; ?></td>
						<td><?php echo $v_det['jenis_pengajuan_tujuan']['nama']; ?></td>
						<td class="text-right"><?php echo angkaRibuan($v_det['lama_hari']); ?></td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</small>
</div>