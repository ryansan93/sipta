<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $k_data => $v_data): ?>
		<tr class="header">
			<td class="text-center">
				<i class="fa fa-caret-square-o-right cursor-p" style="font-size: 18px;" onclick="dhs.collapseRow(this)"></i>
			</td>
			<td class="text-center"><?php echo strtoupper(tglIndonesia($v_data['tanggal'], '-', ' ')); ?></td>
			<td class="text-center">
				<?php echo substr($v_data['jam_mulai'], 0, 5); ?>
				<br>
				<?php echo substr($v_data['jam_selesai'], 0, 5); ?>
			</td>
			<td class="text-center"><?php echo strtoupper($v_data['jenis_pelaksanaan']); ?></td>
			<td><?php echo !empty($v_data['ruang_kelas']) ? strtoupper($v_data['ruang_kelas']) : '-'; ?></td>
			<td>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-5 no-padding">AKUN</div>
					<div class="col-xs-7 no-padding">: <?php echo !empty($v_data['akun_zoom']) ? $v_data['akun_zoom'] : '-'; ?></div>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-5 no-padding">ID MEETING</div>
					<div class="col-xs-7 no-padding">: <?php echo !empty($v_data['id_meeting']) ? $v_data['id_meeting'] : '-'; ?></div>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-5 no-padding">PASSWORD</div>
					<div class="col-xs-7 no-padding">: <?php echo !empty($v_data['password_meeting']) ? $v_data['password_meeting'] : '-'; ?></div>
				</div>
			</td>
			<td><?php echo strtoupper($v_data['judul_penelitian']); ?></td>
		</tr>
		<tr class="detail hide">
			<td colspan="7" style="background-color: #ededed;">
				<table class="table table-bordered tbl_mahasiswa" style="margin-bottom: 0px;">
					<thead>
						<tr>
							<th class="col-xs-3">NIM</th>
							<th class="col-xs-5">Nama</th>
							<th class="col-xs-4">Prodi</th>
						</tr>
					</thead>
					<tbody>
						<?php if ( !empty($v_data['list_mahasiswa']) ): ?>
							<?php foreach ($v_data['list_mahasiswa'] as $k_lm => $v_lm): ?>
								<tr>
									<td><?php echo strtoupper($v_lm['nim']); ?></td>
									<td><?php echo strtoupper($v_lm['nama']); ?></td>
									<td><?php echo strtoupper($v_lm['prodi']); ?></td>
								</tr>
							<?php endforeach ?>
						<?php else: ?>
							<tr>
								<td colspan="3">Data tidak ditemukan.</td>
							</tr>
						<?php endif ?>
					</tbody>
				</table>
			</td>
		</tr>
	<?php endforeach ?>
<?php else: ?>
	<tr>
		<td colspan="7">Data tidak ditemukan.</td>
	</tr>
<?php endif ?>