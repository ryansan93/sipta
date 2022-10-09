<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $k_data => $v_data): ?>
		<tr>
			<td><?php echo $v_data['nama']; ?></td>
			<td>
				<?php $idx = 1; ?>
				<?php foreach ($v_data['sk_pembimbing_dosen'] as $k_skp => $v_skp): ?>
					<?php echo $idx.'. '.$v_skp['nama']; ?>
					<?php $idx++; ?>
				<?php endforeach ?>
			</td>
			<td>
				<div class="col-xs-6 no-padding" style="padding-right: 5px; display: flex; justify-content: center; align-items: center;">
					<?php if ( $akses['a_edit'] == 1 ) { ?>
						<button class="col-xs-12 btn btn-primary" onclick="skp.modalEditForm(this);" data-id="<?php echo $v_data['id']; ?>"><i class="fa fa-edit"></i></button>
					<?php } ?>
				</div>
				<div class="col-xs-6 no-padding" style="padding-left: 5px; display: flex; justify-content: center; align-items: center;">
					<?php if ( $akses['a_delete'] == 1 ) { ?>
						<button class="col-xs-12 btn btn-danger" onclick="skp.delete(this);" data-id="<?php echo $v_data['id']; ?>"><i class="fa fa-trash"></i></button>
					<?php } ?>
				</div>
			</td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="3">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>