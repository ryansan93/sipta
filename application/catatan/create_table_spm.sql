create table pakan_rcnkirim (
	id int primary key not null,
	tgl_trans datetime not null,
	user_submit	varchar(10) not null
)

create table pakan_det_rcnkirim(
	id int primary key not null,
	id_rcnkirim	int not null,
	unit int not null,
	noreg varchar(15),
	umur int,
	pakan varchar(10),
	tgl_kirim datetime,
	jml_kirim decimal(9, 2),
	zak_kirim int,
	ekspedisi varchar(6)
)

create table pakan_spm (
	id_spm int primary key not null,
	no_spm varchar(10) not null,
	tgl_spm	date not null,
	total_spm decimal(9, 2),
	zak_spm	int,
	ekspedisi varchar(6),
	tgl_cetak datetime
)

create table det_pakanspm (
	id_detspm int primary key not null,
	id_spm int not null,
	id_detrcnkirim int not null
)

create table pakan_terima (
	id int primary key not null,
	id_detspm int not null,
	unit int not null,
	noreg varchar(15) not null,
	tgl_terima datetime,
	ekspedisi varchar(10),
	no_sj varchar(15),
	nama_sopir varchar(50),
	nopol varchar(10),
	pakan_terima varchar(50),
	zak_terima int,
	kg_terima decimal(10, 2)    
)