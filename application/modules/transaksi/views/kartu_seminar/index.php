<div class="row content-panel">
	<div class="col-lg-12 detailed">
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Jenis Pengajuan</label>
			</div>
			<div class="col-xs-12 no-padding">
				<select class="form-control jenis_pengajuan" data-required="1" onchange="ks.getDataSeminarAktif()">
					<option value="">-- Pilih Jenis Pengajuan --</option>
					<?php if ( !empty($jenis_pengajuan) ): ?>
						<?php foreach ($jenis_pengajuan as $k_jenis_pengajuan => $v_jenis_pengajuan): ?>
							<option value="<?php echo $v_jenis_pengajuan['kode']; ?>"><?php echo strtoupper($v_jenis_pengajuan['nama']); ?></option>
						<?php endforeach ?>
					<?php endif ?>
				</select>
			</div>
		</div>
		<div class="col-xs-12 no-padding">
			<hr style="margin-top: 10px; margin-bottom: 10px;">
		</div>
		<div class="col-xs-12 no-padding">
			<small>
				<table class="table table-bordered tbl_seminar" style="margin-bottom: 0px;">
					<thead>
						<tr>
							<th class="col-xs-1">Tanggal</th>
							<th class="col-xs-1">Mulai<br>Selesai</th>
							<th class="col-xs-1">Pelaksanaan</th>
							<th class="col-xs-1">Ruang / Kelas</th>
							<th class="col-xs-2">Zoom</th>
							<th class="col-xs-2">Mahasiswa</th>
							<th class="col-xs-3">Judul</th>
							<th class="col-xs-1">Check In</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="8">Data tidak ditemukan.</td>
						</tr>
					</tbody>
				</table>
			</small>
		</div>
	</div>
</div>
