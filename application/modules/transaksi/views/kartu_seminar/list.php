<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $k_data => $v_data): ?>
		<tr>
			<td class="text-center"><?php echo strtoupper(tglIndonesia($v_data['tanggal'], '-', ' ')); ?></td>
			<td class="text-center">
				<?php echo substr($v_data['jam_mulai'], 0, 5); ?>
				<br>
				<?php echo substr($v_data['jam_selesai'], 0, 5); ?>
			</td>
			<td class="text-center"><?php echo strtoupper($v_data['jenis_pelaksanaan']); ?></td>
			<td><?php echo !empty($v_data['ruang_kelas']) ? strtoupper($v_data['ruang_kelas']) : '-'; ?></td>
			<td>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-5 no-padding">AKUN</div>
					<div class="col-xs-7 no-padding">: <?php echo !empty($v_data['akun_zoom']) ? $v_data['akun_zoom'] : '-'; ?></div>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-5 no-padding">ID MEETING</div>
					<div class="col-xs-7 no-padding">: <?php echo !empty($v_data['id_meeting']) ? $v_data['id_meeting'] : '-'; ?></div>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-5 no-padding">PASSWORD</div>
					<div class="col-xs-7 no-padding">: <?php echo !empty($v_data['password_meeting']) ? $v_data['password_meeting'] : '-'; ?></div>
				</div>
			</td>
			<td><?php echo strtoupper($v_data['mahasiswa']); ?></td>
			<td><?php echo strtoupper($v_data['judul_penelitian']); ?></td>
			<td>
				<?php 
					$disabled_checkin = null;
					$disabled_checkout = 'disabled';
					if ( $v_data['aktif'] == 0 ) {
						$disabled_checkin = 'disabled';
					} else {
						if ( $v_data['hadir'] == 1 ) {
							$disabled_checkin = 'disabled';
							$disabled_checkout = null;
						}
					}
				?>
				<div class="col-xs-12 no-padding" style="padding-bottom: 5px;">
					<button type="button" class="btn btn-success col-xs-12" <?php echo $disabled_checkin; ?> style="padding: 3px 6px;" onclick="ks.checkIn(this)" data-pengajuankode="<?php echo $v_data['kode']; ?>">Check In</button>
				</div>
				<div class="col-xs-12 no-padding" style="padding-top: 5px;">
					<button type="button" class="btn btn-danger col-xs-12" <?php echo $disabled_checkout; ?> style="padding: 3px 6px;" onclick="ks.checkOut(this)" data-pengajuankode="<?php echo $v_data['kode']; ?>">Check Out</button>
				</div>
			</td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="8">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>