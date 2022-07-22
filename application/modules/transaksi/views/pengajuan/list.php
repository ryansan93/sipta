<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $key => $value): ?>
		<?php
			$status = 0;
			if ( $value['g_status'] == getStatus('submit') ) {
				$status = 'active_submit';
			} else if (  $value['g_status'] == getStatus('reject')  ) {
				$status = 'active_reject';
			}
		?>
		<tr class="cursor-p data" onclick="pengajuan.changeTabActive(this)" data-id="<?php echo $value['kode']; ?>" data-href="action" data-edit="">
			<td class="text-center"><?php echo $value['kode']; ?></td>
			<td class="text-center"><?php echo strtoupper(tglIndonesia($value['tgl_pengajuan'], '-', ' ')); ?></td>
			<td><?php echo $value['jenis_pengajuan']['nama']; ?></td>
			<td><?php echo $value['mahasiswa']['nama']; ?></td>
			<td><?php echo strtoupper(getStatus($value['g_status'])); ?></td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="5">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>