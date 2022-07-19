create table retur_voadip (
	id int primary key identity not null,
	tgl_retur date not null,
	tgl_order date not null,
	no_order varchar(10) not null,
	mitra varchar(6) not null
)

create table det_retur_voadip (
	id int primary key not null,
	id_retur int not null,
	perusahaan varchar(5),
	kategori varchar(50),
	kode_brg varchar(10),
	kemasan varchar(25),
	jml_order int,
	jml_retur int
)