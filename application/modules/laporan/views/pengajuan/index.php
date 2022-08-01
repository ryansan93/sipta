<div class="row content-panel">
	<div class="col-lg-12 detailed">
		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label">Tgl Pengajuan Awal</label>
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
				<label class="control-label">Tgl Pengajuan Akhir</label>
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
			<div class="col-xs-12 no-padding">
				<label class="control-label">Dosen Pembimbing</label>
			</div>
			<div class="col-xs-12 no-padding">
				<select class="dosen" name="dosen[]" multiple="multiple" width="100%" data-required="1">
					<option value="all" > All </option>
					<?php foreach ($dosen as $key => $v_dosen): ?>
						<option value="<?php echo $v_dosen['nip']; ?>" > <?php echo strtoupper($v_dosen['nama']); ?> </option>
					<?php endforeach ?>
				</select>
			</div>
		</div>

		<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
			<button type="button" class="col-xs-12 btn btn-primary pull-right tampilkan_riwayat" onclick="pengajuan.getLists(this)"><i class="fa fa-search"></i> Tampilkan</button>
		</div>

		<div class="col-xs-12 no-padding"><hr></div>
			<div class="col-xs-12 no-padding">
				<div class="panel-heading no-padding">
					<ul class="nav nav-tabs nav-justified">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#by_tanggal" data-tab="by_tanggal">BY TANGGAL</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#by_dosen" data-tab="by_dosen">BY DOSEN</a>
						</li>
					</ul>
				</div>
				<div class="panel-body no-padding">
					<div class="tab-content">
						<div id="by_tanggal" class="tab-pane fade show active" role="tabpanel" style="padding-top: 10px;">
							<?php echo $report_by_tanggal; ?>
						</div>

						<div id="by_dosen" class="tab-pane fade" role="tabpanel" style="padding-top: 10px;">
							<?php echo $report_by_dosen; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>