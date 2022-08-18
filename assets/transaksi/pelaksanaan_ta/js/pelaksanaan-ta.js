var pt = {
	start_up: function () {
		pt.setting_up();

		var start_date = $('#StartDate').find('input').val();
		var end_date = $('#EndDate').find('input').val();

		if ( !empty(start_date) && !empty(end_date) ) {
			pt.getLists();
		}
	}, // end - start_up

	setting_up: function() {
		var today = moment(new Date()).format('YYYY-MM-DD');

		$("#StartDate").datetimepicker({
            locale: 'id',
            format: 'DD MMM Y'
        });

        $("#EndDate").datetimepicker({
            locale: 'id',
            format: 'DD MMM Y'
        });

        $("#StartDate").on("dp.change", function (e) {
            var minDate = dateSQL($("#StartDate").data("DateTimePicker").date())+' 00:00:00';
            $("#EndDate").data("DateTimePicker").minDate(moment(new Date(minDate)));
        });
        var start_date = $("#StartDate").find('input').data('tgl');
        if ( !empty(start_date) && empty($("#StartDate").find('input').val()) ) {
        	$("#StartDate").data('DateTimePicker').date(moment(new Date(start_date)));
        }

        $("#EndDate").on("dp.change", function (e) {
            var maxDate = dateSQL($("#EndDate").data("DateTimePicker").date())+' 23:59:59';
            if ( maxDate >= (today+' 00:00:00') ) {
                $("#StartDate").data("DateTimePicker").maxDate(moment(new Date(maxDate)));
            }
        });
        var end_date = $("#EndDate").find('input').data('tgl');
        if ( !empty(end_date) ) {
        	$("#EndDate").data('DateTimePicker').date(moment(new Date(end_date)));
        }

		$("#TglPengajuan").datetimepicker({
            locale: 'id',
            format: 'DD MMM Y',
            minDate: moment(new Date((today+' 00:00:00')))
        });

		$("#Jadwal").datetimepicker({
            locale: 'id',
            format: 'DD MMM Y',
            minDate: moment(new Date((today+' 00:00:00')))
        });

        $("#JamPelaksanaan").datetimepicker({
            locale: 'id',
            format: 'LT'
        });

        $("#JamSelesai").datetimepicker({
            locale: 'id',
            format: 'LT'
        });

        // if ( !empty(start_date) && !empty(end_date) ) {
        // 	pt.getLists();
        // }
	}, // end - setting_up

	showNameFile : function(elm, isLable = 1) {
        var _label = $(elm).closest('label');
        var _a = _label.next('a[name=dokumen]');
        _a.removeClass('hide');
        // var _allowtypes = $(elm).data('allowtypes').split('|');
        var _dataName = $(elm).data('name');
        var _allowtypes = ['jpg', 'JPG', 'jpeg', 'JPEG', 'pdf', 'PDF', 'png', 'PNG'];
        var _type = $(elm).get(0).files[0]['name'].split('.').pop();
        var _namafile = $(elm).val();
        var _temp_url = URL.createObjectURL($(elm).get(0).files[0]);
        _namafile = _namafile.substring(_namafile.lastIndexOf("\\") + 1, _namafile.length);

        if (in_array(_type, _allowtypes)) {
            if (isLable == 1) {
                if (_a.length) {
                    _a.attr('title', _namafile);
                    _a.attr('href', _temp_url);
                    if ( _dataName == 'name' ) {
                        $(_a).text( _namafile );  
                    }
                }
            } else if (isLable == 0) {
                $(elm).closest('label').attr('title', _namafile);
            }
            $(elm).attr('data-filename', _namafile);
        } else {
            $(elm).val('');
            $(elm).closest('label').attr('title', '');
            $(elm).attr('data-filename', '');
            _a.addClass('hide');
            bootbox.alert('Format file tidak sesuai. Mohon attach ulang.');
        }
    }, // end - showNameFile

	pilihJenisPenguji: function (elm) {
		var jenis_penguji = $(elm).val();

		if ( !empty(jenis_penguji) ) {
			var div_penguji = $(elm).closest('div.penguji');
			$.map( $(div_penguji).find('div.dosen_penguji .jenis_dosen'), function(div) {
				if ( $(div).hasClass(jenis_penguji) ) {
					$(div).removeClass('hide');
					$(div).find('input, select').attr('data-required', 1);
				} else {
					$(div).addClass('hide');
					$(div).find('input, select').removeAttr('data-required');
				}
			});
		} else {
			$(div_penguji).find('div.dosen_penguji .jenis_dosen').addClass('hide');
			$(div_penguji).find('div.dosen_penguji .jenis_dosen input, select').removeAttr('data-required');
			$(div_penguji).find('div.dosen_penguji .jenis_dosen:first').removeClass('hide');
			$(div_penguji).find('div.dosen_penguji .jenis_dosen:first  input, select').attr('data-required', 1);
		}
	}, // end - pilihJenisPenguji

	kelengkapanBlangko: function(elm) {
		var dcontent = $('div#list_kelengkapan');

		var val = $(elm).find('option:selected').attr('data-jpkode');

		if ( !empty(val) ) {
			$.ajax({
	            url : 'transaksi/PelaksanaanTA/kelengkapanBlangko',
	            data : {
	                'jenis_pengajuan_kode' : val
	            },
	            type : 'GET',
	            dataType : 'HTML',
	            beforeSend : function(){ showLoading(); },
	            success : function(html){
	                hideLoading();
	                $(dcontent).html(html);
	            },
	        });
		} else {
			$(dcontent).html('');
		}
	}, // end - kelengkapanBlangko

	changeTabActive: function(elm) {
        var vhref = $(elm).data('href');
        var edit = $(elm).data('edit');
        // change tab-menu
        $('.nav-tabs').find('a').removeClass('active');
        $('.nav-tabs').find('a').removeClass('show');
        $('.nav-tabs').find('li a[data-tab='+vhref+']').addClass('show');
        $('.nav-tabs').find('li a[data-tab='+vhref+']').addClass('active');

        // change tab-content
        $('.tab-pane').removeClass('show');
        $('.tab-pane').removeClass('active');
        $('div#'+vhref).addClass('show');
        $('div#'+vhref).addClass('active');

        if ( vhref == 'action' ) {
            var v_id = $(elm).attr('data-id');

            pt.loadForm(v_id, edit);
        };
    }, // end - changeTabActive

    loadForm: function(v_id = null, resubmit = null) {
        var dcontent = $('div#action');

        $.ajax({
            url : 'transaksi/PelaksanaanTA/loadForm',
            data : {
                'id' :  v_id,
                'resubmit' : resubmit
            },
            type : 'GET',
            dataType : 'HTML',
            beforeSend : function(){ showLoading(); },
            success : function(html){
                hideLoading();
                $(dcontent).html(html);
                pt.setting_up();
            },
        });
    }, // end - loadForm

	getLists: function() {
		var dcontent = $('div#riwayat');

		var err = 0;
		$.map( $(dcontent).find('[data-required=1]'), function(ipt) {
			if ( empty( $(ipt).val() ) ) {
				$(ipt).parent().addClass('has-error');
				err++;
			} else {
				$(ipt).parent().removeClass('has-error');
			}
		});

		if ( err > 0 ) {
			bootbox.alert('Harap isi periode terlebih dahulu.');
		} else {
			var params = {
				'jenis_pengajuan_kode': $(dcontent).find('.jenis_pengajuan').val()
			};

			$.ajax({
	            url : 'transaksi/PelaksanaanTA/getLists',
	            type : 'GET',
	            dataType : 'HTML',
	            data: {
	            	'params': params
	            },
	            beforeSend : function(){ showLoading(); },
	            success : function(html){
	                hideLoading();
	                $(dcontent).find('table tbody').html( html );
	            },
	        });
		}
	}, // end - getLists

	save: function()  {
		var dcontent = $('div#action');

		var err = 0;
		$.map( $(dcontent).find('[data-required=1]'), function(ipt) {
			if ( empty( $(ipt).val() ) ) {
				if ( $(ipt).hasClass('file_lampiran') ) {
					var label = $(ipt).closest('label');
					$(label).find('div.btn').css({
						'color': '#a94442',
						'border-color': '#a94442'
					});
				} else {
					$(ipt).parent().addClass('has-error');
				}

				err++
			} else {
				$(ipt).parent().removeClass('has-error');
			}
		});

		if ( err > 0 ) {
			bootbox.alert('Harap lengkapi data wajib terlebih dahulu.');
		} else {
			bootbox.confirm('Apakah anda yakin ingin mnyimpan data Pengajuan ?', function(result) {
				if ( result ) {
					var formData = new FormData();

					var list_kelengkapan_blangko = $.map( $(dcontent).find('.kelengkapan'), function(div) {
						var lampiran = $(div).find('input.file_lampiran').val();
						var kode = $(div).data('kode');
						if ( !empty(lampiran) ) {
							var file_tmp = $(div).find('input.file_lampiran').get(0).files[0];
							formData.append('lampiran['+kode+']', file_tmp);
						}

						var _data = {
							'kode': $(div).data('kode')
						};

						return _data;
					});

					var file_tmp = $(dcontent).find('input.blangko').get(0).files[0];
					formData.append('lampiran[blangko]', file_tmp);

					var data = {
						'pengajuan_kode': $(dcontent).find('.pengajuan').val(),
						'list_kelengkapan_blangko': list_kelengkapan_blangko
					};

					formData.append('data', JSON.stringify(data));

					$.ajax({
			            url : 'transaksi/PelaksanaanTA/save',
			            type : 'POST',
			            dataType : 'JSON',
			            async:false,
			            processData: false,
			            contentType: false,
			            data: formData,
			            beforeSend : function(){ showLoading(); },
			            success : function(data){
			                hideLoading();
			                if ( data.status == 1 ) {
			                	bootbox.alert(data.message, function() {
			                		pt.loadForm(data.content.id);
			                	});
			                } else {
			                	bootbox.alert(data.message);
			                }
			            },
			        });
				}
			});
		}
	}, // end - save

	delete: function(elm) {
		var kode = $(elm).data('kode');

		bootbox.confirm('Apakah anda yakin ingin meng-hapus data ?', function(result) {
			if ( result ) {
				$.ajax({
		            url : 'transaksi/PelaksanaanTA/delete',
		            type : 'POST',
		            dataType : 'JSON',
		            data: {
		            	'params': kode
		            },
		            beforeSend : function(){ showLoading(); },
		            success : function(data){
		                hideLoading();
		                if ( data.status == 1 ) {
		                	bootbox.alert(data.message, function() {
		                		pt.loadForm();
		                	});
		                } else {
		                	bootbox.alert(data.message);
		                }
		            },
		        });
			}
		});
	}, // end - delete
};

pt.start_up();