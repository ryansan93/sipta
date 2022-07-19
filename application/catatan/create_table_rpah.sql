create table rpah (
	id int primary key identity not null,
	id_unit int not null,
	unit varchar(50),
	tgl_panen date,
	bottom_price int,
	g_status tinyint
)

create table det_rpah (
	id int primary key not null,
	id_rpah int not null,
	id_konfir int not null,
	noreg varchar(15),
	no_pelanggan varchar(6),
	pelanggan varchar(100),
	outstanding int,
	tonase decimal(8, 2),
	ekor int,
	bb decimal(6, 2),
	harga int
)