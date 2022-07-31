<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $key => $value): ?>
		<tr class="cursor-p data" onclick="pengajuan.changeTabActive(this)" data-id="<?php echo $value['kode']; ?>" data-href="action" data-edit="" data-status="<?php echo getStatus($value['g_status']); ?>">
			<td class="text-center">
				<i class="fa fa-toggle-right"></i>
			</td>
			<td class="text-center"><?php echo $value['kode']; ?></td>
			<td class="text-center"><?php echo strtoupper(tglIndonesia($value['tgl_pengajuan'], '-', ' ')); ?></td>
			<td><?php echo $value['jenis_pengajuan']['nama']; ?></td>
			<td><?php echo $value['mahasiswa']['nama']; ?></td>
			<td class="text-center"><?php echo strtoupper(tglIndonesia($value['jadwal'], '-', ' ')); ?></td>
			<td class="text-center"><?php echo substr($value['jam_pelaksanaan'], 0, 5); ?></td>
			<td><?php echo strtoupper(getStatus($value['g_status'])); ?></td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="8">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>