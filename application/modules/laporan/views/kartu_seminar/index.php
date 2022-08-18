<div class="row content-panel">
	<div class="col-lg-12 detailed">
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Mahasiswa</label>
			</div>
			<div class="col-xs-12 no-padding">
				<select class="form-control mahasiswa">
					<option value="">-- Pilih Mahasiswa --</option>
					<?php foreach ($mahasiswa as $k_mahasiswa => $v_mahasiswa): ?>
						<option value="<?php echo $v_mahasiswa['nim'] ?>"><?php echo strtoupper($v_mahasiswa['nama']); ?></option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
		<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
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
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="7">Data tidak ditemukan.</td>
						</tr>
					</tbody>
				</table>
			</small>
		</div>
	</div>
</div>