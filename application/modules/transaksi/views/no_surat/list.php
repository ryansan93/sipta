<?php if ( !empty($data) ): ?>
	<?php $jml_data = 0; ?>
	<?php foreach ($data as $key => $value): ?>
		<?php if ( !empty($value['no_surat']) ): ?>
			<tr class="cursor-p data" onclick="pengajuan.changeTabActive(this)" data-id="<?php echo $value['kode']; ?>" data-href="action" data-edit="" data-status="<?php echo getStatus($value['g_status']); ?>">
				<td class="text-center"><?php echo $value['kode']; ?></td>
				<td class="text-center"><?php echo strtoupper(tglIndonesia($value['tgl_pengajuan'], '-', ' ')); ?></td>
				<td><?php echo $value['jenis_pengajuan']['nama']; ?></td>
				<td><?php echo $value['mahasiswa']['nama']; ?></td>
				<td class="text-center"><?php echo strtoupper(tglIndonesia($value['jadwal'], '-', ' ')); ?></td>
				<td class="text-center"><?php echo substr($value['jam_pelaksanaan'], 0, 5); ?></td>
				<td class="text-left">
					<a href="uploads/dokumen_undangan/<?php echo $value['no_surat']['path']; ?>" target="_blank"><?php echo $value['no_surat']['no_surat']; ?></a>
				</td>
				<?php if ( $akses['a_approve'] == 0 && $akses['a_delete'] == 1 ): ?>
					<td class="text-center">
						<button type="button" class="btn btn-danger" onclick="ns.delete(this)" data-kode="<?php echo $value['kode']; ?>" data-nosurat="<?php echo $value['no_surat']['no_surat']; ?>"><i class="fa fa-trash"></i></button>
					</td>
				<?php endif ?>
			</tr>
			<?php $jml_data++; ?>
		<?php endif ?>
	<?php endforeach ?>

	<?php if ( $jml_data == 0 ): ?>
		<tr>
			<td colspan="8">Data tidak ditemukan.</td>
		</tr>
	<?php endif ?>
<?php else: ?>
	<tr>
		<td colspan="8">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>