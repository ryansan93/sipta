var rp = {
	start_up: function () {
		rp.setting_up();

		var start_date = $('#StartDate').find('input').val();
		var end_date = $('#EndDate').find('input').val();

		if ( !empty(start_date) && !empty(end_date) ) {
			rp.getLists();
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

		$("#WaktuKonsul").datetimepicker({
            locale: 'id',
            format: 'DD MMM Y',
            minDate: moment(new Date((today+' 00:00:00')))
        });
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

	kelengkapanPengajuan: function(elm) {
		var dcontent = $('div.formPengajuan');

		var val = $(elm).val();

		if ( !empty(val) ) {
			$.ajax({
	            url : 'transaksi/RancanganProposal/kelengkapanPengajuan',
	            data : {
	                'jenis_pengajuan_kode' : val
	            },
	            type : 'GET',
	            dataType : 'HTML',
	            beforeSend : function(){ showLoading(); },
	            success : function(html){
	                hideLoading();
	                $(dcontent).html(html);

	                rp.setting_up();
	            },
	        });
		} else {
			$(dcontent).html('');
		}
	}, // end - kelengkapanPengajuan

	mahasiswa: function(elm) {
		var dcontent = $(elm).closest('div#action');

		var val = $(elm).val();

		$(dcontent).find('select.mahasiswa option').removeClass('hide');

		if ( !empty(val) ) {
			$(dcontent).find('select.mahasiswa').val('');
			rp.setDataMahasiswa();

			$(dcontent).find('select.mahasiswa').removeAttr('disabled');
			$(dcontent).find('select.mahasiswa option:not([data-prodi='+val+'])').addClass('hide');
		} else {
			$(dcontent).find('select.mahasiswa').attr('disabled', 'disabled');
			$(dcontent).find('select.mahasiswa').val('');

			rp.setDataMahasiswa();
		}
	}, // end - mahasiswa

	setDataMahasiswa: function() {
		var dcontent = $('div#action');

		var select_mahasiswa = $(dcontent).find('select.mahasiswa');

		var val = $(select_mahasiswa).val();

		if ( !empty(val) ) {
			var no_telp = $(dcontent).find('select.mahasiswa option:selected').data('notelp');
			var nim = $(dcontent).find('select.mahasiswa option:selected').data('nim');

			$(dcontent).find('input.no_telp').val(no_telp);
			$(dcontent).find('input.nim').val(nim);
		} else {
			$(dcontent).find('input.no_telp').val('');
			$(dcontent).find('input.nim').val('');
		}
	}, // end - setDataMahasiswa

	setJudulPenelitian: function(elm) {
		var dcontent = $('div#action');

		if ( !empty($(elm).val()) ) {
			var opt = $(elm).find('option:selected');
			var jp = $(opt).data('jp');

			$(dcontent).find('input.judul_penelitian').val( jp );
		} else {
			$(dcontent).find('input.judul_penelitian').val('');
		}
	}, // end - setJudulPenelitian

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

            rp.loadForm(v_id, edit);
        };
    }, // end - changeTabActive

    loadForm: function(v_id = null, resubmit = null) {
        var dcontent = $('div#action');

        $.ajax({
            url : 'transaksi/RancanganProposal/loadForm',
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
                rp.setting_up();
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
			var start_date = dateSQL($(dcontent).find('#StartDate').data('DateTimePicker').date());
			var end_date = dateSQL($(dcontent).find('#EndDate').data('DateTimePicker').date());

			var params = {
				'start_date': start_date,
				'end_date': end_date
			};

			$.ajax({
	            url : 'transaksi/RancanganProposal/getLists',
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

					var list_pembimbing = $.map( $(dcontent).find('div.pembimbing'), function(div) {
						var pembimbing = $(div).find('select.pembimbing option:selected').attr('data-nama');
						var nip = $(div).find('select.pembimbing').val();
						var no_tlp = $(div).find('input.no_telp_pembimbing').val();

						if ( !empty(nip) ) {
							var _data = {
								'nip': nip,
								'pembimbing': pembimbing,
								'no_telp': no_tlp
							};

							return _data;
						}
					});

					var list_penguji = $.map( $(dcontent).find('.penguji'), function(div) {
						var div_dosen_penguji = $(div).find('div.dosen_penguji');

						var jenis_penguji = $(div).find('.jenis_penguji').val();

						var nip = null;
						var penguji = null;
						if ( jenis_penguji == 'luar' ) {
							penguji = $(div_dosen_penguji).find('input').val();
						} else {
							penguji = $(div_dosen_penguji).find('select option:selected').attr('data-nama');
							nip = $(div_dosen_penguji).find('select').val();
						}

						if ( !empty(penguji) ) {
							var _data = {
								'jenis_penguji': jenis_penguji,
								'nip': nip,
								'penguji': penguji
							};

							return _data;
						}
					});

					var list_kelengkapan_pengajuan = $.map( $(dcontent).find('.kelengkapan_pengajuan'), function(div) {
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

					var data = {
						'prodi_kode': $(dcontent).find('.prodi').val(),
						'nim': $(dcontent).find('.nim').val(),
						'no_telp': $(dcontent).find('.no_telp').val(),
						'judul_penelitian': $(dcontent).find('.judul_penelitian').val(),
						'tahun_akademik': $(dcontent).find('.tahun_akademik').val(),
						'list_pembimbing': list_pembimbing,
						'list_penguji': list_penguji,
						'jadwal': dateSQL( $(dcontent).find('#WaktuKonsul').data('DateTimePicker').date() ),
						'list_kelengkapan_pengajuan': list_kelengkapan_pengajuan
					};

					formData.append('data', JSON.stringify(data));

					$.ajax({
			            url : 'transaksi/RancanganProposal/save',
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
			                		rp.loadForm(data.content.id);

			                		var start_date = $('#StartDate').find('input').val();
									var end_date = $('#EndDate').find('input').val();

			                		if ( !empty(start_date) && !empty(end_date) ) {
			                			rp.getLists();
			                		}
			                	});
			                } else {
			                	bootbox.alert(data.message);
			                }
			            },
			        });
				}
			});
		}
	}, // end - save_semhas

	delete: function(elm) {
		var kode = $(elm).data('kode');

		bootbox.confirm('Apakah anda yakin ingin meng-hapus data ?', function(result) {
			if ( result ) {
				$.ajax({
		            url : 'transaksi/RancanganProposal/delete',
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
		                		rp.loadForm();

		                		var start_date = $('#StartDate').find('input').val();
								var end_date = $('#EndDate').find('input').val();

		                		if ( !empty(start_date) && !empty(end_date) ) {
		                			rp.getLists();
		                		}
		                	});
		                } else {
		                	bootbox.alert(data.message);
		                }
		            },
		        });
			}
		});
	}, // end - delete

	approve_reject: function(elm) {
		var dcontent = $('div#action');
		var err = 0;

		var jenis = $(elm).data('jenis');

		if ( jenis == 'approve' ) {
			$.map( $(dcontent).find('[data-required=1]'), function(ipt) {
				if ( empty($(ipt).val()) ) {
					$(ipt).parent().addClass('has-error');
					err++;
				} else {
					$(ipt).parent().removeClass('has-error');
				}
			});
		}

		if ( err > 0 ) {
			bootbox.alert('Harap lengkapi data terlebih dahulu.');
		} else {
			var kode = $(elm).data('kode');

			bootbox.confirm('Apakah anda yakin ingin '+jenis.toUpperCase()+' data ?', function(result) {
				if ( result ) {
					var list_pembimbing = $.map( $(dcontent).find('div.pembimbing'), function(div) {
						var pembimbing = $(div).find('select.pembimbing option:selected').attr('data-nama');
						var nip = $(div).find('select.pembimbing').val();
						var no_tlp = $(div).find('input.no_telp_pembimbing').val();

						if ( !empty(nip) ) {
							var _data = {
								'nip': nip,
								'pembimbing': pembimbing,
								'no_telp': no_tlp
							};

							return _data;
						}
					});

					var list_penguji = $.map( $(dcontent).find('.penguji'), function(div) {
						var div_dosen_penguji = $(div).find('div.dosen_penguji');

						var jenis_penguji = $(div).find('.jenis_penguji').val();

						var nip = null;
						var penguji = null;
						if ( jenis_penguji == 'luar' ) {
							penguji = $(div_dosen_penguji).find('input').val();
						} else {
							penguji = $(div_dosen_penguji).find('select option:selected').attr('data-nama');
							nip = $(div_dosen_penguji).find('select').val();
						}

						if ( !empty(penguji) ) {
							var _data = {
								'jenis_penguji': jenis_penguji,
								'nip': nip,
								'penguji': penguji
							};

							return _data;
						}
					});

					var params = {
						'kode': kode,
						'jenis': jenis,
						'list_pembimbing': list_pembimbing,
						'list_penguji': list_penguji
					};

					$.ajax({
			            url : 'transaksi/RancanganProposal/approve_reject',
			            type : 'POST',
			            dataType : 'JSON',
			            data: {
			            	'params': params
			            },
			            beforeSend : function(){ showLoading(); },
			            success : function(data){
			                hideLoading();
			                if ( data.status == 1 ) {
			                	bootbox.alert(data.message, function() {
			                		rp.loadForm(data.content.kode);

			                		var start_date = $('#StartDate').find('input').val();
									var end_date = $('#EndDate').find('input').val();

			                		if ( !empty(start_date) && !empty(end_date) ) {
			                			rp.getLists();
			                		}
			                	});
			                } else {
			                	bootbox.alert(data.message);
			                }
			            },
			        });
				}
			});
		}
	}, // end - approve_reject
};

rp.start_up();