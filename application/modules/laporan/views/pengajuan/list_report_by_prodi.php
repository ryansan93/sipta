<?php if ( !empty($data) && count($data) > 0 ): ?>
	<?php foreach ($data as $key => $value): ?>
		<div class="col-xs-12 no-padding" style="margin-bottom: 10px;">
			<div class="col-xs-12 no-padding" style="text-decoration: underline;"><span><b><?php echo $value['nama']; ?></span></b></div>
			<?php foreach ($value['detail'] as $k_det => $v_det): ?>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-2 no-padding">
						<span><b><?php echo $v_det['nama']; ?></b></span>
					</div>
					<div class="col-xs-10 no-padding"><span><b>: <?php echo $v_det['jumlah']; ?></b></span></div>
				</div>
			<?php endforeach ?>
			<div class="col-xs-3 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px"></div>
			<div class="col-xs-12 no-padding">
				<div class="col-xs-2 no-padding">
					<span><b>PENGAJUAN DI TERIMA</b></span>
				</div>
				<div class="col-xs-10 no-padding"><span><b>: <?php echo isset($value['pengajuan_masuk']) ? angkaRibuan($value['pengajuan_masuk']) : 0; ?></b></span></div>
			</div>
			<div class="col-xs-12 no-padding">
				<div class="col-xs-2 no-padding">
					<span><b>PENGAJUAN SELESAI</b></span>
				</div>
				<div class="col-xs-10 no-padding"><span><b>: <?php echo isset($value['pengajuan_selesai']) ? angkaRibuan($value['pengajuan_selesai']) : 0; ?></b></span></div>
			</div>
		</div>
		<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px"></div>
	<?php endforeach ?>
<?php else: ?>
	<h3>Data tidak ditemukan.</h3>
<?php endif ?>