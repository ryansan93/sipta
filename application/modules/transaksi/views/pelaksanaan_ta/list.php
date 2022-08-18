<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $k_data => $v_data): ?>
		<tr class="cursor-p" onclick="pt.changeTabActive(this)" data-href="action" data-id="<?php echo $v_data['kode']; ?>" data-edit="">
			<td class="text-center"><?php echo strtoupper(tglIndonesia($v_data['tgl_trans'], '-', ' ')); ?></td>
			<td><?php echo strtoupper($v_data['pengajuan']['jenis_pengajuan']['nama']); ?></td>
			<td><?php echo strtoupper($v_data['pengajuan']['judul_penelitian']); ?></td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="3">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>