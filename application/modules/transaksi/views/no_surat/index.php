<div class="row content-panel">
	<div class="col-lg-12 detailed">
		<form role="form" class="form-horizontal">
			<div class="col-xs-12 no-padding">
				<?php if ( $akses['a_submit'] == 1 ): ?>
					<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
						<button type="button" class="col-xs-12 btn btn-primary pull-right" onclick="ns.modalAddForm()" data-href="action" data-edit=""><i class="fa fa-plus"></i> ISI NO SURAT</button>
					</div>
					<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
				<?php endif ?>

				<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
					<div class="col-xs-12 no-padding">
						<label class="control-label">Tgl Awal</label>
					</div>
					<div class="col-xs-12 no-padding">
						<div class="input-group date datetimepicker" name="startDate" id="StartDate">
					        <input type="text" class="form-control text-center" placeholder="Tanggal" data-required="1" />
					        <span class="input-group-addon">
					            <span class="glyphicon glyphicon-calendar"></span>
					        </span>
					    </div>
					</div>
				</div>

				<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
					<div class="col-xs-12 no-padding">
						<label class="control-label">Tgl Akhir</label>
					</div>
					<div class="col-xs-12 no-padding">
						<div class="input-group date datetimepicker" name="endDate" id="EndDate">
					        <input type="text" class="form-control text-center" placeholder="Tanggal" data-required="1" />
					        <span class="input-group-addon">
					            <span class="glyphicon glyphicon-calendar"></span>
					        </span>
					    </div>
					</div>
				</div>

				<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
					<button type="button" class="col-xs-12 btn btn-primary pull-right tampilkan_riwayat" onclick="ns.getLists(this)"><i class="fa fa-search"></i> Tampilkan</button>
				</div>

				<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>

				<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
					<!-- <span>* Klik pada baris untuk melihat detail</span> -->
					<small>
						<table class="table table-bordered tbl_riwayat">
							<thead>
								<tr>
									<th class="col-xs-1">Kode Pengajuan</th>
									<th class="col-xs-1">Tanggal</th>
									<th class="col-xs-2">Jenis Pengajuan</th>
									<th class="col-xs-2">Mahasiswa</th>
									<th class="col-xs-1">Tgl Ujian</th>
									<th class="col-xs-1">Jam</th>
									<th class="col-xs-2">No. Surat</th>
									<?php if ( $akses['a_approve'] == 0 && $akses['a_delete'] == 1 ): ?>
										<th class="col-xs-1">Action</th>
									<?php endif ?>
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
		</form>
	</div>
</div>