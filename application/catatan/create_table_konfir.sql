create table konfir (
	id int primary key identity not null,
	noreg varchar(15) not null,
	tgl_docin date,
	tgl_panen date,
	populasi int,
	bb_rata2 decimal(6, 2),
	total decimal(8, 2)
)

create table det_konfir (
	id int primary key not null,
	id_konfir int not null,
	jumlah int,
	bb decimal(6, 2)
)