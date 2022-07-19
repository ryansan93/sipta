create table skp_mitra (
	id int primary key identity not null,
	nomor varchar(6) not null,
	mulai date,
	berakhir date,
	lampiran varchar(250)
)