create table kirim_pakan (
	id int primary key identity not null,
	tgl_trans datetime,
	tgl_kirim date,
	no_order varchar(15),
	jenis_kirim varchar(10),
	asal varchar(50),
	jenis_tujuan varchar(10),
	tujuan varchar(25),
	ekspedisi varchar(25),
	no_polisi varchar(15),
	sopir varchar(50),
	no_sj varchar(15)
)

create table det_kirim_pakan (
	id int primary key identity not null,
	id_header int,
	item varchar(10),
	jumlah int,
	kondisi varchar(25)
)