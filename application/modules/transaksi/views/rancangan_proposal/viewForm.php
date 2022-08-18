<div class="col-xs-12 no-padding formPengajuan">
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">Prodi</label>
		</div>
		<div class="col-xs-12 no-padding" style="padding-left: 15px;">
			<span><?php echo $data['prodi']['nama']; ?></span>
		</div>
	</div>
	<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">Mahasiswa</label>
		</div>
		<div class="col-xs-12 no-padding" style="padding-left: 15px;">
			<span><?php echo $data['mahasiswa']['nama']; ?></span>
		</div>
	</div>
	<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">NIM</label>
		</div>
		<div class="col-xs-12 no-padding" style="padding-left: 15px;">
			<span><?php echo $data['nim']; ?></span>
		</div>
	</div>
	<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">No. HP</label>
		</div>
		<div class="col-xs-12 no-padding" style="padding-left: 15px;">
			<span><?php echo $data['no_telp']; ?></span>
		</div>
	</div>
	<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">Judul Penelitian</label>
		</div>
		<div class="col-xs-12 no-padding" style="padding-left: 15px;">
			<span><?php echo strtoupper($data['judul_penelitian']); ?></span>
		</div>
	</div>
	<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">Tahun Akademik</label>
		</div>
		<div class="col-xs-12 no-padding" style="padding-left: 15px;">
			<span><?php echo $data['tahun_akademik']; ?></span>
		</div>
	</div>

	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>

	<?php 
		$isi = 0;
		if ( $data['g_status'] == getStatus('submit') ) {
			if ( $akses['a_approve'] == 1 ) {
				$isi = 1;
			} else {
				$isi = 0;
			}
		} else {
			$isi = 0;
		}
	?>

	<?php if ( $isi == 1 ): ?>
		<?php for ($i=0; $i < 2; $i++) { ?>
			<?php
				$nip = null;
				$nama = null;
				$no_telp = null;
				if ( isset($data['list_pembimbing'][$i]) ) {
					$nip = $data['list_pembimbing'][$i]['nip'];
					$nama = $data['list_pembimbing'][$i]['nama'];
					$no_telp = $data['list_pembimbing'][$i]['no_telp'];
				}
			?>

			<div class="col-xs-12 no-padding pembimbing" data-no="<?php echo $i+1; ?>" style="margin-bottom: 5px;">
				<div class="col-xs-12 no-padding">
					<div class="col-xs-12 no-padding">
						<label class="control-label">Pembimbing <?php echo $i+1; ?></label>
					</div>
					<div class="col-xs-12 no-padding">
						<select class="form-control pembimbing" data-required="1">
							<option value="">-- Pilih Dosen --</option>
							<?php if ( !empty($dosen) ): ?>
								<?php foreach ($dosen as $k_dosen => $v_dosen): ?>
									<?php
										$selected = null;
										if ( $nip == $v_dosen['nip'] ) {
											$selected = 'selected';
										}
									?>
									<option value="<?php echo $v_dosen['nip']; ?>" data-nama="<?php echo $v_dosen['nama']; ?>" <?php echo $selected; ?> ><?php echo strtoupper($v_dosen['nip'].' | '.$v_dosen['nama']); ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</div>
				</div>
				<div class="col-xs-12 no-padding">
					<div class="col-xs-12 no-padding">
						<label class="control-label">No. HP</label>
					</div>
					<div class="col-xs-12 no-padding">
						<input type="text" class="form-control no_telp_pembimbing" placeholder="No. Telp" value="<?php echo $no_telp; ?>" data-required="1">
					</div>
				</div>
			</div>
		<?php } ?>

		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>

		<?php for ($i=0; $i < 4; $i++) { ?>
			<?php 
				$data_required = 1;
				if ( $i == 3 ) {
					$data_required = 0;
				}

				$selected_luar = null;
				$hide_luar = 'hide';
				$selected_dalam = null;
				$hide_dalam = 'hide';
				$nip = null;
				$nama = null;
				if ( isset($data['list_penguji'][$i]) ) {
					if ( $data['list_penguji'][$i]['jenis_dosen'] == 'luar' ) {
						$selected_luar = 'selected';
						$hide_luar = null;
					}
					if ( $data['list_penguji'][$i]['jenis_dosen'] == 'dalam' ) {
						$selected_dalam = 'selected';
						$hide_dalam = null;
					}
					$nip = $data['list_penguji'][$i]['nip'];
					$nama = $data['list_penguji'][$i]['nama'];
				} else {
					$hide_dalam = null;
				}
			?>
			<div class="col-xs-12 no-padding penguji" data-no="<?php echo $i+1; ?>" style="margin-bottom: 5px;">
				<div class="col-xs-4 no-padding" style="padding-right: 5px;">
					<div class="col-xs-12 no-padding">
						<label class="control-label">Jenis Penguji</label>
					</div>
					<div class="col-xs-12 no-padding">
					<select class="form-control jenis_penguji" data-required="<?php echo $data_required; ?>" onclick="rp.pilihJenisPenguji(this)">
							<option value="">-- Pilih --</option>
							<option value="luar" <?php echo $selected_luar; ?> >DOSEN LUAR</option>
							<option value="dalam" <?php echo $selected_dalam; ?> >DOSEN DALAM</option>
						</select>
					</div>
				</div>
				<div class="col-xs-8 no-padding dosen_penguji" style="padding-left: 5px;">
					<div class="col-xs-12 no-padding">
						<label class="control-label">Penguji <?php echo $i+1; ?></label>
					</div>
					<div class="col-xs-12 no-padding jenis_dosen dalam <?php echo $hide_dalam; ?>">
						<select class="form-control dosen" data-required="<?php echo $data_required; ?>">
							<option value="">-- Pilih Dosen --</option>
							<?php if ( !empty($dosen) ): ?>
								<?php foreach ($dosen as $k_dosen => $v_dosen): ?>
									<?php
										$selected = null;
										if ( $nip == $v_dosen['nip'] ) {
											$selected = 'selected';
										}
									?>
									<option value="<?php echo $v_dosen['nip']; ?>" data-nama="<?php echo $v_dosen['nama']; ?>" <?php echo $selected; ?> ><?php echo strtoupper($v_dosen['nip'].' | '.$v_dosen['nama']); ?></option>
								<?php endforeach ?>
							<?php endif ?>
						</select>
					</div>
					<div class="col-xs-12 no-padding jenis_dosen luar <?php echo $hide_luar; ?>">
						<input type="text" class="form-control uppercase dosen" placeholder="Nama Penguji" value="<?php echo $nama; ?>" >
					</div>
				</div>
			</div>
		<?php } ?>
	<?php else: ?>
		<?php if ( !empty($data['list_pembimbing']) ): ?>
			<?php $idx = 1; ?>
			<?php foreach ($data['list_pembimbing'] as $k_pd => $v_pd): ?>
				<div class="col-xs-12 no-padding pembimbing" style="margin-bottom: 5px;">
					<div class="col-xs-12 no-padding">
						<div class="col-xs-12 no-padding">
							<label class="control-label">Pembimbing <?php echo $idx; ?></label>
						</div>
						<div class="col-xs-12 no-padding" style="padding-left: 15px;">
							<?php echo $v_pd['nama'] ?>
						</div>
					</div>
					<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
					<div class="col-xs-12 no-padding">
						<div class="col-xs-12 no-padding">
							<label class="control-label">No. HP</label>
						</div>
						<div class="col-xs-12 no-padding" style="padding-left: 15px;">
							<?php echo $v_pd['no_telp'] ?>
						</div>
					</div>
					<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
				</div>
				<?php $idx++; ?>
			<?php endforeach ?>
		<?php endif ?>

		<?php if ( !empty($data['list_penguji']) ): ?>
			<!-- <div class="col-xs-12 no-padding" style="margin-bottom: 5px;"><hr style="margin-top: 10px; margin-bottom: 10px;"></div> -->

			<?php $no = 1; ?>
			<?php foreach ($data['list_penguji'] as $k_pd => $v_pd): ?>
				<div class="col-xs-12 no-padding penguji" style="margin-bottom: 5px;">
					<div class="col-xs-4 no-padding" style="padding-right: 5px;">
						<div class="col-xs-12 no-padding">
							<label class="control-label">Jenis Penguji</label>
						</div>
						<div class="col-xs-12 no-padding" style="padding-left: 15px;">
							<span><?php echo strtoupper('dosen '.$v_pd['jenis_dosen']); ?></span>
						</div>
					</div>
					<div class="col-xs-8 no-padding dosen_penguji" style="padding-left: 5px;">
						<div class="col-xs-12 no-padding">
							<label class="control-label">Penguji <?php echo $no; ?></label>
						</div>
						<div class="col-xs-12 no-padding" style="padding-left: 15px;">
							<span><?php echo strtoupper($v_pd['nama']); ?></span>
						</div>
					</div>
				</div>
				<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>
				<?php $no++; ?>
			<?php endforeach ?>
		<?php endif ?>
	<?php endif ?>

	<!-- <div class="col-xs-12 no-padding" style="margin-bottom: 5px;"><hr style="margin-top: 10px; margin-bottom: 10px;"></div> -->

	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<div class="col-xs-12 no-padding">
			<label class="control-label">Waktu Konsul</label>
		</div>
		<div class="col-xs-12 no-padding" style="padding-left: 15px;">
			<span><?php echo strtoupper(tglIndonesia($data['waktu_konsul'], '-', ' ', true)); ?></span>
		</div>
	</div>

	<?php if ( !empty($data['rancangan_proposal_kelengkapan']) ): ?>
		<div class="col-xs-12 no-padding"><hr style="margin-top: 5px; margin-bottom: 5px;"></div>

		<div class="col-xs-12 no-padding list_kelengkapan_pengajuan">
			<?php foreach ($data['rancangan_proposal_kelengkapan'] as $k_pk => $v_pk): ?>
				<div class="col-xs-12 no-padding kelengkapan_pengajuan" style="margin-bottom: 5px;">
					<div class="col-xs-12 no-padding">
						<label class="control-label"><?php echo $v_pk['kelengkapan_pengajuan']['nama']; ?></label>
					</div>
					<div class="col-xs-12 no-padding">
						<?php if ( !empty($v_pk['lampiran']) ): ?>
							<a name="dokumen" class="text-right btn btn-default" target="_blank" style="padding-right: 10px;" href="uploads/<?php echo $v_pk['lampiran']; ?>"><i class="fa fa-download"></i> File</a>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	<?php endif ?>

	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<hr style="margin-top: 10px; margin-bottom: 10px;">
	</div>

	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<?php if ( $data['g_status'] == 1 ): ?>
			<?php if ( $akses['a_approve'] == 0 ) { ?>
				<?php if ( $akses['a_delete'] == 1 ) { ?>
					<button type="button" class="btn btn-danger pull-right" onclick="rp.delete(this)" data-kode="<?php echo $data['kode']; ?>" style="margin-right: 5px;"><i class="fa fa-trash"></i> Hapus</button>
				<?php } ?>
			<?php } else { ?>
				<?php if ( $akses['a_approve'] == 1 ) { ?>
					<button type="button" class="btn btn-primary pull-right" onclick="rp.approve_reject(this)" data-kode="<?php echo $data['kode']; ?>" data-jenis="approve" style="margin-left: 5px;"><i class="fa fa-check"></i> Approve</button>
				<?php } ?>
				<?php if ( $akses['a_reject'] == 1 ) { ?>
					<button type="button" class="btn btn-danger pull-right" onclick="rp.approve_reject(this)" data-kode="<?php echo $data['kode']; ?>" data-jenis="reject" style="margin-right: 5px;"><i class="fa fa-times"></i> Reject</button>
				<?php } ?>
			<?php } ?>
		<?php endif ?>
	</div>
</div>