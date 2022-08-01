<?php if ( !empty($data) && count($data) > 0 ): ?>
	<?php foreach ($data as $key => $value): ?>
		<tr>
			<td colspan="11" style="background-color: #ededed;"><b><?php echo $value['nip'].' | '.$value['nama']; ?></b></td>
		</tr>
		<?php foreach ($value['detail'] as $k_det => $v_det): ?>
			<tr>
				<td><?php echo tglIndonesia($v_det['tgl_pengajuan'], '-', ' '); ?></td>
				<td><?php echo $v_det['jenis_pengajuan']); ?></td>
				<td><?php echo tglIndonesia($v_det['tgl_seminar'], '-', ' '); ?></td>
				<td><?php echo $v_det['nama'].'<br>'.$v_det['nim']; ?></td>
				<td><?php echo $v_det['prodi']; ?></td>
				<td><?php echo $v_det['dosbing1'].'<br>'.$v_det['dosbing2']; ?></td>
				<td><?php echo $v_det['jenis_pelaksanaan']; ?></td>
				<td><?php echo $v_det['ruang_kelas']; ?></td>
				<td><?php echo $v_det['akun_zoom']; ?></td>
				<td>
					<?php if ( !empty($v_det['no_surat']) ): ?>
						<a href="uploads/dokumen_undangan/<?php echo $v_det['path']; ?>"><?php echo $v_det['no_surat']; ?></a>
					<?php else: ?>
						-
					<?php endif ?>
				</td>
			</tr>
		<?php endforeach ?>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="11">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>