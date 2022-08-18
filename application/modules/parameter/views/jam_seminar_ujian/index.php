<div class="row content-panel detailed">
	<div class="col-lg-12 detailed">
		<div class="col-lg-8 search left-inner-addon no-padding">
			<i class="glyphicon glyphicon-search"></i><input class="form-control" type="search" data-table="tbl_jam" placeholder="Search" onkeyup="filter_all(this)">
		</div>
		<div class="col-lg-4 action no-padding">
			<?php if ( $akses['a_submit'] == 1 ) { ?>
				<button id="btn-add" type="button" data-href="action" class="btn btn-primary cursor-p pull-right" title="ADD" onclick="jsu.modalAddForm(this)"> 
					<i class="fa fa-plus" aria-hidden="true"></i> ADD
				</button>
			<?php } else { ?>
				<div class="col-lg-2 action no-padding pull-right">
					&nbsp
				</div>
			<?php } ?>
		</div>
		<small>
			<table class="table table-bordered table-hover tbl_jam" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th class="col-sm-3 text-center">Jenis Pengajuan</th>
						<th class="col-sm-1 text-center">Awal</th>
						<th class="col-sm-1 text-center">Akhir</th>
						<th class="col-sm-1 text-center">Status</th>
						<th class="col-sm-1 text-center">Action</th>
					</tr>
				</thead>
				<tbody class="list">
					<?php if ( !empty($data) ): ?>
						<?php foreach ($data as $k_data => $v_data): ?>
							<tr class="search" data-kode="<?php echo $v_data['id']; ?>">
								<td><?php echo $v_data['jenis_pengajuan']['nama']; ?></td>
								<td><?php echo substr($v_data['awal'], 0, 5); ?></td>
								<td><?php echo substr($v_data['akhir'], 0, 5); ?></td>
								<td><?php echo ($v_data['mstatus'] == 1) ? 'AKTIF' : 'NON AKTIF'; ?></td>
								<td>
									<div class="col-sm-6 no-padding" style="display: flex; justify-content: center; align-items: center;">
										<?php if ( $akses['a_edit'] == 1 ) { ?>
											<button class="btn btn-primary" onclick="jsu.modalEditForm(this);"><i class="fa fa-edit"></i></button>
										<?php } ?>
									</div>
									<div class="col-sm-6 no-padding" style="display: flex; justify-content: center; align-items: center;">
										<?php if ( $akses['a_delete'] == 1 ) { ?>
											<button class="btn btn-danger" onclick="jsu.delete(this);"><i class="fa fa-trash"></i></button>
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