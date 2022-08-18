<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $k_data => $v_data): ?>
		<tr class="cursor-p" onclick="js.changeTabActive(this)" data-href="action" data-id="<?php echo $v_data['kode']; ?>">
			<td><?php echo $v_data['kode']; ?></td>
			<td><?php echo strtoupper(tglIndonesia($v_data['tgl_berlaku'], '-', ' ')); ?></td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="2">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>