<div class="row content-panel detailed">
	<div class="col-lg-12 detailed">
		<div class="col-lg-8 search left-inner-addon no-padding">
			<i class="glyphicon glyphicon-search"></i><input class="form-control" type="search" data-table="tbl_jp" placeholder="Search" onkeyup="filter_all(this)">
		</div>
		<div class="col-lg-4 action no-padding">
			<?php if ( $akses['a_submit'] == 1 ) { ?>
				<button id="btn-add" type="button" data-href="action" class="btn btn-primary cursor-p pull-right" title="ADD" onclick="kp.modalAddForm(this)"> 
					<i class="fa fa-plus" aria-hidden="true"></i> ADD
				</button>
			<?php } else { ?>
				<div class="col-lg-2 action no-padding pull-right">
					&nbsp
				</div>
			<?php } ?>
		</div>
		<small>
			<table class="table table-bordered table-hover tbl_jp" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th class="col-sm-1 text-center">Kode</th>
						<th class="col-sm-3 text-center">Jenis Pengajuan</th>
						<th class="col-sm-4 text-center">Nama</th>
						<th class="col-sm-1 text-center">Wajib</th>
						<th class="col-sm-1 text-center hide">Jumlah File</th>
						<th class="col-sm-2 text-center">Action</th>
					</tr>
				</thead>
				<tbody class="list">
					<?php if ( !empty($data) ): ?>
						<?php foreach ($data as $k_data => $v_data): ?>
							<tr>
								<td class="kode"><?php echo $v_data['kode']; ?></td>
								<td><?php echo $v_data['jenis_pengajuan']['nama']; ?></td>
								<td><?php echo $v_data['nama']; ?></td>
								<td class="text-center"><?php echo ($v_data['wajib'] == 1) ? 'WAJIB' : 'TIDAK WAJIB'; ?></td>
								<td class="text-right hide"><?php echo angkaRibuan($v_data['jml_file']); ?></td>
								<td>
									<div class="col-sm-6 no-padding" style="display: flex; justify-content: center; align-items: center;">
										<?php if ( $akses['a_edit'] == 1 ) { ?>
											<button class="btn btn-primary" onclick="kp.modalEditForm(this);"><i class="fa fa-edit"></i></button>
										<?php } ?>
									</div>
									<div class="col-sm-6 no-padding" style="display: flex; justify-content: center; align-items: center;">
										<?php if ( $akses['a_delete'] == 1 ) { ?>
											<button class="btn btn-danger" onclick="kp.delete(this);"><i class="fa fa-trash"></i></button>
										<?php } ?>
									</div>
								</td>
							</tr>
						<?php endforeach ?>
					<?php else: ?>
						<tr>
							<td colspan="5">Data tidak ditemukan.</td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
		</small>
	</div>
</div>