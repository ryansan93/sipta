<div class="modal-header header" style="padding-left: 8px; padding-right: 8px;">
	<span class="modal-title">Edit Durasi Pelaksanaan</span>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body body">
	<div class="row">
		<div class="col-sm-12 no-padding">
			<div class="col-sm-12 no-padding">
				<label class="control-label">Durasi (Menit)</label>
			</div>
			<div class="col-sm-12 no-padding">
				<input type="text" class="form-control text-right durasi" data-required="1" placeholder="Durasi" data-tipe="integer" value="<?php echo angkaRibuan($data['durasi']); ?>">
			</div>
		</div>
		<div class="col-sm-12 no-padding" style="padding-left: 8px; padding-right: 8px;">
			<hr>
			<button type="button" class="btn btn-primary pull-right" onclick="dp.edit(this)" data-id="<?php echo $data['id']; ?>">
				<i class="fa fa-save"></i>
				Save
			</button>
		</div>
	</div>
</div>