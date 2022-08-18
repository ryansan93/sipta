<?php if ( !empty($data) ): ?>
	<?php foreach ($data as $k_data => $v_data): ?>
		<div class="col-xs-12 no-padding kelengkapan" data-kode="<?php echo $v_data['kode']; ?>" style="margin-bottom: 5px;">
			<div class="col-xs-12 no-padding">
				<label class="control-label"><?php echo $v_data['nama']; ?></label>
			</div>
			<div class="col-xs-12 no-padding">
				<div class="col-xs-12 no-padding attachment" style="margin-top: 0px;">
		            <label class="" style="margin-bottom: 0px;">
		                <input style="display: none;" placeholder="Dokumen" class="file_lampiran no-check" type="file" onchange="pt.showNameFile(this)" data-name="name" data-allowtypes="pdf|PDF|jpg|JPG|jpeg|JPEG|png|PNG" data-required="<?php echo $v_data['nama']; ?>">
		                <div class="btn btn-default"><i class="fa fa-upload"></i> Upload</div>
		            </label>
					<a name="dokumen" class="text-right hide" target="_blank" style="padding-right: 10px;"><i class="fa fa-file"></i></a>
				</div>
			</div>
		</div>
	<?php endforeach ?>
<?php endif ?>