var dosen = {
	start_up: function () {
	}, // end - start_up

	modalAddForm: function () {
		$('.modal').modal('hide');

        $.get('parameter/Dosen/modalAddForm',{
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

        $.get('parameter/Dosen/modalEditForm',{
            'nip': $(tr).find('td.nip').text()
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
			var nip = $(div).find('.nip').val().toUpperCase();
			var nidn = $(div).find('.nidn').val().toUpperCase();
			var nama = $(div).find('.nama').val();
			var no_telp = $(div).find('.no_telp').val().toUpperCase();
			var email = $(div).find('.email').val();

			bootbox.confirm('Apakah anda yakin ingin menyimpan data ?', function(result) {
				if ( result ) {
					var data = {
						'nip': nip,
						'nidn': nidn,
						'nama': nama,
						'no_telp': no_telp,
						'email': email
					};

			        $.ajax({
			            url: 'parameter/Dosen/save',
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
			var nip = $(div).find('.nip').val().toUpperCase();
			var nidn = $(div).find('.nidn').val().toUpperCase();
			var nama = $(div).find('.nama').val();
			var no_telp = $(div).find('.no_telp').val().toUpperCase();
			var email = $(div).find('.email').val();

			bootbox.confirm('Apakah anda yakin ingin meng-ubah data ?', function(result) {
				if ( result ) {
					var data = {
						'nip': nip,
						'nidn': nidn,
						'nama': nama,
						'no_telp': no_telp,
						'email': email
					};

			        $.ajax({
			            url: 'parameter/Dosen/edit',
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
				var nip = $(tr).find('td.nip').text();

		        $.ajax({
		            url: 'parameter/Dosen/delete',
		            data: {
		                'nip': nip
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

dosen.start_up();