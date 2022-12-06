<div class="row">
	<div class="col-xs-12 text-left">
		<div class="col-xs-12">
			<h1>
				Sistem Informasi Pelayanan Administrasi Tugas Akhir (TA)
			</h1>
		</div>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-12">
			<hr style="margin-top: 10px; margin-bottom: 10px;">
		</div>
	</div>
	<div class="col-xs-12">
		<?php if ( !empty($list_notif) ): ?>
			<?php foreach ($list_notif as $key => $value): ?>
				<?php foreach ($value as $k_val => $val): ?>
					<div class="col-md-4">
						<div class="panel panel-default" style="margin-bottom: 0px;">
							<div class="panel-heading"><?php echo $val['title']; ?></div>
							<div class="panel-body" style="padding: 10px 15px;">
								<div class="col-xs-10 no-padding"><?php echo $val['deskripsi']; ?></div>
								<!-- <div class="col-xs-2 text-right no-padding cursor-p" onclick="window.location.assign('<?php echo $val['action'].$val['params']; ?>')"><span class="dot"><?php echo $val['jumlah']; ?></span></div> -->
								<div class="col-xs-2 text-right no-padding cursor-p" onclick="<?php echo $val['action']; ?>"><span class="dot"><?php echo $val['jumlah']; ?></span></div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			<?php endforeach ?>
			<div class="col-xs-12 no-padding">
				<hr style="margin-top: 10px; margin-bottom: 10px;">
			</div>
		<?php endif ?>
	</div>
	<div class="col-xs-12">
		<div class="col-xs-12">
			<p>Silahkan pelajari dan download petunjuk pengajuan Seminar / Ujian Tugas Akhir beserta Juknis Tugas Akhir sesuai masing-masing Program Studi dibawah ini.</p>

			<table class="table" style="width: 100%; b">
				<tbody>
					<tr>
						<td class="text-center" style="border-top: none; width: 20%; padding-left: 0px;">
							<div class="col-xs-12" style="border: 1px solid #dedede; border-radius: 5px;">
								<div class="col-xs-12 no-padding" style="height: 60px; padding-top: 10px;">
									Petunjuk<br>Pengajuan<br>Seminar / Ujian TA
								</div>
								<div class="col-xs-12 no-padding"><br></div>
								<div class="col-xs-12 no-padding" style="padding-bottom: 10px;">
									<button class="col-xs-12 btn btn-default" onclick="window.open('https://drive.google.com/drive/folders/1SBC0FYoKKwnkNwnduW-OxmG_b1UxR29V?usp=sharing', 'blank')">Download <i class="fa fa-download"></i></button>
								</div>
							</div>
						</td>
						<td class="text-center" style="border-top: none; width: 20%;">
							<div class="col-xs-12" style="border: 1px solid #dedede; border-radius: 5px;">
								<div class="col-xs-12 no-padding" style="height: 60px; padding-top: 10px;">
									Blanko<br>Seminar / Ujian<br>TA
								</div>
								<div class="col-xs-12 no-padding"><br></div>
								<div class="col-xs-12 no-padding" style="padding-bottom: 10px;">
									<button class="col-xs-12 btn btn-default" onclick="window.open('https://drive.google.com/drive/folders/1Xr1Z3UmgqVnjLqMj7E5iTiE4egOuLv_u?usp=share_link', 'blank');">Download <i class="fa fa-download"></i></button>
								</div>
							</div>
						</td>
						<td class="text-center" style="border-top: none; width: 20%;">
							<div class="col-xs-12" style="border: 1px solid #dedede; border-radius: 5px;">
								<div class="col-xs-12 no-padding" style="height: 60px; padding-top: 10px;">
									Juknis Tugas Akhir
								</div>
								<div class="col-xs-12 no-padding"><br></div>
								<div class="col-xs-12 no-padding" style="padding-bottom: 10px;">
									<button class="col-xs-12 btn btn-default" onclick="window.open('https://drive.google.com/drive/folders/1lbNWSvomzR4VOYSa0SgRLEwiJ7HaBbkf?usp=sharing', 'blank');">Download <i class="fa fa-download"></i></button>
								</div>
							</div>
						</td>
						<td class="text-center" style="border-top: none; width: 20%; padding-right: 0px;">
							<div class="col-xs-12" style="border: 1px solid #dedede; border-radius: 5px;">
								<div class="col-xs-12 no-padding" style="height: 60px; padding-top: 10px;">
									SK Dosen Pembimbing TA
								</div>
								<div class="col-xs-12 no-padding"><br></div>
								<div class="col-xs-12 no-padding" style="padding-bottom: 10px;">
									<button class="col-xs-12 btn btn-default" onclick="window.open('https://drive.google.com/drive/folders/1QQFMiocrD9evvcACai_e7n41fWBpNIJY?usp=sharing', 'blank');">Download <i class="fa fa-download"></i></button>
								</div>
							</div>
						</td>
						<!-- <td class="text-center" style="border-top: none; width: 20%;">
							<div class="col-xs-12" style="border: 1px solid #dedede; border-radius: 5px;">
								<div class="col-xs-12 no-padding" style="height: 60px; padding-top: 10px;">
									Juknis TA<br>Penyuluhan<br>(PPB dan PPKH)
								</div>
								<div class="col-xs-12 no-padding"><br></div>
								<div class="col-xs-12 no-padding" style="padding-bottom: 10px;">
									<button class="col-xs-12 btn btn-default" onclick="window.open('assets/document/DRAFT JUKNIS TA ANTAR PRODI PENYULUHAN-FINISH.pdf', 'blank');">Download <i class="fa fa-download"></i></button>
								</div>
							</div>
						</td>
						<td class="text-center" style="border-top: none; width: 20%;">
							<div class="col-xs-12" style="border: 1px solid #dedede; border-radius: 5px;">
								<div class="col-xs-12 no-padding" style="height: 60px; padding-top: 10px;">
									Juknis TA<br>Prodi Agrinak
								</div>
								<div class="col-xs-12 no-padding"><br></div>
								<div class="col-xs-12 no-padding" style="padding-bottom: 10px;">
									<button class="col-xs-12 btn btn-default" onclick="window.open('assets/document/Juknis-TA-AGRINAK 2022-2023 (1).pdf', 'blank');">Download <i class="fa fa-download"></i></button>
								</div>
							</div>
						</td>
						<td class="text-center" style="border-top: none; width: 20%; padding-right: 0px;">
							<div class="col-xs-12" style="border: 1px solid #dedede; border-radius: 5px;">
								<div class="col-xs-12 no-padding" style="height: 60px; padding-top: 10px;">
									Juknis TA<br>Program RPL
								</div>
								<div class="col-xs-12 no-padding"><br></div>
								<div class="col-xs-12 no-padding" style="padding-bottom: 10px;">
									<button class="col-xs-12 btn btn-default" onclick="window.open('assets/document/JUKNIS TA RPL_2022 FIX_220918.pdf', 'blank');">Download <i class="fa fa-download"></i></button>
								</div>
							</div>
						</td> -->
					</tr>
				</tbody>
			</table>

			<!-- <div style="width: 100%; display: table;">
				<div style="width: 25%; padding: 5px; display:table-row;">
					<div class="col-xs-12 no-padding" style="border: 1px solid #dedede;">
						<div class="col-xs-12 no-padding text-center">Petunjuk Pengajuan Seminar / Ujian TA</div>
					</div>
				</div>
				<div style="width: 25%; padding: 5px; display:table-row;">
					<div class="col-xs-12 no-padding" style="border: 1px solid #dedede;">
						<div class="col-xs-12 no-padding text-center">Blanko Seminar / Ujian TA</div>
					</div>
				</div>
				<div style="width: 25%; padding: 5px; display:table-row;">
					<div class="col-xs-12 no-padding" style="border: 1px solid #dedede;">
						<div class="col-xs-12 no-padding text-center">Juknis TA Penyuluhan (PPB dan PPKH)</div>
					</div>
				</div>
				<div style="width: 25%; padding: 5px; display:table-row;">
					<div class="col-xs-12 no-padding" style="border: 1px solid #dedede;">
						<div class="col-xs-12 no-padding text-center">Juknis TA Prodi Agrinak</div>
					</div>
				</div>
				<div style="width: 25%; padding: 5px; display:table-row;">
					<div class="col-xs-12 no-padding" style="border: 1px solid #dedede;">
						<div class="col-xs-12 no-padding text-center">Juknis TA Program RPL</div>
					</div>
				</div>
			</div> -->

			<!-- <p>Tata cara pelaksanaan Seminar Proposal / Hasil Tugas Akhir (TA)</p>
			<p>Bagi Mahasiswa yang akan melakukan Seminar Proposal / Hasil Tugas Akhir (TA) harap memperhatikan tata cara berikut ini :</p>
			<ol style="padding-left: 15px;">
				<li style="padding-left: 15px; padding-bottom: 5px;">Mahasiswa diperkenankan mendaftar Seminar Proposal / Hasil Tugas Akhir (TA) dengan persyaratan yang sudah di tentukan berdasarkan persetujuan Pembimbing 1 dan 2.</li>
				<li style="padding-left: 15px; padding-bottom: 5px;">Pengajuan Seminar Proposal / Hasil Tugas Akhir (TA) dilakukan pada hari kerja dan jam kerja maksimal H-1 pelaksanaan Seminar Proposal / Hasil Tugas Akhir (TA).</li>
				<li style="padding-left: 15px; padding-bottom: 5px;">Silahkan membuat pengajuan Seminar Proposal / Hasil Tugas Akhir (TA) pada menu <b>Tambah Pengajuan</b> kemudian lengkapi form pengajuan yang tersedian.</li>
				<li style="padding-left: 15px; padding-bottom: 5px;">Pastikan kembali data pengajuan serta dokumen (softfile) kelengkapan yang di upload sudah benar dan silahkan menyimpan pengajuan dengan klik tombol <b>Simpan</b>.</li>
				<li style="padding-left: 15px; padding-bottom: 5px;">Silahkan tunggu verifikasi oleh BAAK. Pengajuan yang sudah di verifikasi oleh BAAK akan berubah status menjadi <b>"Sudah di verfikasi"</b>.</li>
				<li style="padding-left: 15px; padding-bottom: 5px;">Silahkan download <b>Surat Undangan</b> Seminar Proposal / Hasil Tugas Akhir (TA) yang tersedia pada pengajuan yang terlah di buat sebelumnya.</li>
				<li style="padding-left: 15px; padding-bottom: 5px;"><b>Blanko Seminar</b> Seminar Proposal / Hasil Tugas Akhir (TA) dapat di download pada link <a href="http://bit.ly/3s7LdEO" target="_blank">http://bit.ly/3s7LdEO</a>.</li>
				<li style="padding-left: 15px; padding-bottom: 5px;">Form penilaian Seminar Proposal / Hasil Tugas Akhir (TA) oleh mahasiswa untuk prodi PPB dan PPKH dapat di download pada link <a href="http://bit.ly/3s7LdEO" target="_blank">http://bit.ly/3s7LdEO</a><b>Untuk prodi Agrinak pada form berikut (diisi oleh Bpk Ibu Dosen, mahasiswa dapat membantu menyiapkan sebelum seminar).</li>
			</ol> -->
		</b>
	</div>
</div>