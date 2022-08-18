<?php if ( $akses['a_submit'] == 1 ): ?>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<button type="button" class="col-xs-12 btn btn-success pull-right" onclick="pt.changeTabActive(this)" data-href="action" data-edit=""><i class="fa fa-plus"></i> ADD</button>
	</div>

	<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
<?php endif ?>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">JENIS PENGAJUAN</label>
	</div>
	<div class="col-xs-12 no-padding">
		<select class="form-control jenis_pengajuan" data-required="1" onchange="pt.kelengkapanBlangko(this)">
			<option value="">-- Pilih Pengajuan --</option>
			<option value="all">ALL</option>
			<?php if ( !empty($jenis_pengajuan) ): ?>
				<?php foreach ($jenis_pengajuan as $k_jenis_pengajuan => $v_jenis_pengajuan): ?>
					<option value="<?php echo $v_jenis_pengajuan['kode']; ?>"><?php echo strtoupper($v_jenis_pengajuan['nama']); ?></option>
				<?php endforeach ?>
			<?php endif ?>
		</select>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<button type="button" class="col-xs-12 btn btn-primary pull-right tampilkan_riwayat" onclick="pt.getLists(this)"><i class="fa fa-search"></i> Tampilkan</button>
</div>

<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<span>* Klik pada baris untuk melihat detail</span>
	<small>
		<table class="table table-bordered tbl_riwayat">
			<thead>
				<tr>
					<th class="col-xs-2">Tanggal</th>
					<th class="col-xs-4">Jenis Pengajuan</th>
					<th class="col-xs-6">Judul Penelitian</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="3">Data tidak ditemukan.</td>
				</tr>
			</tbody>
		</table>
	</small>
</div>