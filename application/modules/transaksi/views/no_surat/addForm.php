<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Add No Surat</span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body body">
	<div class="row">
		<div class="col-sm-12 no-padding">
			<small>
				<table class="table table-bordered" style="margin-bottom: 0px;">
					<thead>
						<tr>
							<th class="col-xs-1">Kode Pengajuan</th>
							<th class="col-xs-1">Tanggal</th>
							<th class="col-xs-2">Jenis Pengajuan</th>
							<th class="col-xs-2">Mahasiswa</th>
							<th class="col-xs-1">Tgl Ujian</th>
							<th class="col-xs-1">Jam</th>
							<th class="col-xs-2">No. Surat</th>
						</tr>
					</thead>
					<tbody>
						<?php if ( !empty($pengajuan) ): ?>
							<?php foreach ($pengajuan as $key => $value): ?>
								<tr>
									<td class="text-center kode_pengajuan"><?php echo $value['kode']; ?></td>
									<td class="text-center"><?php echo tglIndonesia($value['tgl_pengajuan'], '-', ' '); ?></td>
									<td><?php echo $value['nama_mahasiswa']; ?></td>
									<td><?php echo $value['nama_jenis_pengajuan']; ?></td>
									<td class="text-center"><?php echo tglIndonesia($value['jadwal'], '-', ' '); ?></td>
									<td class="text-center"><?php echo substr($value['jam_pelaksanaan'], 0, 5); ?></td>
									<td>
										<input type="text" class="form-control no_surat" placeholder="No. Surat">
									</td>
								</tr>
							<?php endforeach ?>
						<?php else: ?>
							<tr>
								<td colspan="7">Data pengajuan tidak ditemukan.</td>
							</tr>
						<?php endif ?>
					</tbody>
				</table>
			</small>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="ns.save()">
				<i class="fa fa-save"></i>
				Save
			</button>
		</div>
	</div>
</div>