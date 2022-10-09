<div class="row content-panel detailed">
	<div class="col-xs-12 detailed">
		<div class="col-xs-12 no-padding">
			<?php if ( $akses['a_submit'] == 1 ): ?>
				<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
					<button type="button" class="col-xs-12 btn btn-success pull-right" onclick="skp.modalAddForm(this)"><i class="fa fa-plus"></i> ADD</button>
				</div>

				<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
			<?php endif ?>

			<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label">Jenis Filter</label>
				</div>
				<div class="col-xs-12 no-padding">
					<select class="form-control jenis_filter" data-required="1" onchange="skp.changeFilter(this)">
						<option value="mahasiswa" selected>Mahasiswa</option>
						<option value="dosen">Dosen</option>
					</select>
				</div>
			</div>

			<div class="col-xs-12 no-padding mahasiswa" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label">Mahasiswa</label>
				</div>
				<div class="col-xs-12 no-padding">
					<select class="col-sm-12 form-control mahasiswa" data-required="1">
						<option value="">-- Pilih Mahasiswa --</option>
						<?php if ( !empty($mahasiswa) ): ?>
							<?php foreach ($mahasiswa as $key => $value): ?>
								<option value="<?php echo $value['nim']; ?>"><?php echo strtoupper($value['nim'].' | '.$value['nama']); ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
				</div>
			</div>

			<div class="col-xs-12 no-padding dosen hide" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<label class="control-label">Dosen</label>
				</div>
				<div class="col-xs-12 no-padding">
					<select class="col-sm-12 form-control dosen" data-required="1">
						<option value="">-- Pilih Dosen --</option>
						<?php if ( !empty($dosen) ): ?>
							<?php foreach ($dosen as $key => $value): ?>
								<option value="<?php echo $value['nip']; ?>"><?php echo strtoupper($value['nip'].' | '.$value['nama']); ?></option>
							<?php endforeach ?>
						<?php endif ?>
					</select>
				</div>
			</div>

			<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
				<button type="button" class="col-xs-12 btn btn-primary pull-right tampilkan_riwayat" onclick="skp.getLists()"><i class="fa fa-search"></i> Tampilkan</button>
			</div>

			<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
		</div>
		<div class="col-xs-12 search left-inner-addon no-padding" style="margin-bottom: 10px;">
			<i class="glyphicon glyphicon-search"></i><input class="form-control" type="search" data-table="tbl_riwayat" placeholder="Search" onkeyup="filter_all(this)">
		</div>
		<small>
			<table class="table table-bordered table-hover tbl_riwayat" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th class="col-xs-4 text-center">Mahasiswa</th>
						<th class="col-xs-6 text-center">Dosen Pembimbing</th>
						<th class="col-xs-2 text-center">Action</th>
					</tr>
				</thead>
				<tbody class="list">
					<tr>
						<td colspan="3">Data tidak ditemukan.</td>
					</tr>
				</tbody>
			</table>
		</small>
	</div>
</div>