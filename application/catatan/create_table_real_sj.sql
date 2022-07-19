create table real_sj (
	id int primary key identity not null,
	id_unit int not null,
	unit varchar(100) not null,
	tgl_panen date not null,
	noreg varchar(15) not null,
	ekor int,
	kg decimal(8, 2),
	bb decimal(6, 2),
	tara decimal(6, 2),
	netto_ekor int,
	netto_kg decimal(8, 2),
	netto_bb decimal(6, 2)
)

create table det_real_sj (
	id int primary key identity not null,
	id_header int not null,
	id_det_rpah int not null,
	no_pelanggan varchar(6),
	pelanggan varchar(100),
	tonase decimal(8, 2),
	ekor int,
	bb decimal(6, 2),
	harga int
)