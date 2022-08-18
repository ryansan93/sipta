<?php if ( $akses['a_submit'] == 1 ): ?>
	<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
		<button type="button" class="col-xs-12 btn btn-success pull-right" onclick="js.changeTabActive(this)" data-href="action" data-edit=""><i class="fa fa-plus"></i> ADD</button>
	</div>

	<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>
<?php endif ?>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<div class="col-xs-12 no-padding">
		<label class="control-label">Tgl Awal</label>
	</div>
	<div class="col-xs-12 no-padding">
		<div class="input-group date datetimepicker" name="startDate" id="StartDate">
	        <input type="text" class="form-control text-center" placeholder="Tanggal" data-required="1"/>
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
	        <input type="text" class="form-control text-center" placeholder="Tanggal" data-required="1"/>
	        <span class="input-group-addon">
	            <span class="glyphicon glyphicon-calendar"></span>
	        </span>
	    </div>
	</div>
</div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<button type="button" class="col-xs-12 btn btn-primary pull-right tampilkan_riwayat" onclick="js.getLists()"><i class="fa fa-search"></i> Tampilkan</button>
</div>

<div class="col-xs-12 no-padding"><hr style="margin-top: 10px; margin-bottom: 10px;"></div>

<div class="col-xs-12 no-padding" style="margin-bottom: 5px;">
	<span>* Klik pada baris untuk melihat detail</span>
	<small>
		<table class="table table-bordered tbl_riwayat">
			<thead>
				<tr>
					<th class="col-xs-4">Kode Jadwal</th>
					<th class="col-xs-8">Tanggal Berlaku</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2">Data tidak ditemukan.</td>
				</tr>
			</tbody>
		</table>
	</small>
</div>