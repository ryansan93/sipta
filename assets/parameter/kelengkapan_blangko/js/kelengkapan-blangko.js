var kb = {
	start_up: function () {
	}, // end - start_up

	modalAddForm: function () {
		$('.modal').modal('hide');

        $.get('parameter/KelengkapanBlangko/modalAddForm',{
        },function(data){
            var _options = {
                className : 'large',
                message : data,
                addClass : 'form',
                onEscape: true,
            };
            bootbox.dialog(_options).bind('shown.bs.modal', function(){
                $(this).find('.modal-header').css({'padding-top': '0px'});
                $(this).find('.modal-dialog').css({'width': '70%', 'max-width': '100%'});
            });
        },'html');
	}, // end - modalAddForm

	modalEditForm: function (elm) {
		$('.modal').modal('hide');

		var tr = $(elm).closest('tr');

        $.get('parameter/KelengkapanBlangko/modalEditForm',{
            'kode': $(tr).find('td.kode').text()
        },function(data){
            var _options = {
                className : 'large',
                message : data,
                addClass : 'form',
                onEscape: true,
            };
            bootbox.dialog(_options).bind('shown.bs.modal', function(){
                $(this).find('.modal-header').css({'padding-top': '0px'});
                $(this).find('.modal-dialog').css({'width': '70%', 'max-width': '100%'});
            });
        },'html');
	}, // end - modalEditForm

	save: function() {
		var div = $('.modal');

		var err = 0;
		$.map( $(div).find('[data-required=1]'), function(ipt) {
			if ( empty($(ipt).val()) ) {
				$(ipt).parent().addClass('has-error');
				err++;
			} else {
				$(ipt).parent().removeClass('has-error');
			}
		});

		if ( err > 0 ) {
			bootbox.alert('Harap lengkapi data terlebih dahulu.');
		} else {
			var kode = $(div).find('.kode').val().toUpperCase();
			var kode_jenis_pengajuan = $(div).find('.jenis_pengajuan').val();
			var nama = $(div).find('.nama').val().toUpperCase();
			var wajib = $(div).find('.wajib').val();
			var jml_file = numeral.unformat($(div).find('.jml_file').val());

			bootbox.confirm('Apakah anda yakin ingin menyimpan data ?', function(result) {
				if ( result ) {
					var data = {
						'kode': kode,
						'kode_jenis_pengajuan': kode_jenis_pengajuan,
						'nama': nama,
						'wajib': wajib,
						'jml_file': jml_file
					};

			        $.ajax({
			            url: 'parameter/KelengkapanBlangko/save',
			            data: {
			                'params': data
			            },
			            type: 'POST',
			            dataType: 'JSON',
			            beforeSend: function() { showLoading(); },
			            success: function(data) {
			                hideLoading();
			                if ( data.status == 1 ) {
			                	bootbox.alert(data.message, function() {
			                		location.reload();
			                	});
			                } else {
			                    bootbox.alert(data.message);
			                }
			            }
			        });
				}
			});
		}
    }, // end - save

    edit: function() {
		var div = $('.modal');

		var err = 0;
		$.map( $(div).find('[data-required=1]'), function(ipt) {
			if ( empty($(ipt).val()) ) {
				$(ipt).parent().addClass('has-error');
				err++;
			} else {
				$(ipt).parent().removeClass('has-error');
			}
		});

		if ( err > 0 ) {
			bootbox.alert('Harap lengkapi data terlebih dahulu.');
		} else {
			var kode = $(div).find('.kode').val().toUpperCase();
			var kode_jenis_pengajuan = $(div).find('.jenis_pengajuan').val();
			var nama = $(div).find('.nama').val().toUpperCase();
			var wajib = $(div).find('.wajib').val();
			var jml_file = numeral.unformat($(div).find('.jml_file').val());

			bootbox.confirm('Apakah anda yakin ingin meng-ubah data ?', function(result) {
				if ( result ) {
					var data = {
						'kode': kode,
						'kode_jenis_pengajuan': kode_jenis_pengajuan,
						'nama': nama,
						'wajib': wajib,
						'jml_file': jml_file
					};

			        $.ajax({
			            url: 'parameter/KelengkapanBlangko/edit',
			            data: {
			                'params': data
			            },
			            type: 'POST',
			            dataType: 'JSON',
			            beforeSend: function() { showLoading(); },
			            success: function(data) {
			                hideLoading();
			                if ( data.status == 1 ) {
			                	bootbox.alert(data.message, function() {
			                		location.reload();
			                	});
			                } else {
			                    bootbox.alert(data.message);
			                }
			            }
			        });
				}
			});
		}
    }, // end - edit

    delete: function(elm) {
		var tr = $(elm).closest('tr');

		bootbox.confirm('Apakah anda yakin ingin meng-hapus data ?', function(result) {
			if ( result ) {
				kode = $(tr).find('td.kode').text();

		        $.ajax({
		            url: 'parameter/KelengkapanBlangko/delete',
		            data: {
		                'kode': kode
		            },
		            type: 'POST',
		            dataType: 'JSON',
		            beforeSend: function() { showLoading(); },
		            success: function(data) {
		                hideLoading();
		                if ( data.status == 1 ) {
		                	bootbox.alert(data.message, function() {
		                		location.reload();
		                	});
		                } else {
		                    bootbox.alert(data.message);
		                }
		            }
		        });
			}
		});
    }, // end - delete
};

kb.start_up();