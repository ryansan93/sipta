<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $key => $value): ?>
		<tr class="cursor-p data" onclick="rp.changeTabActive(this)" data-id="<?php echo $value['kode']; ?>" data-href="action" data-edit="" data-status="<?php echo getStatus($value['g_status']); ?>">
			<td class="text-center"><?php echo $value['kode']; ?></td>
			<td class="text-center"><?php echo strtoupper(tglIndonesia($value['waktu_konsul'], '-', ' ')); ?></td>
			<td><?php echo $value['mahasiswa']['nama']; ?></td>
			<td><?php echo strtoupper(getStatus($value['g_status'])); ?></td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="4">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>